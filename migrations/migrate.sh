#!/bin/bash

if [ $# -ne 2 ]
then
    echo "Usage: $(basename $0) DB_USERNAME DB_NAME"
    exit 1
fi

username=$1
dbname=$2
script_dir="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
input_sql_file="$script_dir/tableschema.sql"
mysql -u $username -p $dbname < $input_sql_file