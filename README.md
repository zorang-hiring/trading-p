# trading-p

# Requirements

1. Docker
2. free ports 8081 (for API) and 8080 (for UI)

# Installation

##### 1. Clone repo

```
git clone https://github.com/zorang-hiring/trading-p
```

##### 2. Instal Composer dependencies 
todo remove
```
php composer.phar install --ignore-platform-reqs
```
##### 3. Run Docker
```
docker-compose -f docker/docker-compose.yml --env-file docker/sample.env up --build
```
to debug:
```
DOCKER_BUILDKIT=0 docker-compose -f docker/docker-compose.yml --env-file docker/sample.env up --build
```