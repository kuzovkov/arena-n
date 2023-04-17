FROM ubuntu:20.04

RUN apt-get update && \
    apt-get install -y software-properties-common && \
    dpkg -l | grep php | tee packages.txt && \
    add-apt-repository -y ppa:ondrej/php
RUN apt-get update && \
    apt-get install -y php7.1-fpm && \
    apt-get install -y php7.1-curl && \
    apt-get install -y php7.1-mysql
RUN apt-get install -y php7.1-dom && \
    apt-get install -y php7.1-imagick && \
    apt-get install -y php7.1-mbstring && \
    apt-get install -y php7.1-zip && \
    apt-get install -y php7.1-gd && \
    apt-get install -y php7.1-intl


WORKDIR /var/www/html
COPY ./symfony .
COPY ./conf/php.ini /etc/php/7.1/fpm/php.ini

#Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
php -r "unlink('composer-setup.php');" && \
chmod a+x /usr/local/bin/composer

ENTRYPOINT /usr/sbin/php-fpm7.1 --nodaemonize --fpm-config /etc/php/7.1/fpm/php-fpm.conf

