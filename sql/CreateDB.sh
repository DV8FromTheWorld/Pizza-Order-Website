#!/bin/bash
# MUSER="$1"
# MPASS="$2"
MUSER=""    #Database user to login as
MPASS=""    #User password
MDB=""      #Database to use (on this localhost)


# Detect paths
MYSQL=$(which mysql)
AWK=$(which awk)
GREP=$(which grep)

#if [ $# -ne 2 ]
#then
#    echo "Usage: $0 {MySQL-User-Name} {MySQL-User-Password}"
#    echo "Creates DB Schema based on sql code in CreateDB.sql"
#    exit 1
#fi

$MYSQL -u $MUSER -p$MPASS $MDB -e 'source CreateDB.sql; show tables;'
