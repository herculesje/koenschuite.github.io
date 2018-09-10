<?php
session_start(); //maak een sessie zodat op elke pagina gekeken kan worden of de gebruker is ingelogd

	$server = "localhost"; //dit is altijd localhost
	$db_name = "lignoto_coindok"; // naam van de database waar je aan geconnect bent 
	$db_user = "lignoto_coindok"; //gebruikersnaam om in te loggen voor de database
	$db_pass = "Olisjeik2310!"; // wachtwoord van db_user
	

	mysql_connect($server, $db_user, $db_pass) or die("Could not connect to server!");
	mysql_select_db($db_name) or die("Could not connect to database!");
?>