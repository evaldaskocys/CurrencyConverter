CurrencyConverter
=================

PHP application that converts amount from one currency to another.

A Symfony project created on June 29, 2015, 9:24 pm.

## Requirements

  * NodeJS with NPM
    * `sudo apt-get install nodejs` on Debian based systems
    * Use [Installer from nodejs.org](http://nodejs.org/download/) on Windows
    * `brew install node` on Mac OS X
  * Globally installed Grunt-CLI and Bower packages via NPM
    * `sudo npm install -g grunt-cli bower`

## Setting up

  * `composer install` to install composer dependencies which are defined in composer.json
  * `npm install` to install node packages which are defined in package.json file
  * `bower install` to install bower components which are defined in bower.json file
  * `grunt` runs jshint and build tasks (concatinates and uglifies js files, optimises images, compiles stylesheets)

## Usage

  * `php app/console doctrine:schema:update --force` to create database schema
  * `php app/console currency:rate:update` turn everyday cron tab on for this command to insert currencies to database daily