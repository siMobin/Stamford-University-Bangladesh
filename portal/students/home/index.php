<?php
require_once('../../../conn.php');
session_start();

// Check if the user is logged in
if (isset($_SESSION["studentId"])) {
    $studentId = $_SESSION["studentId"];

}

// Query to retrieve student information based on studentId and department
$sql = "SELECT * FROM students WHERE StudentId = ?";
$params = array($studentId);

// Execute the query
$stmt = sqlsrv_query($conn, $sql, $params);

// Check if any records are found
if ($stmt !== false) {
    // Display student information
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo "Student ID: " . $row["StudentId"] . "<br>";
        echo "First Name: " . $row["FirstName"] . "<br>";
        echo "Last Name: " . $row["LastName"] . "<br>";
        echo "Date of Birth: " . $row["DateOfBirth"]->format('Y-m-d') . "<br>";
        echo "Registration Number: " . $row["RegNo"] . "<br>";
        echo "Email: " . $row["Email"] . "<br>";
                // Retrieve phone numbers for the student
                $phoneSql = "SELECT Phone FROM phone WHERE StudentId = ?";
                $phoneParams = array($studentId);
                $phoneStmt = sqlsrv_query($conn, $phoneSql, $phoneParams);
        
                // Check if any phone numbers are found
                if ($phoneStmt !== false) {
                    $phoneNumbers = array();
                    while ($phoneRow = sqlsrv_fetch_array($phoneStmt, SQLSRV_FETCH_ASSOC)) {
                        $phoneNumbers[] = $phoneRow["Phone"];
                    }
                    // Display phone numbers separated by commas
                    echo "Phone Numbers: " . implode(", ", $phoneNumbers) . "<br>";
                } else {
                    echo "Error retrieving phone numbers: " . print_r(sqlsrv_errors(), true) . "<br>";
                }
        echo "Batch: " . $row["Batch"] . "<br>";
        echo "Department: " . $row["Department"] . "<br>";
        echo "Program: " . $row["Program"] . "<br>";
        echo "Country: " . $row["Country"] . "<br>";
        echo "Semester: " . $row["Semester"] . "<br>";
        echo "Admission Date: " . $row["AdmissionDate"] . "<br>";
        echo "Mother's Name: " . $row["MotherName"] . "<br>";
        echo "Father's Name: " . $row["FatherName"] . "<br>";
        echo "Father's Occupation: " . $row["FatherOccupation"] . "<br>";
        echo "Parent's Name: " . $row["ParentName"] . "<br>";
        echo "Parent's Connection: " . $row["ParentConnection"] . "<br>";
        echo "Gender: " . $row["Gender"] . "<br>";
        echo "Permanent Address: " . $row["PermanentAddress"] . "<br>";
        echo "Present Address: " . $row["PresentAddress"] . "<br>";
 
    }

} else {
    echo "Error executing query: " . print_r(sqlsrv_errors(), true);
}

    // Update Email
    $newEmail = $_POST["newEmail"];
    $updateEmailSql = "UPDATE students SET Email = ? WHERE StudentId = ?";
    $updateEmailParams = array($newEmail, $_SESSION["studentId"]);
    $updateEmailStmt = sqlsrv_query($conn, $updateEmailSql, $updateEmailParams);

    // Update Phone numbers
    // Assuming phone numbers are provided as a comma-separated string in the form
    $newPhoneNumbers = $_POST["newPhoneNumbers"];
    $phoneNumbersArray = explode(",", $newPhoneNumbers);
    
    foreach ($phoneNumbersArray as $phoneNumber) {
        // Retrieve the selected connection type from the form
        $connectionType = $_POST["connectionType"];
    
        $insertPhoneSql = "INSERT INTO phone (StudentId, Phone, ConnectionType) VALUES (?, ?, ?)";
        $insertPhoneParams = array($_SESSION["studentId"], $phoneNumber, $connectionType);
        $insertPhoneStmt = sqlsrv_query($conn, $insertPhoneSql, $insertPhoneParams);
    }
            // Update Present Address
            if (isset($_POST["newPresentAddress"])) {
                $newPresentAddress = $_POST["newPresentAddress"];
                $updatePresentAddressSql = "UPDATE students SET PresentAddress = ? WHERE StudentId = ?";
                $updatePresentAddressParams = array($newPresentAddress, $_SESSION["studentId"]);
                $updatePresentAddressStmt = sqlsrv_query($conn, $updatePresentAddressSql, $updatePresentAddressParams);
            }
    
            // Update Permanent Address
            if (isset($_POST["newPermanentAddress"])) {
                $newPermanentAddress = $_POST["newPermanentAddress"];
                $updatePermanentAddressSql = "UPDATE students SET PermanentAddress = ? WHERE StudentId = ?";
                $updatePermanentAddressParams = array($newPermanentAddress, $_SESSION["studentId"]);
                $updatePermanentAddressStmt = sqlsrv_query($conn, $updatePermanentAddressSql, $updatePermanentAddressParams);
            }
    
            // Update Parent Name
            if (isset($_POST["newParentName"])) {
                $newParentName = $_POST["newParentName"];
                $updateParentNameSql = "UPDATE students SET ParentName = ? WHERE StudentId = ?";
                $updateParentNameParams = array($newParentName, $_SESSION["studentId"]);
                $updateParentNameStmt = sqlsrv_query($conn, $updateParentNameSql, $updateParentNameParams);
            }
    
            // Update Parent Connection
            if (isset($_POST["newParentConnection"])) {
                $newParentConnection = $_POST["newParentConnection"];
                $updateParentConnectionSql = "UPDATE students SET ParentConnection = ? WHERE StudentId = ?";
                $updateParentConnectionParams = array($newParentConnection, $_SESSION["studentId"]);
                $updateParentConnectionStmt = sqlsrv_query($conn, $updateParentConnectionSql, $updateParentConnectionParams);
            }
    
            // Update Father's Occupation
            if (isset($_POST["newFatherOccupation"])) {
                $newFatherOccupation =($_POST["newFatherOccupation"]);
                $updateFatherOccupationSql = "UPDATE students SET FatherOccupation = ? WHERE StudentId = ?";
                $updateFatherOccupationParams = array($newFatherOccupation, $_SESSION["studentId"]);
                $updateFatherOccupationStmt = sqlsrv_query($conn, $updateFatherOccupationSql, $updateFatherOccupationParams);
            }
    

// Close the database connection
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
    <label for="newEmail">New Email:</label>
    <input type="email" name="newEmail" required><br>

    <label for="newPhoneNumbers">New Phone Numbers (comma-separated):</label>
    <input type="text" name="newPhoneNumbers" required><br>

    <!-- Dropdown menu for Connection Type -->
    <label for="connectionType">Connection Type:</label>
    <select name="connectionType" required>
        <option value="Self">Self</option>
        <option value="Parent">Parent</option>
        <option value="Guardian">Guardian</option>
    </select><br>

    
    <label for="newPresentAddress">New Present Address:</label>
    <input type="text" name="newPresentAddress"><br>

    <label for="newPermanentAddress">New Permanent Address:</label>
    <input type="text" name="newPermanentAddress"><br>

    <label for="newParentName">New Parent Name:</label>
    <input type="text" name="newParentName"><br>

    <label for="newParentConnection">New Parent Connection:</label>
    <input type="text" name="newParentConnection"><br>

    <label for="newFatherOccupation">New Father's Occupation:</label>
    <input type="text" name="newFatherOccupation"><br>

    <input type="submit" value="Update Information">
</form>

</body>
</html>
