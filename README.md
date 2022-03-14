# Liquibase Diff Tool GUI
A simple web-based interface to use the diff-changelog command of [Liquibase](https://liquibase.org/) for assessing DB differences.

## Usage

1. Build the Docker image (it include Apache, PHP, Liquibase with MySQL connector)   
```docker build -t liquibase/liquibase-mysql-apache .```
2. Run the Docker container   
```docker run --rm -it --name lqgui -p 8080:80 liquibase/liquibase-mysql-apache```
3. Go to [http://localhost:8080/](http://localhost:8080/) and fill the form filed to connect to reference and target DBs



