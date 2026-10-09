#!/usr/bin/env bash
# BacaYuk! — Smoke test end-to-end (bash + curl)
# Pakai: bash tests/smoke.sh [BASE_URL]   (default http://localhost:8091)
# Menulis tidak ke mana-mana selain cookie jar sementara di /tmp.

BASE="${1:-http://localhost:8091}"
PASS=0; FAIL=0
declare -a HASIL

ok()   { PASS=$((PASS+1)); HASIL+=("PASS  $1"); }
gagal(){ FAIL=$((FAIL+1)); HASIL+=("FAIL  $1 -- $2"); }

# Ambil pasangan field CSRF dari HTML form (argumen: html)
csrf_dari() {
  local f v
  f=$(printf '%s' "$1" | grep -oE 'name="csrf[^"]*"' | head -1 | sed 's/name="//; s/"$//')
  v=$(printf '%s' "$1" | grep -oE 'name="csrf[^"]*" value="[^"]*"' | head -1 | sed 's/.*value="//; s/"$//')
  printf '%s=%s' "$f" "$v"
}

# Login satu role. Argumen: user password jar dashboard_path kata_kunci_dashboard
login_role() {
  local user="$1" pw="$2" jar="$3" dash="$4" kunci="$5"
  local html token kode target
  html=$(curl -s -c "$jar" "$BASE/login")
  token=$(csrf_dari "$html")
  kode=$(curl -s -b "$jar" -c "$jar" -o /tmp/smoke-dash.html -w '%{http_code}' \
           -d "$token&username=$user&password=$pw" "$BASE/login")
  # setelah POST login sukses, ambil dashboard secara eksplisit
  kode=$(curl -s -b "$jar" -o /tmp/smoke-dash.html -w '%{http_code}' "$BASE$dash")
  if [ "$kode" = "200" ] && grep -q "$kunci" /tmp/smoke-dash.html && ! grep -q "Whoops" /tmp/smoke-dash.html; then
    ok "login $user -> $dash (200)"
  else
    gagal "login $user -> $dash" "kode=$kode kunci='$kunci' tidak cocok"
  fi
}

# GET halaman dengan jar, harap 200 tanpa Whoops. Argumen: jar path label
cek_halaman() {
  local jar="$1" path="$2" label="$3" kode
  kode=$(curl -s -b "$jar" -o /tmp/smoke-page.html -w '%{http_code}' "$BASE$path")
  if [ "$kode" = "200" ] && ! grep -q "Whoops" /tmp/smoke-page.html; then
    ok "GET $path ($label) 200"
  else
    gagal "GET $path ($label)" "kode=$kode whoops=$(grep -c Whoops /tmp/smoke-page.html)"
  fi
}

JAR_A=/tmp/smoke-jar-admin.txt; JAR_G=/tmp/smoke-jar-guru.txt; JAR_S=/tmp/smoke-jar-siswa.txt
rm -f "$JAR_A" "$JAR_G" "$JAR_S"

echo "== Smoke test BacaYuk di $BASE =="

# 1) Halaman login tampil
KODE=$(curl -s -o /tmp/smoke-login.html -w '%{http_code}' "$BASE/login")
if [ "$KODE" = "200" ]; then ok "GET /login tampil (200)"; else gagal "GET /login" "kode=$KODE"; fi

# 2) Login tiga role
login_role admin admin123 "$JAR_A" /admin "Total User"
login_role guru  guru123  "$JAR_G" /guru  "Menunggu Verifikasi"
login_role siswa siswa123 "$JAR_S" /siswa "Misi membaca"

# 3) Penjagaan role
KODE=$(curl -s -b "$JAR_S" -o /dev/null -w '%{http_code}' "$BASE/admin")
if [ "$KODE" != "200" ]; then ok "siswa membuka /admin ditolak (kode $KODE)"; else gagal "siswa membuka /admin" "malah 200"; fi

LOC=$(curl -s -o /dev/null -w '%{http_code} %{redirect_url}' "$BASE/siswa")
case "$LOC" in
  *login*) ok "tamu membuka /siswa diarahkan ke login ($LOC)" ;;
  *) gagal "tamu membuka /siswa" "hasil: $LOC" ;;
esac

# 4) Alur jurnal: siswa buat -> menunggu -> guru verifikasi -> terverifikasi
# Catatan: server menimpa judul_buku dengan judul buku terpilih, jadi penanda
# unik memakai teks ringkasan (tersimpan & tampil apa adanya di kartu jurnal).
TANDA="Ringkasan uji asap $(date +%H%M%S)"
TGL=$(date +%F)
FORM=$(curl -s -b "$JAR_S" "$BASE/siswa/jurnal/baru")
TOKEN=$(csrf_dari "$FORM")
KODE=$(curl -s -b "$JAR_S" -c "$JAR_S" -o /dev/null -w '%{http_code}' \
  --data-urlencode "$TOKEN" \
  --data-urlencode "buku_id=1" \
  --data-urlencode "judul_buku=Si Kancil Anak Cerdik" \
  --data-urlencode "tanggal=$TGL" \
  --data-urlencode "halaman_dari=1" \
  --data-urlencode "halaman_sampai=10" \
  --data-urlencode "durasi_menit=15" \
  --data-urlencode "ringkasan=$TANDA" \
  --data-urlencode "pesan_cerita=Pesan cerita uji asap." \
  --data-urlencode "rating=5" \
  --data-urlencode "perasaan=😊" \
  "$BASE/siswa/jurnal")
curl -s -b "$JAR_S" "$BASE/siswa/jurnal" -o /tmp/smoke-jurnal.html

# Status kartu yang memuat penanda: badge di dalam <div class="card ... yang sama
python3 - "$TANDA" <<'PY' > /tmp/smoke-status.txt
import re, sys
html = open('/tmp/smoke-jurnal.html', encoding='utf-8', errors='ignore').read()
i = html.find(sys.argv[1])
if i < 0:
    print('tidak-ada'); sys.exit()
awal = html.rfind('<div class="card', 0, i)
blok = html[awal:i]
m = re.findall(r'>(menunggu|terverifikasi|revisi)<', blok)
print(m[-1] if m else 'tanpa-status')
PY
if [ "$(cat /tmp/smoke-status.txt)" = "menunggu" ]; then
  ok "siswa membuat jurnal (POST $KODE) & muncul berstatus menunggu"
else
  gagal "siswa membuat jurnal" "POST kode=$KODE, status kartu=$(cat /tmp/smoke-status.txt)"
fi

# Ambil ID jurnal QA dari tautan edit pertama SETELAH penanda unik
JID=$(python3 - "$TANDA" <<'PY'
import re, sys
html = open('/tmp/smoke-jurnal.html', encoding='utf-8', errors='ignore').read()
i = html.find(sys.argv[1])
m = re.search(r'siswa/jurnal/edit/(\d+)', html[i:]) if i >= 0 else None
print(m.group(1) if m else '')
PY
)

if [ -n "$JID" ]; then
  VER=$(curl -s -b "$JAR_G" "$BASE/guru/verifikasi")
  TOKEN_G=$(csrf_dari "$VER")
  KODE_V=$(curl -s -b "$JAR_G" -c "$JAR_G" -o /dev/null -w '%{http_code}' \
    --data-urlencode "$TOKEN_G" \
    --data-urlencode "catatan_guru=Bagus, lanjutkan!" \
    --data-urlencode "status=terverifikasi" \
    "$BASE/guru/verifikasi/$JID")
  curl -s -b "$JAR_S" "$BASE/siswa/jurnal" -o /tmp/smoke-jurnal2.html
  python3 - "$TANDA" <<'PY' > /tmp/smoke-cek.txt
import re, sys
html = open('/tmp/smoke-jurnal2.html', encoding='utf-8', errors='ignore').read()
i = html.find(sys.argv[1])
if i < 0:
    print('belum'); sys.exit()
awal = html.rfind('<div class="card', 0, i)
blok = html[awal:i]
m = re.findall(r'>(menunggu|terverifikasi|revisi)<', blok)
print(m[-1] if m else 'belum')
PY
  if [ "$(cat /tmp/smoke-cek.txt)" = "terverifikasi" ]; then
    ok "guru memverifikasi jurnal #$JID (POST $KODE_V) & status siswa jadi terverifikasi"
  else
    gagal "guru memverifikasi jurnal #$JID" "POST kode=$KODE_V, status di daftar siswa belum terverifikasi"
  fi
else
  gagal "mengambil ID jurnal QA" "tautan edit tidak ditemukan di daftar siswa"
fi

# 5) Sapuan halaman utama tiga role
for p in /siswa /siswa/jurnal /siswa/jurnal/baru /siswa/buku /siswa/lencana /siswa/peringkat; do
  cek_halaman "$JAR_S" "$p" siswa
done
for p in /guru /guru/verifikasi /guru/jurnal /guru/siswa /buku /buku/baru; do
  cek_halaman "$JAR_G" "$p" guru
done
for p in /admin /admin/users /admin/users/baru /admin/kelas /admin/lencana /admin/jurnal; do
  cek_halaman "$JAR_A" "$p" admin
done

echo
echo "================ HASIL ================"
printf '%s\n' "${HASIL[@]}"
echo "---------------------------------------"
echo "PASS: $PASS   FAIL: $FAIL"
[ "$FAIL" -eq 0 ]
