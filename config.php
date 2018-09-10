<?php
//We start sessions
session_start();

/******************************************************
------------------Required Configuration---------------
Please edit the following variables so the members area
can work correctly.
******************************************************/

//We log to the DataBase
mysql_connect('localhost', 'lignoto_coindok', 'Olisjeik2310');
mysql_select_db('lignoto_coindok');

//Webmaster Email
$mail_webmaster = 'info@coindok.com';

//Top site root URL
$url_root = 'http://www.coindok.com';

/******************************************************
-----------------Optional Configuration----------------
******************************************************/

//Home page file name
$url_home = 'index.php';

//Design Name
$design = 'default';
?>
