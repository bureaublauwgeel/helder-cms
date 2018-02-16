# Helder CMS by Bureau BlauwGeel
==================================

Welcome to the Helder CMS - 
a fully-functional CMS (content management system) based on Symfony2 that you can use as the skeleton for your websites.

Built on https://github.com/Kunstmaan/KunstmaanBundlesStandardEdition

## Setup

To create a new project based on the Helder CMS install composer (https://getcomposer.org/download/), then execute the following command

```
php composer.phar create-project bureaublauwgeel/helder-cms <project-dir>
```

This will download a basic skeleton.

## Tools

### Shell tools

Shell tools help to automate certain common actions during development. The available shell tools are:

* `create_migration.sh // creates doctrine migrations`
* `reload_fixtures.sh // reloads the fixtures`
* `reload_project.sh // reloads the complete project setup`

They are located in the `shell-tools` folder.

### PHPUnit from phpStorm

With phpStorm PHPUnit is loaded with autoload.php from the Composer dependency manager. PHPunit is included in the composer.json:

```
    "require-dev": {
        ...
        "phpunit/phpunit": "~4.8"
    },
```

To enable it in your project, take the following steps

* Open the Preferences dialog box, and click PHPUnit under the PHP node in Languages and Frameworks.
* On the PHPUnit page that opens, choose ```Use composer autoloader``` and specify the location of the autoload.php, located in ```app/autoload.php``` within your project.

To run the unit test, right click on `app/phpunit.xml.dist` and select `Run`
