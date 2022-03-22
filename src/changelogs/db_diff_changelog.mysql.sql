-- liquibase formatted sql

-- changeset www-data:1647951132017-1
CREATE TABLE Sell (ID INT NOT NULL, Name VARCHAR(45) NULL, Price DECIMAL(5, 2) NULL, CONSTRAINT PK_SELL PRIMARY KEY (ID));

