<?php
	require_once "../sql.php";
	require_once "create.php";

	$inputUrl = $_POST["inputUrl"];
	$customUrl = $_POST["customUrl"];
	if ($inputUrl == null) {
		echo "Введите ссылку";
		exit;
	}

	// Проверка корректности введеных данных
	if (!strpos($inputUrl, "://")) {
		$inputUrl = "http://".$inputUrl;
	}
	if (!filter_var($inputUrl, FILTER_VALIDATE_URL)) {	// && $otvet=@get_headers($inputUrl) && substr($otvet[0], 9, 3) != 404)) {
		echo "Введена некорректная ссылка";
		exit;
	}

	connectDB();

	$outputUrl = null;
	// Если введен пользовательский вариант ссылки
	if ($customUrl != null) {
		if (!filter_var(pathUrl().$customUrl, FILTER_VALIDATE_URL)) {
			echo "Данная ссылка не может быть использованна в качестве сокращения";
		} elseif (checkUrl(null, $customUrl) != null) {
			echo "Данная ссылка уже используется в качестве сокращения";
		} else {
			$outputUrl = saveUrl($inputUrl, $customUrl);
		}
	} else {
		// Проверяем наличие уже сгенерированной ссылки
		$outputUrl = checkUrl($inputUrl);
		if ($outputUrl == null) {
			// Создаем ссылку
			$outputUrl = createUrl();
			$outputUrl = saveUrl($inputUrl, $outputUrl);
		}
	}
	// Вывод результата
	if ($outputUrl != null) {
		echo "<div>Ваша ссылка: <a type=\"url\" href=\"".$outputUrl."\" target=\"_parent\">".$outputUrl."</a></div>";
	}

	disconnectDB();
