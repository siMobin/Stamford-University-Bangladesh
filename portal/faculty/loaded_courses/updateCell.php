<?php
session_start();

if (isset($_SESSION["courseCode"])) {
    $courseCode = $_SESSION["courseCode"];
} else {
    echo 'Browser does not support cookies.';
    exit;
}

require('../../../conn.php');


$sql = "UPDATE CRS_confirm SET " . $_POST['col'] . "='" . $_POST['value'] . "' WHERE studentID='" . $_POST['row'] . "' AND course_code='" . $courseCode . "'";


$getResults = sqlsrv_query($conn, $sql);
if ($getResults == FALSE) {
    die(print_r(sqlsrv_errors(), true));
}

sqlsrv_free_stmt($getResults);