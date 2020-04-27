ARG DOCKER_GIT_USER
ARG DOCKER_GIT_EMAIL

FROM php:7.4-fpm

#common soft
RUN apt-get update && apt-get install --fix-missing -y wget unzip autoconf pkg-config

#zip
RUN apt-get install -y libzip-dev && docker-php-ext-install zip

#json
RUN docker-php-ext-install json

#xdebug
RUN pecl install xdebug-2.8.1 && docker-php-ext-enable xdebug

#composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
&& HASH="$(wget -q -O - https://composer.github.io/installer.sig)" \
&& php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
&& php composer-setup.php --install-dir=/usr/local/bin --filename=composer

#git
RUN apt-get -y install git \
&& git config --global user.name docker \
&& git config --global user.email docker@localhost

#symfony
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

