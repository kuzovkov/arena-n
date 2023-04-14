#!/bin/sh

###########################
# Store database to  dump #
###########################

DUMP_NAME=dump.sql.gz

if [  -e ".env" ]; then
    eval $(cat .env)
    case "$1" in
      timestamp)
            timestamp="$(date -Iseconds)"
            DUMP_NAME="$timestamp-$DUMP_NAME"
            echo "Filename of dump: $DUMP_NAME"

        ;;
        esac
    sudo docker-compose exec mysql sh -c "mysqldump -u$DB_USER -p$DB_PASS $DB_NAME > /dumps/$DUMP_NAME"
else
    echo "File .env.dev does not exists!"
    exit 1
fi


