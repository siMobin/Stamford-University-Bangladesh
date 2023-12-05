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
        $updateEmailSql = "UPDATE student_login SET Email = ? WHERE StudentId = ?";
        $updateEmailStmt = sqlsrv_query($conn, $updateEmailSql, $updateEmailParams);
    }

    $phones = $_POST["phones"];
    $connectionTypes = $_POST["connectionTypes"];

    foreach ($phones as $index => $phone) {
        // Get the corresponding connection type from the form
        $connectionType = $connectionTypes[$index];

        $insertPhoneQuery = "INSERT INTO phone (StudentId, Phone, ConnectionType) VALUES (?, ?, ?)";
        $paramsPhone = array($studentId, $phone, $connectionType);
        $stmtPhone = sqlsrv_query($conn, $insertPhoneQuery, $paramsPhone);

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
<script>
    // JavaScript to add and remove phone number input fields
function addPhoneNumber() {
    var container = document.getElementById("phoneContainer");

    // Create and append phone number input and connection type dropdown
    var phoneGroup = createPhoneGroup();
    container.appendChild(phoneGroup);
}

function removePhoneNumber() {
    var container = document.getElementById("phoneContainer");
    var phoneGroups = container.getElementsByClassName("phone-group");

    // Ensure there is at least one phone number input
    if (phoneGroups.length >= 1) {
        container.removeChild(phoneGroups[phoneGroups.length - 1]);
    }
}

function createPhoneGroup() {
    var phoneGroup = document.createElement("div");
    phoneGroup.className = "phone-group";

    // Create and append phone number input
    var input = createPhoneNumberInput();
    phoneGroup.appendChild(input);

    // Create and append connection type dropdown directly in HTML
    phoneGroup.innerHTML += `
        <label for="connectionTypes[]">Connection Type:</label>
        <select name="connectionTypes[]" required>
            <option value="self">Self</option>
            <option value="parent">Parent</option>
            <option value="guardian">Guardian</option>
        </select>
    `;

    return phoneGroup;
}

function createPhoneNumberInput() {
    var input = document.createElement("input");
    input.type = "text";
    input.name = "phones[]";
    input.placeholder = "Phone Number";
    return input;
}
</script>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" required value="<?php echo isset($email) ? $email : ''; ?>"><br>

        <label for="phones">New Phone Numbers:</label>
        <div id="phoneContainer">
            <input type="text" name="phones[]" placeholder="Phone Number" required>
            <label for="connectionTypes[]">Connection Type:</label>
            <select name="connectionTypes[]" required>
                <option value="self">Self</option>
                <option value="parent">Parent</option>
                <option value="guardian">Guardian</option>
            </select>
        </div>

        <button type="button" onclick="addPhoneNumber()">Add More Phones</button>
        <button type="button" onclick="removePhoneNumber()">Remove Last Phone</button>

        <label for="presentAddress">Present Address:</label>
        <input type="text" name="presentAddress" value="<?php echo isset($presentAddress) ? $presentAddress : ''; ?>"><br>

        <label for="parentName">Guardian Name</label>
        <input type="text" name="parentName" value="<?php echo isset($parentName) ? $parentName : ''; ?>"><br>

        <label for="parentConnection">Guardian Connection</label>
        <input type="text" name="parentConnection" value="<?php echo isset($parentConnection) ? $parentConnection : ''; ?>"><br>

        <label for="fatherOccupation">Father's Occupation</label>
        <input type="text" name="fatherOccupation" value="<?php echo isset($fatherOccupation) ? $fatherOccupation : ''; ?>"><br>

        <label class="required" for="securityQuestion">Security Question</label>
                    <select id="securityQuestion" name="securityQuestion" required>
                        <!-- <option value="">Select a security question</option> -->
                        <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                        <option value="What is the name of your first pet?">What is the name of your first pet?</option>
                        <option value="In which city were you born?">In which city were you born?</option>
                    </select>

        <label class="required" for="securityAnswer">Security Answer</label>
         <input type="text" id="securityAnswer" name="securityAnswer" required>            

        <input type="submit" value="Update Information">
    </form>

</body>

</html>