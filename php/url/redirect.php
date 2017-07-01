<?php
	require_once "../sql.php";

	$url = $_GET["url"];
	if ($url == null || $url == "/") {
		header("Location: http://cw04662.tmweb.ru/");
		exit;
	}

	connectDB();

	$query = "SELECT `FullUrl` FROM `relation` WHERE `ShortUrl`=\"".$url."\"";
	$row = rowDB(queryDB($query));
	if ($row != null) {
		header("Location: ".$row['FullUrl']);
	} else {
		header("HTTP/1.0 404 Not Found");
	}

	disconnectDB();
