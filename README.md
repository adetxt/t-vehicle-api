# Vehicle Transaction

# Getting Started

## Quick

- Run `docker compose up -d`

NB:
- you may need to wait 1-2 min until the app totally up
- you can change public port mapping and ENVAR in `docker-compose.yaml`

## Manual

- Run `cp ./.env.example ./.env`
- Run `php artisan jwt:secret`
- Adjust the db credentials inside `.env` file
- Run `php artisan serve`
