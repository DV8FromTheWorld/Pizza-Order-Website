#!/bin/bash
# Simple file used to easily use SQL from CLI in a single line.
#   There is probably a better way to do this, but this was my quick fix.

# MUSER="$1"
# MPASS="$2"
MUSER=""    #Database user to login as
MPASS=""    #User password
MDB=""      #Database to use (on this localhost)


# Detect paths
MYSQL=$(which mysql)
AWK=$(which awk)
GREP=$(which grep)

#if [ $# -ne 1 ]
#then
#    echo "Usage: $0 {sql file to run on 3430-s15-ts DB"
#    echo "Creates DB Schema based on sql code in CreateDB.sql"
#    exit 1
#fi

echo $thing
$MYSQL -u $MUSER -p$MPASS $MDB -e "$*;" 

