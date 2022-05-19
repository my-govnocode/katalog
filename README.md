# Docker: Nginx + MySql + PHP

**Инструкция по установке**

1) Загрузить код
```
git clone https://github.com/my-govnocode/katalog.git
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
