FROM php:8.1 as php

RUN apt-get update -y
RUN apt-get install -y unzip
RUN docker-php-ext-install pdo pdo_mysql bcmath

WORKDIR /var/www
COPY . .

ENV PORT=80
ENTRYPOINT ["docker/entrypoint.sh"]
