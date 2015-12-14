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
#    echo "Drops all tables from a MySQL"
#    exit 1
#fi
 
TABLES=$($MYSQL -u $MUSER -p$MPASS $MDB -e 'show tables' | $AWK '{ print $1}' | $GREP -v '^Tables' )

for t in $TABLES
do
    echo "Deleting $t table from $MDB database..."
    $MYSQL -u $MUSER -p$MPASS $MDB -e "SET FOREIGN_KEY_CHECKS=0; drop table $t"
done

$MYSQL -u $MUSER -p$MPASS $MDB -e 'show tables'
