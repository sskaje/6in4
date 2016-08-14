<?php

if (!isset($_SERVER['PHP_AUTH_USER'])) {
	echo "Missing HTTP Auth User";
	exit;
}

if (!preg_match('#^\d+$#', $_SERVER['PHP_AUTH_USER'])) {
	echo "Invalid HTTP Auth User";
	exit;
}

$id = (int) $_SERVER['PHP_AUTH_USER'];

$shell_file = realpath(__DIR__ . '/../bin/6to4');

$ip = isset($_GET['ip']) && $_GET['ip'] ? $_GET['ip'] : '';
if (!$ip) {
	if (isset($_SERVER['HTTP_INCAP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_INCAP_CLIENT_IP'];
	} else if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
		$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
}

