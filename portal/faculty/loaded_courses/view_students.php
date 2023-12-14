<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>



    <?php
    session_start();

    if (!isset($_SESSION["FacultyId"])) {
        // User isn't logged in, redirect to the login page
        header("Location: ./login/");
        exit;
    } else {
        $FacultyId = $_SESSION["FacultyId"];
    }

    // TODO: Ass icon
    echo "<a href='../$FacultyId'>xbk</a>";

    if (!isset($_GET["course_code"])) {
        // Redirect if course_code is not provided in the URL
        header("Location: ./courses.php"); // Redirect to your courses page
        exit;
    } else {
        $courseCode = $_GET["course_code"];
    }

    require('../../../conn.php');

    // Fetch student details for the selected course
    $query = "SELECT studentID, semester, mid, final, [30%] FROM CRS_confirm WHERE course_code = ?";
    $params = array($courseCode);
    $result = sqlsrv_query($conn, $query, $params);

    if ($result === false) {
        echo "Error fetching student details: " . print_r(sqlsrv_errors(), true);
    } else {
        if (sqlsrv_has_rows($result)) {
            echo "<h1>Student Details for Course: $courseCode</h1>";
            echo "<table border='1'>";
            echo "<tr>
        <th>Student ID</th>
        <th>Semester</th>
  
        <th>Mid</th>
        <th>Final</th>
        <th>30%</th>
        </tr>";
            // TODO: Add batch       <th>Batch</th>

            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['studentID'] . "</td>";
                echo "<td>" . $row['semester'] . "</td>";
                // echo "<td>" . $row['batch'] . "</td>";
                echo "<td>" . $row['mid'] . "</td>";
                echo "<td>" . $row['final'] . "</td>";
                echo "<td>" . $row['30%'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No students found for this course.";
        }
        sqlsrv_free_stmt($result);
    }

    // sqlsrv_close($conn);///////////////
    ////////////////////////////////////// FRIENDS but...
    // require('../../../conn.php');//////

    // Fetch courses for the faculty
    $query = "SELECT course_code, course_name FROM course_load WHERE facultyID = ? and course_code = ?";
    $params = array($FacultyId, $courseCode);
    $result = sqlsrv_query($conn, $query, $params);

    if ($result === false) {
        echo "Error fetching courses: " . print_r(sqlsrv_errors(), true);
    } else {
        if (sqlsrv_has_rows($result)) {

            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $courseCode = $row['course_code'];

                // TODO: list
                // $courseName = $row['course_name'];

                echo "
                    <a class='submit' href='download.php?course_code=$courseCode'>Download</a>
                  ";
            }
        } else {
            echo "Server Error";
        }
    }

    sqlsrv_free_stmt($result);
    sqlsrv_close($conn);
    ?>

</body>

</html>