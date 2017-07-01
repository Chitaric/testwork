<?php
	$host = "localhost";
	$user = "cw04662_urls";
	$pswrd = "7890";
	$dbname = "cw04662_urls";
	$db = null;

	function connectDB()
	{
		global $host;
		global $user;
		global $pswrd;
		global $dbname;
		global $db;

		/* Не PHP 5.6 :(
		$db = mysql_connect($host, $user, $pswrd) or die("Не могу соединиться с MySQL.".mysql_error());
		mysql_select_db($dbname, $db) or die("Не могу подключиться к базе.".mysql_error());
		*/
		$db = mysqli_connect($host, $user, $pswrd, $dbname);
		if (mysqli_connect_errno($db)) {
			echo "Отсутствует связь с сервером";
			exit;
		}
	}

	function disconnectDB()
	{
		global $db;
		
		//mysql_close($db);
		mysqli_close($db);
	}

	function queryDB($query)
	{
		global $db;
		
		//return mysql_query($query);
		return mysqli_query($db, $query);
	}

	function rowDB($date)
	{
		if ($date == null) {
			return null;
		}
		//return mysql_fetch_array($date);
		return mysqli_fetch_array($date);
	}
