CREATE DATABASE IF NOT EXISTS tenancy;
CREATE USER 'tenancy'@'%' IDENTIFIED BY 'someRandomPassword';
GRANT ALL PRIVILEGES ON *.* TO 'tenancy'@'%' WITH GRANT OPTION;
FLUSH privileges;
