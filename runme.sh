#!/bin/sh
docker build -t liquibase/liquibase-mysql-apache .

docker run --rm -it --name lqgui -p 8080:80 liquibase/liquibase-mysql-apache
sudo docker run --rm -it -v /home/ubuntu/Projects/liquibase_diff_gui/src:/var/www/html --name lqgui -p 8080:80 liquibase/liquibase-mysql-apache

docker exec -it lqgui bash


liquibase --url="jdbc:mysql://192.168.1.108:3306/liquibase_test" --changeLogFile=db.template.changelog.xml --username=admin --password=password status --verbose


liquibase --url="jdbc:mysql://192.168.1.108:3306/liquibase_test_3" \
--username=admin \
--password=password \
--referenceUrl="jdbc:mysql://192.168.1.108:3306/liquibase_test" \
--referenceUsername=admin \
--referencePassword=password \
diff

liquibase --url="jdbc:mysql://192.168.1.108:3306/liquibase_test_3" \
--username=admin \
--password=password \
--referenceUrl="jdbc:mysql://192.168.1.108:3306/liquibase_test" \
--referenceUsername=admin \
--referencePassword=password \
--changelog-file=/liquibase/db_diff_changelog_1_3.xml \
diff-changelog