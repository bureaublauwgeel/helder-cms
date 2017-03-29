#!/bin/bash

#retrieve projectname variable
source tools-docker/_projectname.txt

#output message
echo "|||||||| You are setting up ${PROJECTNAME} ||||||||"

#docker commands
docker-compose --project-name $PROJECTNAME up -d
docker exec -t -i -u www-data ${PROJECTNAME}_php-apache_1 /bin/bash -c 'cd /var/www; pwd; bash ./shell-tools/reload_project.sh;'