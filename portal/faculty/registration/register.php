<?php
require_once('../../../conn.php');
session_start();

// Retrieve data from the registration form
$FacultyId = $_POST['FacultyId'];
$Department = $_POST['Department'];
$Email = $_POST['Email'];
$Password = $_POST['Password'];
$SecurityQuestion = $_POST['SecurityQuestion'];
$SecurityAnswer = $_POST['SecurityAnswer'];

// Check if the FacultyId, Department, and Email exist in the 'Faculty' table
$validationQuery = "SELECT * FROM Faculty WHERE FacultyId = ? AND Department = ? AND Email = ?";
$params = array($FacultyId, $Department, $Email);
$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
$validationStmt = sqlsrv_query($conn, $validationQuery, $params, $options);

if ($validationStmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

if (sqlsrv_num_rows($validationStmt) > 0) {
    // If the FcultyId exists, proceed with the registration
    // Hash the password for security
    $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

    // Insert registration information into 'student_login' table
    $insertQuery = "INSERT INTO Faculty_login (FacultyId, Department, Email, Password, SecurityQuestion, SecurityAnswer) 
                    VALUES (?, ?, ?, ?, ?, ?)";
    $insertParams = array($FacultyId, $Department, $Email, $hashedPassword, $SecurityQuestion, $SecurityAnswer);
    $insertStmt = sqlsrv_query($conn, $insertQuery, $insertParams);

    if ($insertStmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        $_SESSION['FacultyId'] = $FacultyId;
        header("Location: ../$FacultyId");
        exit();
    }
} else {
    echo "Faculty ID, Department, or Email does not match. Registration failed.";
}

sqlsrv_close($conn);
