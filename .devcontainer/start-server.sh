#!/usr/bin/env bash
# Start the CodeIgniter dev server detached from the current shell
# so it survives after the postStartCommand exits.

set -e

cd /var/www/html

mkdir -p writable/logs
LOG=writable/logs/spark-serve.log

# Kill any previous spark serve / built-in PHP server bound to :8080.
# Match only the php process (not the shell wrapper running this script).
pkill -f "php spark serve" 2>/dev/null || true
pkill -f "php -S 0.0.0.0:8080" 2>/dev/null || true

# Use CodeIgniter's spark serve (wraps PHP's built-in server with CI's
# rewrite rules). setsid + nohup detaches from the shell so the process
# keeps running after postStartCommand returns.
setsid nohup php spark serve --host 0.0.0.0 --port 8080 \
    > "$LOG" 2>&1 < /dev/null &

disown 2>/dev/null || true

# Give it a moment to bind, then verify.
sleep 2
if pgrep -f "spark serve" >/dev/null 2>&1; then
    echo "Dev server running on http://localhost:8080 (log: $LOG)"
else
    echo "Failed to start dev server. Last log lines:"
    tail -n 50 "$LOG" || true
    exit 1
fi
