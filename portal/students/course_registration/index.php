<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION["studentId"])) {
    // User isn't logged in, redirect to the login page
    header("Location: ./login/");
    exit;
} else {
    $studentId = $_SESSION["studentId"];
}

// Extract department and batch from student ID
$department = substr($studentId, 0, 3);
$batch = substr($studentId, 3, 3);

require_once('../../../conn.php');

// Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionInfo);

// Check connection
if (!$conn) {
    die(print_r(sqlsrv_errors(), true));
}

// SQL query to retrieve courses based on department and batch
$sql = "SELECT course_code, semester FROM course_assign WHERE department = ? AND batch = ?";
$params = array($department, $batch);
$options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
$result = sqlsrv_query($conn, $sql, $params, $options);

$dueamount = 10;

// Fetch additional info from course_info.json
$jsonFilePath = '../../../storage/json_files/course_info.json';
$courseInfo = json_decode(file_get_contents($jsonFilePath), true);

$matchingCourses = array(); // Store matching courses in an array

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $courseCode2 = $row["course_code"];
    $semester = $row["semester"];

    // Check if the department exists in course_info.json
    if (isset($courseInfo[$department])) {
        foreach ($courseInfo[$department] as $courses) {
            foreach ($courses as $courseCode => $courseDetails) {
                if ($courseCode === $courseCode2) {
                    // Store matching course details in the array
                    $matchingCourses[] = array(
                        'courseCode' => $courseCode,
                        'semester' => $semester,
                        'name' => $courseDetails['name'],
                        'credit' => $courseDetails['credit'],
                        'prerequisites' => isset($courseDetails['prerequisite']) ? $courseDetails['prerequisite'] : 'None',
                    );
                }
            }
        }
    }
}

// Display the matching courses
echo "<h2>Courses Offered:</h2>";
echo "<table border='1'><tr><th>Course Code</th><th>Semester</th><th>Name</th><th>Credit</th><th>Prerequisites</th></tr>";

foreach ($matchingCourses as $course) {
    // Process each course
    echo "<tr><td>{$course['courseCode']}</td><td>{$course['semester']}</td><td>{$course['name']}</td><td>{$course['credit']}</td><td>{$course['prerequisites']}</td></tr>";
}
echo "</table>";
if($dueamount <= 0){
    echo '<form action="CRSregister.php" method="post">';
    echo '<input type="submit" name="register" value="Register">';
    echo '</form>'; }
    else{
    echo "Please pay your dues before registering.";
    }

// Close the database connection
sqlsrv_close($conn);
?>

</body>
</html>
