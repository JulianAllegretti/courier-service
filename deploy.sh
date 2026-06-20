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

echo "==> Installing dependencies and warming up cache (single run, avoids races across replicas)"
docker compose run --rm --entrypoint "" php sh -c "
  chown -R www-data:www-data /var/www/symfony/var /var/www/symfony/vendor /var/www/symfony/public &&
  su -l -s /bin/sh -c 'cd /var/www/symfony && composer install --no-interaction' www-data
"

echo "==> Starting cron, nginx and ${PHP_REPLICAS} php replicas"
docker compose up -d --scale "php=${PHP_REPLICAS}" cron php nginx

echo "==> Validating nginx config"
docker compose exec -T nginx nginx -t

echo "==> Reloading nginx"
docker compose exec -T nginx nginx -s reload

echo "==> Current status"
docker compose ps

echo "==> Done"