# Docker: Nginx + MySql + PHP
________________

**Инструкция по установке**

1) Загрузить код
```
git clone https://github.com/my-govnocode/Docker.git
```
2) Собрать docker контейнеры
```
docker-compose build
```
3) Запустить контейнеры
```
docker-compose up -d
```

## Важно!
В папке /nginx/conf.d/ размещаются конфигурации nginx для ваших проектов. Для каждого проекта создается свой конфигурационный файл, имя этого файла должно совпадать с именем вашего проекта.

В папке /www/ хранятся ваши прокеты.

В файле docker-compose.yml
```
 mysql:
    image: mysql:8
    ports:
      - "127.0.0.100:3305:3306"
```
Что бы подключится к вашему mysql, например через Workbench в настроках подключения:
    host: 127.0.0.100
    port: 3305

## Структура Docker'а 
```
Docker:
    > images
        > php
            - Dockerfile
            - php.ini
            
    > logs
        - access.log
        - error.log
        
    > mysql
    
    > nginx
        > conf.d
            - project-name.conf
            
    > www
        > project-name
        
    - docker-compose.yml
```
## Laravel
**если вы работаете с проектом на laravel и хотите сделать миграцию:**
1) Узнайть имя запущеных контейнеров
```
docker container ls -a
```
2) Запустить сессию терминала для контейнера в интерактивном режиме
```
docker exec -it имя_php_контейнера bin/sh
```
3) Перейти в папку с проектом
```
cd /var/www/имя_проета
```
4) Сделать миграцию
```
php artisan migrate:fresh --seed
```
