-- liquibase formatted sql

-- changeset www-data:1647863237453-1
ALTER TABLE Purchase ADD Price DECIMAL(4, 2) NULL;

-- changeset www-data:1647863237453-2
DROP TABLE new_table;

