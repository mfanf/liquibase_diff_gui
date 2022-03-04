#Download base image ubuntu 20.04
# FROM ubuntu:20.04
FROM php:7.4-apache

LABEL maintainer="marco.fanfani@gmail.com"
LABEL version="0.1"
LABEL description="This is custom Docker Image for PHP based liquibase GUI"

ENV DEBIAN_FRONTEND=noninteractive

# install java
RUN apt-get update && \
    apt-get -y install default-jre-headless && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# install liquibase and mysql connector
WORKDIR /liquibase
RUN apt-get install -y curl
RUN curl -LJO https://github.com/liquibase/liquibase/releases/download/v4.8.0/liquibase-4.8.0.tar.gz
RUN mkdir ./liquibase-4.8.0
RUN tar -zxvf liquibase-4.8.0.tar.gz -C ./liquibase-4.8.0
ENV PATH=$PATH:/liquibase/liquibase-4.8.0

RUN curl -LJO https://dev.mysql.com/get/Downloads/Connector-J/mysql-connector-java_8.0.28-1ubuntu20.04_all.deb
RUN dpkg -i mysql-connector-java_8.0.28-1ubuntu20.04_all.deb
RUN cp /usr/share/java/mysql-connector-java-8.0.28.jar ./liquibase-4.8.0/lib/

# copy php gui files
COPY src/index.php /var/www/html/index.php
COPY src/run_query.php /var/www/html/run_query.php
RUN mkdir /var/www/html/changelogs
# RUN ls /var/www/html
RUN chown www-data:www-data /var/www/html/changelogs
RUN chmod g+w /var/www/html/changelogs
RUN usermod -u 1000 www-data
# RUN usermod -G staff www-data

# copy liquibase files
COPY ./liquibase_file/db.template.changelog.xml .

# Expose Port for the Application 
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN service apache2 start
EXPOSE 80 443

#CMD ["/bin/bash"]
CMD apachectl -D FOREGROUND