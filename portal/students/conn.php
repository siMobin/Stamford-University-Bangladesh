<?php
// Set the database connection details
$serverName = "DESKTOP-34HOJHD\SQLEXPRESS2"; //DESKTOP-34HOJHD\SQLEXPRESS2,ACER_LAPTOP\SQLEXPRESS
$connectionInfo = array("Database" => "University");
$conn = sqlsrv_connect($serverName, $connectionInfo);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}