# trading-p

## Requirements

1. Docker
2. free port 8080 (for web app)

## Installation

##### 1. Clone repo

```
git clone https://github.com/zorang-hiring/trading-p
```

##### 2. Run Docker
```
docker-compose -f docker/docker-compose.yml --env-file docker/sample.env up --build
```
to debug (todo remove):
```
DOCKER_BUILDKIT=0 docker-compose -f docker/docker-compose.yml --env-file docker/sample.env up --build
```
Note: if you get timeout message because of some reason (e.g. slow local computer or internet connection) 
just run command twice or more.

## Usage:

Open page: `http://127.0.0.1:8080`
And enjoy.

## Tests!

**Coverage is total - 100.00%!**

Run Backend tests with coverage:
```
docker exec --workdir /var/www/current docker-php-fpm-1 php bin/phpunit --coverage-text
```
Note: 'docker-php-fpm-1' should be your php docker container name. If you have different container name on your
local computer then just update the command.

## TODO

- Docker build issue
  docker-nginx-1    | wait-for-it.sh: timeout occurred after waiting 60 seconds for php-fpm:9000
  docker-nginx-1    | wait-for-it.sh: strict mode, refusing to execute subprocess
  docker-nginx-1 exited with code 124
  Reason: composer install dependencies takes a lot of time, solution is to extend neginx wait timeout or to run docker build again
- env variables env.dist, uputstvo itd.
