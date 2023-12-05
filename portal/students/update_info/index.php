<?php
require_once('../../../conn.php');
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
    }

    if (isset($_POST["phoneNumbers"])) {
        $phoneNumbers = $_POST["phoneNumbers"];
        $phoneNumbersArray = explode(",", $phoneNumbers);
        foreach ($phoneNumbersArray as $phoneNumber) {
            if (isset($_POST["connectionType"])) {
                $connectionType = $_POST["connectionType"];
                $insertPhoneSql = "INSERT INTO phone (StudentId, Phone, ConnectionType) VALUES (?, ?, ?)";
                $insertPhoneParams = array($_SESSION["studentId"], $phoneNumber, $connectionType);
                $insertPhoneStmt = sqlsrv_query($conn, $insertPhoneSql, $insertPhoneParams);
            }
        }
    }

    if (isset($_POST["presentAddress"])) {
        $presentAddress = $_POST["presentAddress"];
        $updatePresentAddressSql = "UPDATE students SET PresentAddress = ? WHERE StudentId = ?";
        $updatePresentAddressParams = array($presentAddress, $_SESSION["studentId"]);
        $updatePresentAddressStmt = sqlsrv_query($conn, $updatePresentAddressSql, $updatePresentAddressParams);
    }

    // if (isset($_POST["newPermanentAddress"])) {
    //     $newPermanentAddress = $_POST["newPermanentAddress"];
    //     $updatePermanentAddressSql = "UPDATE students SET PermanentAddress = ? WHERE StudentId = ?";
    //     $updatePermanentAddressParams = array($newPermanentAddress, $_SESSION["studentId"]);
    //     $updatePermanentAddressStmt = sqlsrv_query($conn, $updatePermanentAddressSql, $updatePermanentAddressParams);
    // }

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

    sqlsrv_close($conn);
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

sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Information</title>
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" required value="<?php echo isset($email) ? $email : ''; ?>"><br>

        <label for="phoneNumbers">Phone Numbers (comma-separated)</label>
        <input type="text" name="phoneNumbers" required><br>

        <label for="connectionType">Connection Type:</label>
        <select name="connectionType" required>
            <option value="Self">Self</option>
            <option value="Parent">Parent</option>
            <option value="Guardian">Guardian</option>
        </select><br>

        <label for="presentAddress">Present Address:</label>
        <input type="text" name="presentAddress" value="<?php echo isset($presentAddress) ? $presentAddress : ''; ?>"><br>

        <!-- <label for="newPermanentAddress">New Permanent Address:</label>
        <input type="text" name="newPermanentAddress" value="<?php //echo isset($permanentAddress) ? $permanentAddress : ''; 
                                                                ?>"><br> -->

        <label for="parentName">Guardian Name</label>
        <input type="text" name="parentName" value="<?php echo isset($parentName) ? $parentName : ''; ?>"><br>

        <label for="parentConnection">Guardian Connection</label>
        <input type="text" name="parentConnection" value="<?php echo isset($parentConnection) ? $parentConnection : ''; ?>"><br>

        <label for="fatherOccupation">Father's Occupation</label>
        <input type="text" name="fatherOccupation" value="<?php echo isset($fatherOccupation) ? $fatherOccupation : ''; ?>"><br>

        <input type="submit" value="Update Information">
    </form>

</body>

</html>