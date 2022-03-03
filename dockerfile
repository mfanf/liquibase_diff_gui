#Download base image ubuntu 20.04
# FROM ubuntu:20.04
FROM php:7.4-apache

LABEL maintainer="marco.fanfani@gmail.com"
LABEL version="0.1"
LABEL description="This is custom Docker Image for PHP based liquibase GUI"

ENV DEBIAN_FRONTEND=noninteractive

# Update Ubuntu Software repository
# RUN apt update
# RUN apt install -y apache2

COPY ./src /var/www/html

WORKDIR /liquibase
RUN apt install -y curl
RUN curl https://github.com/liquibase/liquibase/releases/download/v4.8.0/liquibase-4.8.0.tar.gz
# ESTRAI E POI INSTALLA, see https://docs.liquibase.com/install/liquibase-linux.html

# Expose Port for the Application 
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN service apache2 start
EXPOSE 80 443

#CMD ["/bin/bash"]
CMD apachectl -D FOREGROUND