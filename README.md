# Restaurant Reviewer

#### A PHP application to review restaurants, September 21st, 2016

#### By Mark Lawson & Stephen Burden

## Description

This application is an exercise in PHP and MySQL. Users can add restaurants to the site and review other restaurants. The application is built with PHP, using the Silex framework, Twig templates, and Bootstrap for styling.

## Setup/Installation Instructions

* Clone the repository
* Using the command line, navigate to the project's root directory
* Install dependencies by running $ composer install
* Sign into MySQL shell by running $ /Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot
* Start MAMP server and go to MAMP preferences:
    * Set Document Root to project's root directory
    * In the app/app.php project file, make sure the $server variable points to the localhost port listed under Ports>MySQL port in MAMP
* In a browser, go to http://localhost/phpmyadmin
* Select Import from the top menu and choose the compressed .sql files from the projects root directory and click 'Go' to import the databases
* Navigate to the /web directory and start a local server with $ php -S localhost:8000
* Open a browser and go to the address http://localhost:8000 to view the application

## Known Bugs ##

There are no known bugs at this time.

## Support and Contact Details ##

Please report any bugs or issues to mlawson3691@gmail.com.

## Languages/Technologies Used ##

* PHP
* Silex
* Twig
* PHPUnit
* Bootstrap

### License ###

*This application is licensed under the MIT license.*

Copyright (c) 2016 Mark Lawson & Stephen Burden
