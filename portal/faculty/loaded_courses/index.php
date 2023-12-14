<?php
session_start();

if (!isset($_SESSION["FacultyId"])) {
    // User isn't logged in, redirect to the login page
    header("Location: ./login/");
    exit;
} else {
    $FacultyId = $_SESSION["FacultyId"];
}

require('../../../conn.php');

// Fetch courses for the faculty
$query = "SELECT course_code, course_name FROM course_load WHERE facultyID = ?";
$params = array($FacultyId);
$result = sqlsrv_query($conn, $query, $params);

if ($result === false) {
    echo "Error fetching courses: " . print_r(sqlsrv_errors(), true);
} else {
    if (sqlsrv_has_rows($result)) {
        echo "<h1>List of Courses</h1>";
        echo "<ul>";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $courseCode = $row['course_code'];
            $courseName = $row['course_name'];

            echo "<li>$courseCode - $courseName 
                    <a href='./loaded_courses/view_students.php?course_code=$courseCode'>View Details</a>
                  </li>";
        }
        echo "</ul>";
    } else {
        echo "No courses found for this faculty.";
    }
}

sqlsrv_free_stmt($result);
sqlsrv_close($conn);
