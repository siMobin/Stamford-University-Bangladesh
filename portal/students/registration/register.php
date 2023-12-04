<?php
require_once('../conn.php');
session_start();

// Retrieve data from the registration form
$studentId = $_POST['studentId'];
$batch = $_POST['batch'];
$department = $_POST['department'];
$email = $_POST['email'];
$password = $_POST['password'];
$securityQuestion = $_POST['securityQuestion'];
$securityAnswer = $_POST['securityAnswer'];

// Check if the StudentId, Batch, Department, and Email exist in the 'students' table
$validationQuery = "SELECT * FROM students WHERE StudentId = ? AND Batch = ? AND Department = ? AND Email = ?";
$params = array($studentId, $batch, $department, $email);
$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
$validationStmt = sqlsrv_query($conn, $validationQuery, $params, $options);

if ($validationStmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

if (sqlsrv_num_rows($validationStmt) > 0) {
    // If the StudentId exists, proceed with the registration
    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert registration information into 'student_login' table
    $insertQuery = "INSERT INTO student_login (StudentId, Batch, Department, Email, Password, SecurityQuestion, SecurityAnswer) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
    $insertParams = array($studentId, $batch, $department, $email, $hashedPassword, $securityQuestion, $securityAnswer);
    $insertStmt = sqlsrv_query($conn, $insertQuery, $insertParams);

    if ($insertStmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        $_SESSION['studentId'] = $studentId;
        header("Location: ../$studentId");
        exit();
    }
} else {
    echo "Student ID, Batch, Department, or Email does not match. Registration failed.";
}

sqlsrv_close($conn);
