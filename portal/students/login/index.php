<?php
require_once('../conn.php');

// Initialize variables
$department = '';
$id = '';
$password = '';
$loginMessage = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user inputs
    $department = $_POST['department'];
    $id = $_POST['ID'];
    $password = $_POST['passcode'];

    // Query the database for the login credentials
    $sql = "SELECT passcode FROM Student_login WHERE department = ? AND ID = ?";
    $params = array($department, $id);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Fetch the result
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    // Verify the password
    if ($row && password_verify($password, $row['passcode'])) {
        // Password is correct, redirect to studentdash.php
        header("Location: studentdash.php");
        exit();
    } else {
        // Invalid login credentials
        $loginMessage = "Invalid login credentials";
    }

    // Close the statement
    sqlsrv_free_stmt($stmt);
}

// Close the database connection
sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>

<body>
    <h2>Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="department">Department:</label>
        <input type="text" name="department" id="department" required>
        <br>

        <label for="ID">ID:</label>
        <input type="text" name="ID" id="ID" required>
        <br>

        <label for="passcode">Password:</label>
        <input type="password" name="passcode" id="passcode" required>
        <br>

        <input type="submit" value="Login">
    </form>

    <?php echo $loginMessage; ?>
</body>

</html>