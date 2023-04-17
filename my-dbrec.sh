#!/bin/sh

###############################
# Recovery database from dump #
###############################

#DUMP_NAME=arena.sql
DUMP_NAME=dump.sql.gz

if [  -e ".env" ]; then
    eval $(cat .env)
    case "$1" in
      timestamp)
            timestamp="$(date -Iseconds)"
            DUMP_NAME="$timestamp-$DUMP_NAME"
            echo "Restore from dump: $DUMP_NAME"

        ;;
        esac
    sudo docker-compose exec mysql mysql -u$DB_USER -p$DB_PASS -e "DROP DATABASE IF EXISTS $DB_NAME"
    sudo docker-compose exec mysql mysql -u$DB_USER -p$DB_PASS -e "CREATE DATABASE IF NOT EXISTS $DB_NAME"
    sudo docker-compose exec mysql sh -c "cat < /dumps/$DUMP_NAME | mysql -u$DB_USER -p$DB_PASS $DB_NAME"
else
    echo "File .env does not exists!"
    exit 1
fi



