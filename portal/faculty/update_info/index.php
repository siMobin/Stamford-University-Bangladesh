<?php
require_once('../../conn.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (isset($_SESSION["FacultyId"])) {
        $studentId = $_SESSION["FacultyId"];
    }

    if (isset($_POST["Email"])) {
        $email = $_POST["Email"];
        $updateEmailSql = "UPDATE Faculty SET Email = ? WHERE FacultyId = ?";
        $updateEmailParams = array($Email, $_SESSION["FacultyId"]);
        $updateEmailStmt = sqlsrv_query($conn, $updateEmailSql, $updateEmailParams);
        $updateEmailSql = "UPDATE Faculty_login SET Email = ? WHERE FacultyId = ?";
        $updateEmailStmt = sqlsrv_query($conn, $updateEmailSql, $updateEmailParams);
    }

    $phones = $_POST["phones"];
  
    foreach ($phones as $index => $phone) {
        // Get the corresponding connection type from the form
       

        $UpdatePhoneQuery = "UPDATE Faculty_phone SET Phone = ? WHERE Facultyid = ?";
        $paramsPhone = array($phone, $_SESSION["FacultyId"]);
        $stmtPhone = sqlsrv_query($conn, $UpdatePhoneQuery, $paramsPhone);

        if ($stmtPhone === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    if (isset($_POST["presentAddress"])) {
        $presentAddress = $_POST["presentAddress"];
        $updatePresentAddressSql = "UPDATE Faculty SET PresentAddress = ? WHERE FacultyId = ?";
        $updatePresentAddressParams = array($presentAddress, $_SESSION["FacultyId"]);
        $updatePresentAddressStmt = sqlsrv_query($conn, $updatePresentAddressSql, $updatePresentAddressParams);
    }



   

   

    if (isset($_POST["SecurityQuestion"])) {
        $securityQuestion = $_POST["SecurityQuestion"];
        $updatesecurityQuestionSql = "UPDATE Faculty_login SET SecurityQuestion = ? WHERE FacultyId = ?";
        $updatesecurityQuestionParams = array($SecurityQuestion, $_SESSION["FacultyId"]);
        $updatesecurityQuestionStmt = sqlsrv_query($conn, $updatesecurityQuestionSql, $updatesecurityQuestionParams);
    }

    if (isset($_POST["SecurityAnswer"])) {
        $securityAnswer = $_POST["SecurityAnswer"];
        $updatesecurityAnswerSql = "UPDATE Faculty_login SET SecurityAnswer = ? WHERE FacultyId = ?";
        $updatesecurityAnswerParams = array($securityAnswer, $_SESSION["FacultyId"]);
        $updatesecurityAnswerStmt = sqlsrv_query($conn, $updatesecurityAnswerSql, $updatesecurityAnswerParams);
    }

    header("Location: ../");
    exit();
}

if (isset($_SESSION["FacultyId"])) {
    $FacultyId = $_SESSION["FacultyId"];

    // Query to retrieve existing information based on FacultyId
    $sql = "SELECT * FROM Faculty WHERE FacultyId = ?";
    $params = array($FacultyId);
    $stmt = sqlsrv_query($conn, $sql, $params);

    // Fetch Faculty information
    if ($stmt !== false) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        // Assign fetched values to variables
        $email = $row['Email'];
        $presentAddress = $row['PresentAddress'];
        $permanentAddress = $row['PermanentAddress'];
        
    }
}

if (isset($_SESSION["FacultyId"])) {
    $FacultyId = $_SESSION["FacultyId"];

    // Query to retrieve existing information based on FacultyId
    $sql = "SELECT SecurityQuestion, SecurityAnswer FROM Faculty_login WHERE FacultyId = ?";
    $params = array($FacultyId);
    $stmt = sqlsrv_query($conn, $sql, $params);

    // Fetch Faculty information
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

          


            <!-- <div> -->
            <button class="submit" type="button" onclick="addPhoneNumber()">Add More Phones</button>
            <button class="submit" type="button" onclick="removePhoneNumber()">Remove Last Phone</button>
            <!-- </div> -->

            <div>
                <label for="presentAddress">Present Address</label>
                <input type="text" name="presentAddress" value="<?php echo $presentAddress; ?>">
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