<?php
require_once('conn.php');
session_start();

// Check if the user is logged in
if (isset($_SESSION["FacultyId"])) {
    $FacultyId = $_SESSION["FacultyId"];
}

// Query to retrieve faculty information based on studentId and department
$sql = "SELECT * FROM Faculty WHERE FacultyId = ?";
$params = array($FacultyId);

// Execute the query
$stmt = sqlsrv_query($conn, $sql, $params);
echo "<section class='body'>";
// Check if any records are found
if ($stmt !== false) {
    // Display faculty information
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo "<div class='faculty-info'>";
        echo "<div><p>Faculty ID:</p><p>" . $row["FacultyId"] . "</p></div>";
        echo "<div><p>Name:</p><p>" . $row["FirstName"] . " " . $row["LastName"] . "</p></div>";
        // echo "<div><p>Last Name:</p><p>" . $row["LastName"] . "</p></div>";
        echo "<div><p>Department:</p><p>" . $row["Department"] . "</p></div>";
        //echo "<div><p>Program:</p><p>" . $row["Program"] . "</p></div>";
        echo '<br>';
        // echo '<br>';
        echo "<div><p>Date of Birth:</p><p>" . $row["DateOfBirth"]->format('Y-m-d') . "</p></div>";
        echo "<div><p>Email:</p><p>" . $row["Email"] . "</p></div>";

        // Retrieve phone numbers for the student
        $phoneSql = "SELECT Phone FROM Faculty_phone WHERE Facultyid = ?";
        $phoneParams = array($FacultyId);
        $phoneStmt = sqlsrv_query($conn, $phoneSql, $phoneParams);

        // Check if any phone numbers are found
        if ($phoneStmt !== false) {
            $phoneNumbers = array();
            while ($phoneRow = sqlsrv_fetch_array($phoneStmt, SQLSRV_FETCH_ASSOC)) {
                $phoneNumbers[] = $phoneRow["Phone"];
            }
            // Display phone numbers separated by commas
            echo "<div><p>Phone Numbers:</p><p>" . implode(", ", $phoneNumbers) . "</p></div>";
        } else {
            echo "<div><p>Error retrieving phone numbers:</p><p>" . print_r(sqlsrv_errors(), true) . "</p></div>";
        }


        echo "<div><p>Country:</p><p>" . $row["Country"] . "</p></div>";
       // echo "<div><p>Semester:</p><p>" . $row["Subjects"] . "</p></div>";
        
        echo '<br>';
        // echo '<br>';

        echo "<div><p>Gender:</p><p>" . $row["Gender"] . "</p></div>";
        echo "<div><p>Permanent Address:</p><p>" . $row["PermanentAddress"] . "</p></div>";
        echo "<div><p>Present Address:</p><p>" . $row["PresentAddress"] . "</p></div>";
        echo '<br>';
        echo '<br>';
        echo "<a class='submit' href='./update_info/$FacultyId'>Update Info</a>";
        echo '</div>';
    }
} else {
    echo "Error executing query: " . print_r(sqlsrv_errors(), true);
}

// Close the database connection
sqlsrv_close($conn);
?>

<div class="notice">
    <h1>NOTICE BOARD</h1>
    <div class="box">notice</div>
    <div class="box">notice</div>
</div>
</section>



</section>