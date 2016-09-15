# Helder CMS by Bureau BlauwGeel
==================================

Welcome to the Helder CMS - 
a fully-functional CMS (content management system) based on Symfony2 that you can use as the skeleton for your websites.

Build on https://github.com/Kunstmaan/KunstmaanBundlesStandardEdition

To setup a new project you need to do the following

- Install the dependency
- Startup docker
- Setup the site from within docker


## Install the dependency

To install the depedency for the helder-cms run 

```
mkdir <new client directory>
php composer.phar create-project bureaublauwgeel/helder-cms website --no-install
```

This will download a basic skelleton.

## Launch docker

Launch the ```Docker Quickstart Terminal``` and go to the project directory

```
cd <new client directory>/website
```

Startup the docker environment

```
docker-compose up -d
```

This will launch a mysql instance and a PHP/Apache instance

## Setup the site from within docker

Enter the docker PHP/Apache setup...
 
```
docker exec -t -i website_php-apache_1 /bin/bash
```
  
... and run the shell script to setup the project

```
cd /var/www
bash shell-tools/setup_project.sh
```

By default the site will be available on ```http://192.168.99.100/app_dev.php```
