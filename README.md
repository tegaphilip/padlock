ELECTION APP
===========
Election App

Features
--------
* ...


Contributors
------------
* Tega Oghenekohwo <tega.philip@gmail.com>


Requirements
------------
* [Phalcon 3.3](https://docs.phalconphp.com/en/latest/reference/install.html)
* [Composer](https://getcomposer.org/doc/00-intro.md#using-composer)


Installation
------------

Setup Environment Variables
---------------------------
Make a copy of .env.sample to .env in the env directory and replace the values.


Set Up Using Docker
-------------------------------

* `php vendor/bin/phinx migrate`

* Ensure you have docker installed

* Create a clone of the `.env.testing.sample` file and name it `.env` and replace the values of the variables

* Login to mysql using the credentials host:127.0.0.1, username: root, password:root, port: 32800

* Create two databases: `election_app` and `election_app_test`

* Run migrations `php vendor/bin/phinx migrate`

Run the following to import states, etc from Excel File (If any of the scripts fail, try without the underscore)

* `DB_HOST=mysql DB_USER=root DB_PASSWORD=root DB_NAME=election_app php app/cli.php states_import import`
* `DB_HOST=mysql DB_USER=root DB_PASSWORD=root DB_NAME=election_app php app/cli.php lgas_import import`
* `DB_HOST=mysql DB_USER=root DB_PASSWORD=root DB_NAME=election_app php app/cli.php wards_import import`
* `DB_HOST=mysql DB_USER=root DB_PASSWORD=root DB_NAME=election_app php app/cli.php stations_import import`
* `DB_HOST=mysql DB_USER=root DB_PASSWORD=root DB_NAME=election_app php app/cli.php inec_lgas_import import`
* `DB_HOST=mysql DB_USER=root DB_PASSWORD=root DB_NAME=election_app php app/cli.php inec_wards_import import`
* `DB_HOST=mysql DB_USER=root DB_PASSWORD=root DB_NAME=election_app php app/cli.php inec_stations_import import`

Running Tests
-------------

Create a clone of the `.env.testing.sample` file and name it `.env.testing` and replace the values of the variables

* Create a test database `election_app_test`

* Execute tests using  `./runtest.sh` to run all tests or `./runtest.sh {testName}` to run a particular test. E.g `./runtest.sh UserCest`

php vendor/bin/phinx create StateMigration

Deploying on Staging
--------------------
* sudo apt-get update
* Install apache with `sudo apt-get install apache2`
* Get phalcon repository with `curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash`
* Install phalcon with `sudo apt-get install php7.0-phalcon`
* Check Phalcon Version with `php -r "echo Phalcon\Version::get();"`
* sudo apt-get install php7.0-mbstring
* sudo apt-get install php7.0-curl
* sudo apt-get install php7.0-xml
* sudo apt-get install php7.0-mysql
* sudo apt-get install php7.1-phalcon
* https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-16-04
* https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-in-ubuntu-16-04
* extensions /usr/lib/php/20160303
* INI APACHE cat /etc/php/7.1/apache2/php.ini
* ADDITIONAL INI APACHE ls -al /etc/php/7.1/apache2/conf.d
* INI CLI cat /etc/php/7.1/cli/php.ini
* ADDITIONAL INI CLI ls -al /etc/php/7.1/cli/conf.d
* sudo find  / -iname 'phalcon.so' -exec rm -f {} \; // remove
* sudo find  / -iname 'phalcon.so'

sudo apt-get install -y php7.1 libapache2-mod-php7.1 php7.1-cli php7.1-common php7.1-mbstring php7.1-gd php7.1-intl php7.1-xml php7.1-mysql php7.1-mcrypt php7.1-zip
sudo apt-get install -y php7.1-curl

* For some reason addExistence Validation causes things to fail on staging server (AWS, DO, etc)

* Run import tasks


