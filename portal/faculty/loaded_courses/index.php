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

// Check if the form is submitted for removing a course
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_course'])) {
    $courseCodeToRemove = $_POST['course_code'];

    // Remove the course from the database
    $removeQuery = "DELETE FROM course_load WHERE facultyID = ? AND course_code = ?";
    $removeParams = array($FacultyId, $courseCodeToRemove);
    $removeResult = sqlsrv_query($conn, $removeQuery, $removeParams);

    if ($removeResult === false) {
        echo "Error removing course: " . print_r(sqlsrv_errors(), true);
    } else {
        // Redirect to faculty/index.php after removing the course
        header("Location: ../");
        exit;
    }
}

// Fetch courses for the faculty
$query = "SELECT * FROM course_load WHERE facultyID = ?";
$params = array($FacultyId);
$result = sqlsrv_query($conn, $query, $params);

if ($result === false) {
    echo "Error fetching courses: " . print_r(sqlsrv_errors(), true);
} else {
    if (sqlsrv_has_rows($result)) {
        echo "<h1>List of Courses</h1>";
        echo "<table >";
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $courseCode = $row['course_code'];
            $courseName = $row['course_name'] ?? 'Database Error';
            $batch = $row['batch'];

            echo "
            <tr>
                <td>
                    <li>
                        $courseCode - $courseName 
                    </li>
                </td>

                <td>
                        $batch
                </td>

                <td>
                    <a href='./loaded_courses/view_students.php?course_code=$courseCode'>View Details</a>
                </td>

                <td>
                    <form method='post' action='" . $_SERVER['PHP_SELF'] . "'>
                        <input type='hidden' name='course_code' value='$courseCode'>
                        <input class='submit' type='submit' name='remove_course' value='Unload'>
                    </form>
                </td>                
            </tr>";
        }
        echo "</table>";
    } else {
        echo "No courses found for this faculty.";
    }
}

sqlsrv_free_stmt($result);
sqlsrv_close($conn);
