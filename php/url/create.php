<?php
	require_once "../sql.php";

	function pathUrl()
	{
		return "http://cw04662.tmweb.ru/";
	}

	function checkUrl($FullUrl, $ShortUrl = null)
	{
		if ($FullUrl != null) {
			$query = "SELECT `ShortUrl` FROM `relation` WHERE `FullUrl`=\"".$FullUrl."\"";
		} else {
			$query = "SELECT `ShortUrl` FROM `relation` WHERE `ShortUrl`=\"".$ShortUrl."\"";
		}
		$row = rowDB(queryDB($query));
		if ($row != null) {
			return pathUrl().$row['ShortUrl'];
		}
		return null;
	}

	function saveUrl($FullUrl, $ShortUrl)
	{
		$query = "INSERT INTO `relation` (`FullUrl`, `ShortUrl`) VALUES (\"".$FullUrl."\", \"".$ShortUrl."\")";
		queryDB($query);
		return pathUrl().$ShortUrl;
	}
	function createUrl()
	{
		$query = "SELECT COUNT(1) FROM `relation`";

		$row = rowDB(queryDB($query));
		$n = $row[0];

		$url = "";
		while (true) {
			$l = $n;
			do {
				$k = $l % 36; // 10 цифр + 26 букв
				$l = (int)($l / 36);

				if ($k < 10) {
					$url .= chr(0x30 + $k); // цифры
				} else {
					$url .= chr(0x41 + $k - 10); // буквы
				}
			} while ($l > 0);

			if (checkUrl(null, $url) == null) {
				return $url;
			}
			$n++;
			$url = "";
		}

		return "";
	}
