DROP DATABASE IF EXISTS chitchat_test;
CREATE DATABASE chitchat_test;

USE chitchat_test;

source database/create_tables.sql;
source database/create_stored_procedures.sql;

SHOW tables;
SELECT routine_name AS Procedures_in_chitchat_test FROM information_schema.routines
WHERE routine_type = "procedure" AND routine_schema = "chitchat_test";