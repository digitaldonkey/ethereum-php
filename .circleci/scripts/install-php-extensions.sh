#!/bin/sh
sudo pecl install mcrypt-1.0.4 && \
sudo docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \
sudo docker-php-ext-configure gmp  && \
sudo docker-php-ext-install -j$(nproc) gmp gd && \
sudo docker-php-ext-enable mcrypt
