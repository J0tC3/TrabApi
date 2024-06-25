<?php
global $config;
global $db;

try{
	$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host']
			     ,$config['dbuser']
			     ,$config['dbpass']
			     ,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
	echo "erro bd: ".$e->getMessage();
	exit;
}