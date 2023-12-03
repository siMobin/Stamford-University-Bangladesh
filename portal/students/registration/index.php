<?php
require_once('../conn.php');


// Initialize variables
$department = '';
$stuID = '';
$name = '';
$dateofbirth = '';
$email = '';
$securityQ = '';
$securityAns = '';
$passcode = '';
$creationDate = date('Y-m-d');
$registrationMessage = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user inputs
    $department = $_POST['department'];
    $stuID = $_POST['stuID'];
    $name = $_POST['name'];
    $dateofbirth = $_POST['dateofbirth'];
    $email = $_POST['email'];
    $securityQ = $_POST['securityQ'];
    $securityAns = $_POST['securityAns'];
    $passcode = password_hash($_POST['passcode'], PASSWORD_BCRYPT);

    // Insert data into Student_info table
    $sqlInfo = "INSERT INTO Student_info (department, StuID, name_, dateofbirth, email, SecurityQ, Securityans, creationdate) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $paramsInfo = array($department, $stuID, $name, $dateofbirth, $email, $securityQ, $securityAns, $creationDate);

    $stmtInfo = sqlsrv_query($conn, $sqlInfo, $paramsInfo);

    // Insert data into Student_login table
    $sqlLogin = "INSERT INTO Student_login (department, ID, passcode) VALUES (?, ?, ?)";
    $paramsLogin = array($department, $stuID, $passcode);

    $stmtLogin = sqlsrv_query($conn, $sqlLogin, $paramsLogin);

    // Check if both queries were successful
    if ($stmtInfo && $stmtLogin) {
        $registrationMessage = "Registration successful";
    } else {
        $registrationMessage = "Registration failed";
    }

    // Close the statements
    sqlsrv_free_stmt($stmtInfo);
    sqlsrv_free_stmt($stmtLogin);
}

// Close the database connection
sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
</head>

<body>
    <h2>Student Registration</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="department">Department:</label>
        <input type="text" name="department" id="department" required>
        <br>

        <label for="stuID">Student ID:</label>
        <input type="text" name="stuID" id="stuID" required>
        <br>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <br>

        <label for="dateofbirth">Date of Birth:</label>
        <input type="date" name="dateofbirth" id="dateofbirth" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>

        <label for="securityQ">Security Question:</label>
        <input type="text" name="securityQ" id="securityQ" required>
        <br>

        <label for="securityAns">Security Answer:</label>
        <input type="text" name="securityAns" id="securityAns" required>
        <br>

        <label for="passcode">Password:</label>
        <input type="password" name="passcode" id="passcode" required>
        <br>

        <input type="submit" value="Register">
    </form>

    <?php echo $registrationMessage; ?>
</body>

</html>