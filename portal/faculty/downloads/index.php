<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/main';

$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
$host = 'http://' . $_SERVER['HTTP_HOST'];
$hostPath = $host . "/main";

// echo "<link rel='stylesheet' href='$hostPath/style/downloads.css'>";

require $_SERVER['DOCUMENT_ROOT'] . '/main/downloads/body.php';
?>
<!--  -->