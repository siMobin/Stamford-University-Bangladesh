<?php
require_once('../../conn.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = $_POST['studentId'];
    $batch = $_POST['batch'];
    $department = $_POST['department'];
    $password = $_POST['password'];

    // Retrieve the stored password for the given credentials
    $query = "SELECT Password FROM student_login WHERE StudentId = ? AND Batch = ? AND Department = ?";
    $params = array($studentId, $batch, $department);
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $stmt = sqlsrv_query($conn, $query, $params, $options);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_num_rows($stmt) == 1) {
        // Fetch the retrieved password
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $storedPassword = $row['Password'];

        // Password comparison
        if (password_verify($password, $storedPassword)) {
            // Passwords match, proceed with login
            $_SESSION['studentId'] = $studentId;
            header("Location: ../$studentId");
            exit();
        } else {
            echo "Incorrect password. Please try again.";
        }
    } else {
        echo "Invalid credentials. Please check your Student ID, Batch, and Department.";
    }
}

sqlsrv_close($conn);
