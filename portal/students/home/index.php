<?php
require_once('../../conn.php');
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
echo "<section class='body'>";
// Check if any records are found
if ($stmt !== false) {
    // Display student information
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo "<div class='student-info'>";
        echo "<div><p>Student ID:</p><p>" . $row["StudentId"] . "</p></div>";
        echo "<div><p>Name:</p><p>" . $row["FirstName"] . " " . $row["LastName"] . "</p></div>";
        // echo "<div><p>Last Name:</p><p>" . $row["LastName"] . "</p></div>";
        echo "<div><p>Batch:</p><p>" . $row["Batch"] . "</p></div>";
        echo "<div><p>Department:</p><p>" . $row["Department"] . "</p></div>";
        echo "<div><p>Program:</p><p>" . $row["Program"] . "</p></div>";
        echo '<br>';
        // echo '<br>';
        echo "<div><p>Date of Birth:</p><p>" . $row["DateOfBirth"]->format('Y-m-d') . "</p></div>";
        echo "<div><p>Registration Number:</p><p>" . $row["RegNo"] . "</p></div>";
        echo "<div><p>Email:</p><p>" . $row["Email"] . "</p></div>";

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
            echo "<div><p>Phone Numbers:</p><p>" . implode(", ", $phoneNumbers) . "</p></div>";
        } else {
            echo "<div><p>Error retrieving phone numbers:</p><p>" . print_r(sqlsrv_errors(), true) . "</p></div>";
        }


        echo "<div><p>Country:</p><p>" . $row["Country"] . "</p></div>";
        echo "<div><p>Semester:</p><p>" . $row["Semester"] . "</p></div>";
        echo "<div><p>Admission Date:</p><p>" . $row["AdmissionDate"] . "</p></div>";
        echo '<br>';
        // echo '<br>';
        echo "<div><p>Mother's Name:</p><p>" . $row["MotherName"] . "</p></div>";
        echo "<div><p>Father's Name:</p><p>" . $row["FatherName"] . "</p></div>";
        echo "<div><p>Father's Occupation:</p><p>" . $row["FatherOccupation"] . "</p></div>";
        echo "<div><p>Parent's Name:</p><p>" . $row["ParentName"] . "</p></div>";
        echo "<div><p>Parent's Connection:</p><p>" . $row["ParentConnection"] . "</p></div>";
        echo "<div><p>Gender:</p><p>" . $row["Gender"] . "</p></div>";
        echo "<div><p>Permanent Address:</p><p>" . $row["PermanentAddress"] . "</p></div>";
        echo "<div><p>Present Address:</p><p>" . $row["PresentAddress"] . "</p></div>";
        echo '<br>';
        echo '<br>';
        echo "<a class='submit' href='./update_info/$studentId'>Update Info</a>";
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

<section class="contact">
    <div class="card">
        <div class="card-content">
            <h2>Contact for Course Registration</h2>
            <p class="name"><i class="fas fa-user"></i>Abu Rasel</p>
            <p class="title"><i class="fas fa-briefcase"></i>Executive</p>
            <p class="phone"><i class="fas fa-phone"></i>+8801715125313</p>
            <p class="email"><i class="fas fa-envelope"></i>aburase1@stamford.university</p>
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <h2>Contact for Readmission / Self-Study</h2>
            <p class="name"><i class="fas fa-user"></i>Mohd. Nural Alam</p>
            <p class="title"><i class="fas fa-briefcase"></i>Asst. Registrar</p>
            <p class="phone"><i class="fas fa-phone"></i>+8801670096935</p>
            <p class="email"><i class="fas fa-envelope"></i>mnalam09@stamford.university</p>
        </div>
    </div>

</section>