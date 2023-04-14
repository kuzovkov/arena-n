### Инструкция по развертыванию сайта на сервере и использованию

#### 1. Развертывание

##### 1.1. Загрузить папку с сайтом на сервер, таким образом, чтобы в публичной папке веб-сервера находилась папка web приложения
Пример настройки для Nginx:
```conf
   server {
       listen          80;
       listen         443 ssl http2;
       server_name arena.kuzovkov12.ru;
       #SSL
       if ($scheme = http) {
           return 301 https://$server_name$request_uri;
       }

       root /var/www/html/web;

       location / {
               try_files $uri /app.php$is_args$args;
       }

       location ~ ^/(app_dev|info|config|cc|cc-dev)\.php(/|$) {
               fastcgi_pass unix:/run/php/php7.1-fpm.sock;
               fastcgi_split_path_info ^(.+\.php)(/.*)$;
               include fastcgi_params;
               proxy_set_header Host $host;
               proxy_set_header X-Real-IP $remote_addr;
               proxy_set_header X-Forwarded-Proto http;
               proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
               proxy_connect_timeout 9000;
               proxy_send_timeout    9000;
               proxy_read_timeout    9000;
               send_timeout          9000;
               fastcgi_read_timeout 180s;
               client_max_body_size  0;
               proxy_pass_request_headers      on;
               # When you are using symlinks to link the document root to the
               # current version of your application, you should pass the real
               # application path instead of the path to the symlink to PHP
               # FPM.
               # Otherwise, PHP's OPcache may not properly detect changes to
               # your PHP files (see https://github.com/zendtech/ZendOptimizerPlus/issues/126
               # for more information).
               fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
               fastcgi_param DOCUMENT_ROOT $realpath_root;
       }

       location ~ ^/app\.php(/|$) {
               fastcgi_pass unix:/run/php/php7.1-fpm.sock;
               fastcgi_split_path_info ^(.+\.php)(/.*)$;
               include fastcgi_params;
               # When you are using symlinks to link the document root to the
               # current version of your application, you should pass the real
               # application path instead of the path to the symlink to PHP
               # FPM.
               # Otherwise, PHP's OPcache may not properly detect changes to
               # your PHP files (see https://github.com/zendtech/ZendOptimizerPlus/issues/126
               # for more information).
               fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
               fastcgi_param DOCUMENT_ROOT $realpath_root;
               fastcgi_read_timeout 180s;
               # Prevents URIs that include the front controller. This will 404:
               # http://domain.tld/app.php/some-path
               # Remove the internal directive to allow URIs like this
               internal;
           }

       location /.well-known/acme-challenge/ {
           root /var/www/certbot;
       }

       ssl_certificate /etc/letsencrypt/live/arena.kuzovkov12.ru/fullchain.pem;
       ssl_certificate_key /etc/letsencrypt/live/arena.kuzovkov12.ru/privkey.pem;

       #include /etc/nginx/ssl-params.conf; #optional
       access_log /var/log/nginx-access.log;
       error_log /var/log/nginx-error.log; 
   }         
```
##### 1.2. Создать базу данных и залить данные из дампа в корне сайта: symfony1.sql
##### 1.3 Проверить соответствие конфигурации сервера: http://symfony1.loc/config.php

##### 1.4 В файле /app/config/parameters.yml записать актуальные настройки для Вашего сервера БД.
    Например:
```conf        
        database_driver: pdo_mysql
        database_host: 127.0.0.1
        database_port: 3306
        database_name: symfony1
        database_user: arena
        database_password: P@ssw0rd
        mailer_transport: smtp
        mailer_host: 127.0.0.1
        mailer_user: null
        mailer_password: null
        locale: ru
        secret: ThisTokenIsNotSoSecretChangeIt 
```        
    
#### 2. Использование

##### 2.1. Вход в админку: набрать url /admin/dashboard
    login: superadmin
    pass: admin
    
##### 2.2. Добавление фильма
    Фильмы->Добавить новый
    Откроется форма редактирования фильма с пустыми полями.
    Ввести в поле Url c сайта kinopoisk.ru
    Нажать кнопку "Создать и Продолжить редактирование"
    Будут загружены данные фильма и изображения большого и малого 
    постеров и обоев (если есть).
    Если обои фильма были загружены, появится чекбокс "Фон сайта", позволяющий
    установить изображение обоев фоновым изображением сайта.
    Изображения малого постера, большого постера, и обоев 
    загружаются в каталоги /web/upload/images/film, 
    /web/upload/images/film_big, /web/upload/images/film_wall соответсвенно.
    При необходимости изображения можно загружать и с других URL при редактировании 
    данных фильма, для этого нужно прописать  URL'ы  в соответвующие поля
    формы и нажать кнопку Сохранить.
    
##### 2.3 Редактирование расписания
    Кликнуть по ссылке "Расписание", откроется форма для добавления сеансов
    и таблица расписания для данного фильма.
    На форме можно выбрать даты, установить время в часах и минутах,номер зала,  ввести цену
    на билеты. Нажать кнопку "Установить". После подтверждения установленные сеансы
    бужут добавлены в таблицу расписания. При добавлении автоматически производится 
    проверка на отсутствие накладок сеансов.
    Для удаления сеанса нажать  иконку с изображение корзины в строке соответвующего сеанса. 
     
##### 3.Роли
    Пользователи могут иметь различные роли (может быть более одной)
    Каждая роль наделяется правами (отдельно на чтение, редактирование, удаление) относительно 
    разных сущностей( Фильмы, Страницы, Пользователи, Новости)
    Пользователь superadmin имеет полный набор прав для всех сущностей.
    Добавление и удаление пользователей, добавление и удаление ролей пользователей
    доступно ( в данной конфигурации) только для superadmin. Это делается в форме редактирования 
    Пользователя в Админ Панели.
    
    Сама конфигурация ролей прописывается в файле /app/config/security.yml:
    
    Пример:
    Каким пользователям что разрешено делать с каждой сущностью:
    Например, FILM_EDITOR может смотреть список, смотреть данные о фильме и их редактировать
```yaml
        role_hierarchy:
        ROLE_CINEMA_FILM_ADMIN:
            - ROLE_CINEMA_CINEMA_ADMIN_FILM_LIST
            - ROLE_CINEMA_CINEMA_ADMIN_FILM_VIEW
            - ROLE_CINEMA_CINEMA_ADMIN_FILM_EDIT
            - ROLE_CINEMA_CINEMA_ADMIN_FILM_CREATE
            - ROLE_CINEMA_CINEMA_ADMIN_FILM_DELETE
        ROLE_CINEMA_FILM_EDITOR:
            - ROLE_CINEMA_CINEMA_ADMIN_FILM_LIST
            - ROLE_CINEMA_CINEMA_ADMIN_FILM_VIEW
            - ROLE_CINEMA_CINEMA_ADMIN_FILM_EDIT
        ROLE_CINEMA_FILM_READER:
            - ROLE_CINEMA_CINEMA_ADMIN_FILM_LIST
            - ROLE_CINEMA_CINEMA_ADMIN_FILM_VIEW
```     
        Какие есть роли и их набор  подролей:
```yaml        
        ROLE_VIEWER:      [ROLE_USER, ROLE_CINEMA_FILM_READER]
        ROLE_EDITOR:      [ROLE_USER, ROLE_CINEMA_FILM_EDITOR]
        ROLE_ADMIN:       [ROLE_USER, ROLE_CINEMA_FILM_ADMIN]
        ROLE_SUPER_ADMIN: [ROLE_USER, ROLE_ADMIN, ROLE_ALLOWED_TO_SWITCH]
```        
        Кому разрешен доступ а Админ Панель:
```yaml
        access_control:
        - { path: ^/admin, roles: [ROLE_ADMIN, ROLE_EDITOR, ROLE_VIEWER] }
```        
        В данной конфигурации определены роли СуперАдмин (superadmin/admin),
        Админ (admin/admin),Редактор (admin/admin),
        Читатель (admin/admin), Пользователь (admin/admin)
        
        
#### 4. Баннеры
    На вкладках Сегодня и Скоро могут размещаться рекламные баннеры с правой стороны.
    Html код отвечающий за их размещение содержится в отдельном шаблоне:
    файл /src/Cinema/CinemaBundle/Resources/Views/Default/banners.html.twig
    
    Его содержимое:
 
```html
    <aside class="col-right">
        <ul class="sbn">
        
        <li><a><img src="{{asset('bundles/cinemacinema/images/sb1.png')}}" alt="" width="200" height="344" /></a></li>
        <li><a><img src="{{asset('bundles/cinemacinema/images/sb2.png')}}" alt="" width="200" height="129" /></a></li>
        <li><a><img src="{{asset('bundles/cinemacinema/images/sb3.png')}}" alt="" width="200" height="228" /></a></li>
        <li><a><img src="{{asset('bundles/cinemacinema/images/sb1.png')}}" alt="" width="200" height="344" /></a></li>
        </ul>
    
    </aside>  
```    
#### 5. Рейтинг фильма загружается с сайта kinopoisk.ru, автоматическое обновление
    пока не реализовано 
    
### Run local environment in docker    
#### Build
```bash
docker-compose build
docker-compose up -d
```
#### Get SSl certificates
rename nginx/conf.d/default-ssl.conf -> nginx/conf.d/default-ssl.conf.bak

```bash
mv nginx/conf.d/default-ssl.conf nginx/conf.d/default-ssl.conf.bak
mv nginx/conf.d/default.conf.bak nginx/conf.d/default.conf

./certbot.sh <domain-name>

mv nginx/conf.d/default-ssl.conf.bak nginx/conf.d/default-ssl.conf 
mv nginx/conf.d/default.conf nginx/conf.d/default.conf.bak
 
docker-compose restart nginx
```
Go to https://domain-name/info.php
        
#### Troubleshooting
#####  Fix error: "SQLSTATE[HY000] [2054] The server requested authentication method unknown to the client "
  
```bash  
docker-compose exec mysql bash
mysql -uroot -prootP@ssw0rd
```
```mysql
 ALTER USER 'arena'@'%' IDENTIFIED WITH mysql_native_password BY 'P@ssw0rd';
```
