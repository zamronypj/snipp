#!/bin/bash

if [ $# -ne 2 ]
then
    echo "Usage: $(basename $0) DB_USERNAME DB_NAME"
    exit 1
fi

username=$1
dbname=$2

mysql -u $username -p $dbname < tableschema.sql