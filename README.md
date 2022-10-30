# trading-p

## About

Application is developed using Dicker, PHP, Symfony, Javascript. 
It's composed of 2 parts: API (Backend) and small SPA which operates dynamically without Web page refreshing.

Most important App Folders:
- `./tests` (contains API BE tests with 100% coverage)
- `./src` Backed code (PHP)
- `./assets` source code of Frontend Business Logic (Single Page Application)
- `./docker` Docker code
- `./templates` HTML view file

## Requirements

1. Docker
2. free port 8080 (for web app)

## Installation

##### 1. Clone repo

```
git clone https://github.com/zorang-hiring/trading-p
```

##### 2. Configure Env Variables
From `./.env.dist` create `./.env` (in project root folder). Configure Mailer variables to be able to send emails.

##### 3. Run Docker
```
docker-compose -f docker/docker-compose.yml --env-file docker/sample.env up --build
```
_Note: Build is massive, so if you get timeout message because of some reason 
(e.g. slow local computer or internet connection) just run command twice or more.
It might happen that nginx container will go down if build takes too much time. 
Just run it again if it happens._

## Usage:

Open page: `http://127.0.0.1:8080`
And enjoy.

## Tests!

**Coverage is total - 100.00%! (Backend)**

Run tests with coverage:
```
docker exec --workdir /var/www/current docker-php-fpm-1 php bin/phpunit --coverage-text
```

_Note: frontend tests (JavaScript) have not been done 
because majority or the logic in on the backend._

## Dev Frontend

To compile files
```
docker exec --workdir /var/www/current docker-node-1 npm run dev
```

To watch files
```
docker exec --workdir /var/www/current docker-node-1 npm run watch
```
