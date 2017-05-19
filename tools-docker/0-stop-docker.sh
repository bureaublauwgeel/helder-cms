#!/bin/bash

#retrieve projectname variable
source tools-docker/_projectname.txt

#output message
echo "=== You are stopping the ${PROJECTNAME} containers ==="

#docker command
docker-compose --project-name $PROJECTNAME stop

