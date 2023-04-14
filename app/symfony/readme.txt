���������� �� ������������� ����� �� ������� � �������������

1. �������������

1.1. ��������� ����� � ������ �� ������, ����� �������, ����� � ��������� ����� 
���-������� ���������� ����� web ����������
������ ��������� ��� Apache:

            <VirtualHost *:80>
            ServerName symfony1.loc
            DocumentRoot "C:/www3/symfony1/web"
            <Directory "C:/www3/symfony1/web">
            Options Indexes FollowSymLinks
            AllowOverride All
            #Order allow,deny
            Allow from all
            </Directory>
            </VirtualHost>

1.2. ������� ���� ������ � ������ ������ �� ����� � ����� �����: symfony1.sql
1.3 ��������� ������������ ������������ �������: http://symfony1.loc/config.php

1.4 � ����� /app/config/parameters.yml �������� ���������� ��������� ��� ������ ������� ��.
    ��������:
        database_driver: pdo_mysql
        database_host: 127.0.0.1
        database_port: 3306
        database_name: symfony1
        database_user: root
        database_password: root
        mailer_transport: smtp
        mailer_host: 127.0.0.1
        mailer_user: null
        mailer_password: null
        locale: ru
        secret: ThisTokenIsNotSoSecretChangeIt 
        
    
2. �������������

2.1. ���� � �������: ������� url /admin/dashboard
    login: superadmin
    pass: qazwsx
    
2.2. ���������� ������
    ������->�������� �����
    ��������� ����� �������������� ������ � ������� ������.
    ������ � ���� Url c ����� kinopoisk.ru
    ������ ������ "������� � ���������� ��������������"
    ����� ��������� ������ ������ � ����������� �������� � ������ 
    �������� � ����� (���� ����).
    ���� ���� ������ ���� ���������, �������� ������� "��� �����", �����������
    ���������� ����������� ����� ������� ������������ �����.
    ����������� ������ �������, �������� �������, � ����� 
    ����������� � �������� /web/upload/images/film, 
    /web/upload/images/film_big, /web/upload/images/film_wall �������������.
    ��� ������������� ����������� ����� ��������� � � ������ URL ��� �������������� 
    ������ ������, ��� ����� ����� ���������  URL'�  � ������������� ����
    ����� � ������ ������ ���������.
    
2.3 �������������� ����������
    �������� �� ������ "����������", ��������� ����� ��� ���������� �������
    � ������� ���������� ��� ������� ������.
    �� ����� ����� ������� ����, ���������� ����� � ����� � �������,����� ����,  ������ ����
    �� ������. ������ ������ "����������". ����� ������������� ������������� ������
    ����� ��������� � ������� ����������. ��� ���������� ������������� ������������ 
    �������� �� ���������� �������� �������.
    ��� �������� ������ ������  ������ � ����������� ������� � ������ �������������� ������. 
     
3.����
    ������������ ����� ����� ��������� ���� (����� ���� ����� �����)
    ������ ���� ���������� ������� (�������� �� ������, ��������������, ��������) ������������ 
    ������ ���������( ������, ��������, ������������, �������)
    ������������ superadmin ����� ������ ����� ���� ��� ���� ���������.
    ���������� � �������� �������������, ���������� � �������� ����� �������������
    �������� ( � ������ ������������) ������ ��� superadmin. ��� �������� � ����� �������������� 
    ������������ � ����� ������.
    
    ���� ������������ ����� ������������� � ����� /app/config/security.yml:
    
    ������:
    ����� ������������� ��� ��������� ������ � ������ ���������:
    ��������, FILM_EDITOR ����� �������� ������, �������� ������ � ������ � �� �������������
    
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
     
        ����� ���� ���� � �� �����  ��������:
        
        ROLE_VIEWER:      [ROLE_USER, ROLE_CINEMA_FILM_READER]
        ROLE_EDITOR:      [ROLE_USER, ROLE_CINEMA_FILM_EDITOR]
        ROLE_ADMIN:       [ROLE_USER, ROLE_CINEMA_FILM_ADMIN]
        ROLE_SUPER_ADMIN: [ROLE_USER, ROLE_ADMIN, ROLE_ALLOWED_TO_SWITCH]
        
        ���� �������� ������ � ����� ������:
        access_control:
        - { path: ^/admin, roles: [ROLE_ADMIN, ROLE_EDITOR, ROLE_VIEWER] }
        
        � ������ ������������ ���������� ���� ���������� (superadmin/admin),
        ����� (admin/admin),�������� (admin/admin),
        �������� (admin/admin), ������������ (admin/admin)
        
        
4. �������
    �� �������� ������� � ����� ����� ����������� ��������� ������� � ������ �������.
    Html ��� ���������� �� �� ���������� ���������� � ��������� �������:
    ���� /src/Cinema/CinemaBundle/Resources/Views/Default/banners.html.twig
    
    ��� ����������:
    
    <aside class="col-right">
        <ul class="sbn">
        
        <li><a><img src="{{asset('bundles/cinemacinema/images/sb1.png')}}" alt="" width="200" height="344" /></a></li>
        <li><a><img src="{{asset('bundles/cinemacinema/images/sb2.png')}}" alt="" width="200" height="129" /></a></li>
        <li><a><img src="{{asset('bundles/cinemacinema/images/sb3.png')}}" alt="" width="200" height="228" /></a></li>
        <li><a><img src="{{asset('bundles/cinemacinema/images/sb1.png')}}" alt="" width="200" height="344" /></a></li>
        </ul>
    
    </aside>  
    
5. ������� ������ ����������� � ����� kinopoisk.ru, �������������� ����������
    ���� �� ����������� 
        
    
    