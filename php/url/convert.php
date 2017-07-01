<?php
	require_once "../sql.php";
	require_once "create.php";

	$inputUrl = $_POST["inputUrl"];
	$customUrl = $_POST["customUrl"];
	if ($inputUrl == null) {
		echo "������� ������";
		exit;
	}

	// �������� ������������ �������� ������
	if (!strpos($inputUrl, "://")) {
		$inputUrl = "http://".$inputUrl;
	}
	if (!filter_var($inputUrl, FILTER_VALIDATE_URL)) {	// && $otvet=@get_headers($inputUrl) && substr($otvet[0], 9, 3) != 404)) {
		echo "������� ������������ ������";
		exit;
	}

	connectDB();

	$outputUrl = null;
	// ���� ������ ���������������� ������� ������
	if ($customUrl != null) {
		if (!filter_var(pathUrl().$customUrl, FILTER_VALIDATE_URL)) {
			echo "������ ������ �� ����� ���� ������������� � �������� ����������";
		} elseif (checkUrl(null, $customUrl) != null) {
			echo "������ ������ ��� ������������ � �������� ����������";
		} else {
			$outputUrl = saveUrl($inputUrl, $customUrl);
		}
	} else {
		// ��������� ������� ��� ��������������� ������
		$outputUrl = checkUrl($inputUrl);
		if ($outputUrl == null) {
			// ������� ������
			$outputUrl = createUrl();
			$outputUrl = saveUrl($inputUrl, $outputUrl);
		}
	}
	// ����� ����������
	if ($outputUrl != null) {
		echo "<div>���� ������: <a type=\"url\" href=\"".$outputUrl."\" target=\"_parent\">".$outputUrl."</a></div>";
	}

	disconnectDB();
