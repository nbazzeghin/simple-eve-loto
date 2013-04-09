<?php
//IMPORTANT:
//Rename this file to configuration.php after having inserted all the correct db information
global $configuration;

// Edit the information below to match your database settings.
// ALSO BE SURE TO EDIT ale/eveonline.ini and ale/evecentral.ini with your database settings.

$configuration['db']	= 'dbname';		//	<- database name
$configuration['host'] 	= 'localhost';			//	<- database host
$configuration['user'] 	= 'dbuser';		//	<- database user
$configuration['pass']	= 'dbpass';		//	<- database password
$configuration['port']	= '3306';				//	<- database port

$configuration['pdoDriver']	= 'mysql';			
$configuration['setup_password'] = 'password';		//	<- password used for initial setup and admin sections

// Edit the information below to mach your full EVE API

$configuration['apiKey'] = 'aaaaaaabbbbbbbbccccccccddddddddeeeeeee';
$configuration['apiID'] = '1234567';
$configuration['apiCharID'] = '123456789';
$configuration['wallet'] = 'corp';	// corp for corp wallet, or char for personal wellet.

//Path settings

$configuration['root_path'] = '/var/www/eve-hosting-lotto';				//absolute path to lotto root folder, e.g c:/mycode/test or /home/phpobj/public_html/lotto
$configuration['plugins_path'] = $configuration['root_path'] . '/plugins';


/****************************************/
/*                                      */
/*      DO NOT EDIT BELOW THIS LINE     */
/*  UNLESS YOU KNOW WHAT YOU ARE DOING  */
/*                                      */
/****************************************/

$configuration['soap'] = "http://www.phpobjectgenerator.com/services/pog.wsdl";
$configuration['homepage'] = "http://www.phpobjectgenerator.com";
$configuration['revisionNumber'] = "";
$configuration['versionNumber'] = "3.0e";

// to enable automatic data encoding, run setup, go to the manage plugins tab and install the base64 plugin.
// then set db_encoding = 1 below.
// when enabled, db_encoding transparently encodes and decodes data to and from the database without any
// programmatic effort on your part.
$configuration['db_encoding'] = 0;


//proxy settings - if you are behnd a proxy, change the settings below
$configuration['proxy_host'] = false;
$configuration['proxy_port'] = false;
$configuration['proxy_username'] = false;
$configuration['proxy_password'] = false;

?>