<?php
require_once('../../conn.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (isset($_SESSION["studentId"])) {
        $studentId = $_SESSION["studentId"];
    }

    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        $updateEmailSql = "UPDATE students SET Email = ? WHERE StudentId = ?";
        $updateEmailParams = array($email, $_SESSION["studentId"]);
        $updateEmailStmt = sqlsrv_query($conn, $updateEmailSql, $updateEmailParams);
        $updateEmailSql = "UPDATE student_login SET Email = ? WHERE StudentId = ?";
        $updateEmailStmt = sqlsrv_query($conn, $updateEmailSql, $updateEmailParams);
    }

    $phones = $_POST["phones"];
    $connectionTypes = $_POST["connectionTypes"];

    foreach ($phones as $index => $phone) {
        // Get the corresponding connection type from the form
        $connectionType = $connectionTypes[$index];

        $UpdatePhoneQuery = "UPDATE phone SET Phone = ?, ConnectionType = ? WHERE StudentID = ?";
        $paramsPhone = array($phone, $connectionType, $_SESSION["studentId"]);
        $stmtPhone = sqlsrv_query($conn, $UpdatePhoneQuery, $paramsPhone);

        if ($stmtPhone === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    if (isset($_POST["presentAddress"])) {
        $presentAddress = $_POST["presentAddress"];
        $updatePresentAddressSql = "UPDATE students SET PresentAddress = ? WHERE StudentId = ?";
        $updatePresentAddressParams = array($presentAddress, $_SESSION["studentId"]);
        $updatePresentAddressStmt = sqlsrv_query($conn, $updatePresentAddressSql, $updatePresentAddressParams);
    }

    if (isset($_POST["parentName"])) {
        $parentName = $_POST["parentName"];
        $updateParentNameSql = "UPDATE students SET ParentName = ? WHERE StudentId = ?";
        $updateParentNameParams = array($parentName, $_SESSION["studentId"]);
        $updateParentNameStmt = sqlsrv_query($conn, $updateParentNameSql, $updateParentNameParams);
    }

    if (isset($_POST["parentConnection"])) {
        $parentConnection = $_POST["parentConnection"];
        $updateParentConnectionSql = "UPDATE students SET ParentConnection = ? WHERE StudentId = ?";
        $updateParentConnectionParams = array($parentConnection, $_SESSION["studentId"]);
        $updateParentConnectionStmt = sqlsrv_query($conn, $updateParentConnectionSql, $updateParentConnectionParams);
    }

    if (isset($_POST["fatherOccupation"])) {
        $fatherOccupation = $_POST["fatherOccupation"];
        $updateFatherOccupationSql = "UPDATE students SET FatherOccupation = ? WHERE StudentId = ?";
        $updateFatherOccupationParams = array($fatherOccupation, $_SESSION["studentId"]);
        $updateFatherOccupationStmt = sqlsrv_query($conn, $updateFatherOccupationSql, $updateFatherOccupationParams);
    }

    if (isset($_POST["securityQuestion"])) {
        $securityQuestion = $_POST["securityQuestion"];
        $updatesecurityQuestionSql = "UPDATE student_login SET securityQuestion = ? WHERE StudentId = ?";
        $updatesecurityQuestionParams = array($securityQuestion, $_SESSION["studentId"]);
        $updatesecurityQuestionStmt = sqlsrv_query($conn, $updatesecurityQuestionSql, $updatesecurityQuestionParams);
    }

    if (isset($_POST["securityAnswer"])) {
        $securityAnswer = $_POST["securityAnswer"];
        $updatesecurityAnswerSql = "UPDATE student_login SET securityAnswer = ? WHERE StudentId = ?";
        $updatesecurityAnswerParams = array($securityAnswer, $_SESSION["studentId"]);
        $updatesecurityAnswerStmt = sqlsrv_query($conn, $updatesecurityAnswerSql, $updatesecurityAnswerParams);
    }

    header("Location: ../");
    exit();
}

if (isset($_SESSION["studentId"])) {
    $studentId = $_SESSION["studentId"];

    // Query to retrieve existing information based on studentId
    $sql = "SELECT * FROM students WHERE StudentId = ?";
    $params = array($studentId);
    $stmt = sqlsrv_query($conn, $sql, $params);

    // Fetch student information
    if ($stmt !== false) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        // Assign fetched values to variables
        $email = $row['Email'];
        $presentAddress = $row['PresentAddress'];
        $permanentAddress = $row['PermanentAddress'];
        $parentName = $row['ParentName'];
        $parentConnection = $row['ParentConnection'];
        $fatherOccupation = $row['FatherOccupation'];
    }
}

if (isset($_SESSION["studentId"])) {
    $studentId = $_SESSION["studentId"];

    // Query to retrieve existing information based on studentId
    $sql = "SELECT SecurityQuestion, SecurityAnswer FROM student_login WHERE StudentId = ?";
    $params = array($studentId);
    $stmt = sqlsrv_query($conn, $sql, $params);

    // Fetch student information
    if ($stmt !== false) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        // Assign fetched values to variables
        $SecurityQuestion = $row['SecurityQuestion'];
        $SecurityAnswer = $row['SecurityAnswer'];
    }
}

sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../images/logo.png">
    <title>Update Information</title>

    <link rel="stylesheet" href="./Update_info.css">
</head>

<body>
    <h1>Update Account Information</h1>

    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" required value="<?php echo $email; ?>">
            </div>

            <div>
                <label class="required" for="phones">Phone Numbers</label>
                <span id="phoneContainer">
                    <input type="text" name="phones[]" placeholder="Phone Number" required>
                </span>
            </div>

            <div>
                <label for="connectionTypes[]">Connection Type</label>
                <select name="connectionTypes[]" required>
                    <option value="self">Self</option>
                    <option value="parent">Parent</option>
                    <option value="guardian">Guardian</option>
                </select>

            </div>


            <!-- <div> -->
            <button class="submit" type="button" onclick="addPhoneNumber()">Add More Phones</button>
            <button class="submit" type="button" onclick="removePhoneNumber()">Remove Last Phone</button>
            <!-- </div> -->

            <div>
                <label for="presentAddress">Present Address</label>
                <input type="text" name="presentAddress" value="<?php echo $presentAddress; ?>">
            </div>

            <div>
                <label for="parentName">Guardian Name</label>
                <input type="text" name="parentName" value="<?php echo $parentName; ?>">
            </div>

            <div>
                <label for="parentConnection">Guardian Connection</label>
                <input type="text" name="parentConnection" value="<?php echo $parentConnection; ?>">
            </div>

            <div>
                <label for="fatherOccupation">Father's Occupation</label>
                <input type="text" name="fatherOccupation" value="<?php echo $fatherOccupation; ?>">
            </div>

            <div>
                <label for="securityQuestion">Security Question</label>
                <select id="securityQuestion" name="securityQuestion" required>
                    <option value="<?php echo $SecurityQuestion; ?>"><?php echo $SecurityQuestion; ?></option>
                    <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                    <option value="What is the name of your first pet?">What is the name of your first pet?</option>
                    <option value="In which city were you born?">In which city were you born?</option>
                </select>
            </div>

            <div>
                <label for="securityAnswer">Security Answer</label>
                <input type="text" id="securityAnswer" name="securityAnswer" value="<?php echo $SecurityAnswer; ?>" required>
            </div>
            <br>
            <input class="submit submit_main" type="submit" value="Update Information">
        </form>
    </div>
    <script src="../script/Updateinfo.js"></script>
</body>

</html>