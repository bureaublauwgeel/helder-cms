#!/bin/bash

if [[ $# -eq 0 ]] ; then
    echo 'No arguments provided. Please enter the ClientName'
    exit 1
fi

PROJECTNAME=$1
LOWER_CLIENT_NAME=`echo $1 | tr A-Z a-z`

#rename project name in docker-tools map.
sed -i -e 's/'"heldercms"'/'"$PROJECTNAME"'/g' ./tools-docker/_projectname.txt

#output message
echo "|||||||| You are creating a new project: ${PROJECTNAME} ||||||||"

#docker commands
docker-compose --project-name $PROJECTNAME up -d
docker exec -t -i -u www-data ${PROJECTNAME}_php-apache_1 /bin/bash -c 'cd /var/www; pwd; bash ./shell-tools/setup_project.sh "$PROJECTNAME";'