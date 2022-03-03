#!/bin/sh
docker build -t liquibase/liquibase-mysql-apache .

docker run --rm -it --name lqgui -p 8080:80 liquibase/liquibase-mysql-apache

docker exec -it <container_id> bash