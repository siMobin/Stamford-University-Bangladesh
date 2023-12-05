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
echo "<a class='submit' href='./update_info/$studentId'>Update</a>"

// Close the database connection
// sqlsrv_close($conn);
?>
<!--  -->