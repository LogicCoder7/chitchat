DROP DATABASE IF EXISTS chitchat;
CREATE DATABASE chitchat;

USE chitchat;

source database/create_tables.sql;
source database/create_stored_procedures.sql;

SHOW tables;
SELECT routine_name AS Procedures_in_chitchat FROM information_schema.routines
WHERE routine_type = "procedure" AND routine_schema = "chitchat";