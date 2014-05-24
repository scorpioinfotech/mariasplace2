<?php

	require_once(dirname(__FILE__).'/connector/db_sqlite3.php');
	
	// SQLite
	//$dbtype = "SQLite3";
	//$res = new SQLite3(dirname(__FILE__)."/database.sqlite");

	// Mysql
	 $dbtype = "MySQL";
	 $res=mysql_connect("localhost", "azohub_test", "Admin123");
	 mysql_select_db("azohub_test");


?>