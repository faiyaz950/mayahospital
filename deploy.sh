#!/bin/bash
# Uploads the website (maya-hospital-upload.zip contents) to Hostinger over FTP.
# Run it yourself:  bash deploy.sh
# The FTP password is typed by you at the prompt; it is never saved or shown.
set -euo pipefail

FTP_HOST="82.25.120.201"
FTP_USER="u890809717"
ZIP="maya-hospital-upload.zip"

cd "$(dirname "$0")"
[ -f "$ZIP" ] || { echo "❌ $ZIP nahi mili. Pehle zip banni chahiye."; exit 1; }

read -r -s -p "FTP password (type karein, screen par nahi dikhega): " FTP_PASS; echo
NETRC="machine $FTP_HOST login $FTP_USER password $FTP_PASS"

# Server certificate is issued for *.hstgr.io, not the IP, so it cannot be verified (user accepted this).
# Timeouts make a stalled transfer fail fast so it can be retried.
ftp() { curl --silent --show-error --ssl --insecure --connect-timeout 20 --max-time 180 --speed-limit 1024 --speed-time 25 --netrc-file <(printf '%s\n' "$NETRC") "$@"; }

echo "🔌 Server se connect ho raha hai..."
ROOT_LIST=$(ftp --list-only "ftp://$FTP_HOST/") || { echo "❌ Login fail. Username/password check karein."; exit 1; }

if grep -qx "public_html" <<<"$ROOT_LIST"; then
  TARGET="public_html"
elif grep -qx "domains" <<<"$ROOT_LIST"; then
  TARGET="domains/maya-hospital.in/public_html"
else
  echo "❌ public_html folder nahi mila. Server par ye folders hain:"; echo "$ROOT_LIST"; exit 1
fi
echo "📁 Upload folder: /$TARGET"

TMP=$(mktemp -d)
trap 'rm -rf "$TMP"' EXIT
unzip -q "$ZIP" -d "$TMP"

FILES=()
while IFS= read -r -d '' f; do FILES+=("${f#./}"); done < <(cd "$TMP" && find . -type f -print0 | sort -z)
TOTAL=${#FILES[@]}

# One file per request, up to 4 tries each (Hostinger sometimes drops a data connection).
STILL=()
n=0
for rel in "${FILES[@]}"; do
  n=$((n + 1))
  ok=0
  for attempt in 1 2 3 4; do
    if (cd "$TMP" && ftp --ftp-create-dirs -T "$rel" "ftp://$FTP_HOST/$TARGET/$rel") 2>/dev/null; then
      ok=1; break
    fi
    sleep 3
  done
  if [ "$ok" = 1 ]; then
    printf '  ✔ [%s/%s] %s%s\n' "$n" "$TOTAL" "$rel" "$([ "$attempt" -gt 1 ] && echo " (try $attempt)")"
  else
    printf '  ✖ [%s/%s] %s\n' "$n" "$TOTAL" "$rel"; STILL+=("$rel")
  fi
done

echo
if [ ${#STILL[@]} -eq 0 ]; then
  echo "✅ Saari $TOTAL files upload ho gayi: /$TARGET"
  echo "Ab Step 3 se aage karein (database + config.local.php)."
else
  echo "⚠️  $(( TOTAL - ${#STILL[@]} ))/$TOTAL files upload hui. Ye files nahi gayi:"
  printf '   - %s\n' "${STILL[@]}"
  echo "Script dobara chalayein — jo files ja chuki hain wo bas overwrite ho jayengi."
  exit 1
fi
