APP?=php
TIME_START?=''
TIME_END?=''
DAYS?=''

connect:
	docker compose exec ${APP} bash
restart:
	docker compose restart
restart_app:
	docker compose restart ${APP}
rebuild:
	docker compose up -d --build
down:
	docker compose down
down_app:
	docker compose down ${APP}
start:
	docker compose up -d
start_app:
	docker compose up -d ${APP}
cron:
	docker compose exec php bash -c '/usr/local/bin/php -d memory_limit=256M bin/console app:generate-report ${TIME_START} ${TIME_END} ${DAYS} --env="$$APP_ENV"'