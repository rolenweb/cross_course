# Cross courses

## Installation
1. Clone the repository https://github.com/rolenweb/cross_course
2. Copy .env.example to .env
3. Edit .env
```
    NGINX_HTTP_PORT=80
    NGINX_HTTPS_PORT=443
    #REDIS#
    DOCKER_REDIS_PORT=6379
    DOCKER_REDIS_PASSWORD=password
```
4. Copy src/.env.example to src/.env
5. Edit src/.env
```
CACHE_DRIVER=redis
REDIS_HOST=redis
REDIS_PASSWORD=password
REDIS_PORT=6379
```
6. Run ```make build```(Make tools must be installed before)
7. Run ```make up```
8. Run ```make composer-install```
9. Set 777 permissions for src/storage/app, src/storage/framework, src/storage/logs 

## API
* api/09.12.2022/USD
* api/09.12.2022/EUR/USD

## Test
```make test```