#!/bin/bash

#sleep 5

echo "import docker db"
mysql -u app_user -pqwerty -e "DROP DATABASE IF EXISTS app_db; CREATE DATABASE app_db;"
bash -c "mysql -u app_user -pqwerty app_db < /tmp/db-dump.sql"