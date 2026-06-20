#!/usr/bin/env bash
set -euo pipefail

# Deploy script for the courier-service stack.
# Usage: ./deploy.sh [branch] [php_replicas]
BRANCH="${1:-v3}"
PHP_REPLICAS="${2:-3}"

cd "$(dirname "$0")"

echo "==> Pulling ${BRANCH}"
git fetch origin "${BRANCH}"
git checkout "${BRANCH}"
git pull origin "${BRANCH}"

echo "==> Building php and cron images"
docker compose build php cron

echo "==> Starting db, cron, nginx and ${PHP_REPLICAS} php replicas"
docker compose up -d --scale "php=${PHP_REPLICAS}" db cron php nginx

echo "==> Validating nginx config"
docker compose exec -T nginx nginx -t

echo "==> Reloading nginx"
docker compose exec -T nginx nginx -s reload

echo "==> Current status"
docker compose ps

echo "==> Done"