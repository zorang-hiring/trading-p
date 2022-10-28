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
to debug:
```
DOCKER_BUILDKIT=0 docker-compose -f docker/docker-compose.yml --env-file docker/sample.env up --build
```

## TODO

- Docker build issue
  docker-nginx-1    | wait-for-it.sh: timeout occurred after waiting 60 seconds for php-fpm:9000
  docker-nginx-1    | wait-for-it.sh: strict mode, refusing to execute subprocess
  docker-nginx-1 exited with code 124
  Reason: composer install dependencies takes a lot of time, solution is to extend neginx wait timeout or to run docker build again
