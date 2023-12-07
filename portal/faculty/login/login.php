<?php
require_once('../../../conn.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $FacultyId = $_POST['FacultyId'];
    $Email = $_POST['Email'];
    $Department = $_POST['Department'];
    $Password = $_POST['Password'];

    // Retrieve the stored password for the given credentials
    $query = "SELECT Password FROM Faculty_login WHERE FacultyId = ? AND Email = ? AND Department = ?";
    $params = array($FacultyId, $Email, $Department);
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
        if (password_verify($Password, $storedPassword)) {
            // Passwords match, proceed with login
            $_SESSION['FacultyId'] = $FacultyId;
            header("Location: ../$FacultyId");
            exit();
        } else {
            echo "Incorrect password. Please try again.";
        }
    } else {
        echo "Invalid credentials. Please check your Faculty ID, Email, and Department.";
    }
}

sqlsrv_close($conn);
