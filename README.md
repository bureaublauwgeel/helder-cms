# Helder CMS by Bureau BlauwGeel
==================================

Welcome to the Helder CMS - 
a fully-functional CMS (content management system) based on Symfony2 that you can use as the skeleton for your websites.

Build on https://github.com/Kunstmaan/KunstmaanBundlesStandardEdition

If you use docker, make sure your virtual machine has 4GB of memory. This because of composer install.

## Setup

To setup a new project you need to do the following

- Install the dependency
- Startup docker
- Setup the site from within docker


### Install the dependency

To install the depedency for the helder-cms run 

```
mkdir <KlantNaam>
cd <KlantNaam>
php composer.phar create-project bureaublauwgeel/helder-cms website --no-install
```

This will download a basic skelleton.

### Launch docker

Launch the ```Docker Quickstart Terminal``` and go to the project directory

```
cd website
```

Startup the docker environment

```
docker-compose --project-name <KlantNaam> up -d
```

This will launch a mysql instance and a PHP/Apache instance


To stop the docker environment run

```
docker-compose --project-name <KlantNaam> down
```


### Setup the site from within docker

Enter the docker PHP/Apache setup...
 
```
docker exec -t -i -u www-data <KlantNaam>_php-apache_1 /bin/bash
```
  
... and run the shell script to setup the project

```
cd /var/www
bash shell-tools/setup_project.sh <KlantNaam> // is CamelCase
```

By default the site will be available on ```http://192.168.99.100/app_dev.php```

## Components

### Enviroment

This setup required the following component

* PHP version 5.6.x
* MySQL versioen 5.5.x
* NodeJS versie 4
* NPM versie 2.2
* Apache version 2.4 Ubuntu 14.04
* Ruby version 1.9 Ubuntu 14.04
* Elasticsearch version 2.3.x
* Ubuntu 14.04

### OTAP

Please specify the OTAP environment for this project. Include the servers and the URL's

* Ontwikkel
    * URL: <domain>.dev
    * URL admin environment: <domain>.dev/...
* Test
    * <domain>.bbgtest.nl
    * URL admin environment: <domain>.bbgtest.nl/...
        * Client specific credentials
    * Server: FQDN
    * Basic auth for environment
        * Client specific
* Acceptatie
    * <domain>.bbgaccept.nl
    * URL admin environment: <domain>.bbgaccept.nl/... 
        * Client specific credentials
    * Server: FQDN
    * Basic auth for environment
        * Client specific
* Productie
    * <domain>
    * URL admin environment: <domain>/... 
    * Server: FQDN

### Jenkins

Please provide the URL for the Jenkins environment...

##  Client specific Bundles

This project uses the following client specific Bundles

* please list all client specific bundles
* please list all client specific bundles
* please list all client specific bundles
* ...

## Tools

### Shell tools

Shell tools help to automate certain common actions during development. The available shell tools are:
 
* ```create_migration.sh // creates doctrine migrations``` 
* ```reload_fixtures.sh // reloads the fixtures```
* ```setup_project.sh // default project setup, only run once!```
* ```reload_project.sh // reloads the complete project setup!```

They are located in the ```shell-tools``` folder.

### Gulp toolchain

The gulp tool automates the following processes:
 
* SASS files compilation to css files
* Minify of the CSS files
* JavaScript source files compilation to destination JavaScript file.
* Minifies the JavaScript file
* It copies the default project images needed
* It copies the project icons files needed
* It copies the project fonts files needed

Source files are located in ```src/<KlantNaam>/WebsiteBundle/Resources/``` 

Destination files are located in ```web/frontend/``` (see ```.groundcontrolrc```)

During development you can use ```node_modules/.bin/gulp watch``` compile changes on the fly.

To make a new build, run ```node_modules/.bin/gulp build```. 

You can run this command both from your client system as from within the docker instance. The preferred solution is to run it on the client system because it uses your Mac notification system.

### PHP support in phpStorm

You need PHP support in phpStorm. To enable this, take the following steps

* Open the Preferences dialog box, and click PHP node in Languages and Frameworks.
* Select the PHP interpreter


### PHPUnit from phpStorm

With phpStorm PHPUnit is loaded with autoload.php from the Composer dependency manager. PHPunit is inclused in the composer.json

```
    "require-dev": {
        ...
        "phpunit/phpunit": "5.5.*"
    },
```

To enable it in your project, take the following steps

* Open the Preferences dialog box, and click PHPUnit under the PHP node in Languages and Frameworks.
* On the PHPUnit page that opens, choose ```Use composer autoloader``` and specify the location of the autoload.php, located in ```app/autoload.php``` within your project.

To run the unit test, right click on ```app/phpunit.xml.dist``` and select ```Run```


### PHPUnit from docker

You can also run the PHPUnit from within docker. To execute the tests run

```
cd /var/www
./vendor/phpunit/phpunit/phpunit -c app/phpunit.xml.dist 
```

or 

```
./var/www/vendor/phpunit/phpunit/phpunit -c /var/www/app/phpunit.xml.dist 
```




