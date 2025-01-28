<?php

// Lokasi folder file_upload
if ((isset($_SERVER["SERVER_NAME"]))) {
	$base_url = (empty($_SERVER['HTTPS']) or strtolower($_SERVER['HTTPS']) === 'off') ? 'http' : 'https';
	$base_url .= '://' . $_SERVER['SERVER_NAME'];
	if (isset($_SERVER['SERVER_PORT'])) {
		$base_url .= ':' . $_SERVER['SERVER_PORT'];
	}
	$base_url .= substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_FILENAME'])));
} else {
	$base_url = '';
}
// Cek host saat ini
$current_host = $_SERVER['HTTP_HOST'];

// Tentukan jalur berdasarkan host
if ($current_host == '36.88.110.134') {
	// Versi Linux dengan jalur absolut untuk IP tertentu
	defined('FILE_UPLOAD_PATH') or define('FILE_UPLOAD_PATH', '/var/www/html/uploads/');
	defined('FILE_UPLOAD_URL') or define('FILE_UPLOAD_URL', 'http://' . $current_host . '/uploads/');
} else if ($current_host == 'ess.banktanah.id') {
	// Versi Linux dengan jalur relatif untuk domain lain
	defined('FILE_UPLOAD_PATH') or define('FILE_UPLOAD_PATH', dirname($_SERVER['DOCUMENT_ROOT']) . '/uploads/');
	defined('FILE_UPLOAD_URL') or define('FILE_UPLOAD_URL', 'http://banktanah.id/uploads/');
} else {
	// Versi lokal dengan jalur relatif
	defined('FILE_UPLOAD_PATH') or define('FILE_UPLOAD_PATH', FCPATH . '../uploads/');
	defined('FILE_UPLOAD_URL') or define('FILE_UPLOAD_URL', $base_url . '../uploads/');
}
