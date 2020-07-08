FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
		vim git wget unzip cron \
		awscli \
		nodejs npm \
		&& docker-php-ext-install mysqli
RUN npm i -g yarn
#RUN docker-php-ext-install mysqli mysqlnd pdo pdo_mysql zip json curl xml

RUN curl -L https://phar.phpunit.de/phpunit-8.phar > /tmp/phpunit.phar \
	&& chmod +x /tmp/phpunit.phar \
	&& mv /tmp/phpunit.phar /usr/local/bin/phpunit

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
	&& chmod +x wp-cli.phar \
	&& mv wp-cli.phar /usr/local/bin/wp

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php


# cronjobs
#RUN service cron start
#COPY ./php/cronjobs /etc/cron.d
#RUN chmod -R 0644 /etc/cron.d/
#RUN crontab /etc/cron.d/cronjobs
#RUN touch /var/log/cron.log

# custom bash scripts
RUN mkdir -p /shared/scripts
COPY .env /shared/scripts
COPY ./php/scripts /shared/scripts
RUN chmod +x /shared/scripts/*.sh

# WWW assets
COPY ./wordpress /shared/html
RUN chown -R www-data:www-data /shared/html
