<?php
session_start();

// Check if the faculty is logged in
if (!isset($_SESSION["FacultyId"])) {
    // User isn't logged in, redirect to the login page
    header("Location: ./login/");
    exit;
} else {
    $FacultyId = $_SESSION["FacultyId"];
}

// Include your database connection file
require('../../../conn.php');

// Get courses based on semester and batch selections
if (isset($_POST['search'])) {
    $selectedSemester = $_POST['semester'];
    $selectedBatch = $_POST['batch'];

    $facultyCoursesQuery = "SELECT course_code, department, semester, batch FROM course_assign WHERE semester = ? AND batch = ?";
    $params = array($selectedSemester, $selectedBatch);
    $getCourses = sqlsrv_query($conn, $facultyCoursesQuery, $params);

    if ($getCourses === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}
?>
<html>

<head>
    <title>Faculty Course Load</title>
</head>

<body>
    <h1>Faculty Course Load</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="semester">Select Semester:</label>
        <select name="semester" id="semester">
            <?php
            // Retrieve distinct semesters and batches from course_assign
            $getDistinctDataQuery = "SELECT DISTINCT semester FROM course_assign";
            $distinctData = sqlsrv_query($conn, $getDistinctDataQuery);

            while ($row = sqlsrv_fetch_array($distinctData, SQLSRV_FETCH_ASSOC)) {
                $semester = $row['semester'];
                $batch = $row['batch'];
                echo "<option value='" .  $semester . "'>" .  $semester . "</option>";
            }
            ?>
        </select>

        <label for="batch">Select Batch:</label>
        <select name="batch" id="batch">
            <?php
            // Retrieve distinct semesters and batches from course_assign
            $getDistinctDataQuery = "SELECT DISTINCT batch FROM course_assign";
            $distinctData = sqlsrv_query($conn, $getDistinctDataQuery);
            while ($row = sqlsrv_fetch_array($distinctData, SQLSRV_FETCH_ASSOC)) {
                $semester = $row['semester'];
                $batch = $row['batch'];
                echo "<option value='" .  $batch . "'>" .  $batch . "</option>";
            }
            ?>
        </select>
        <input type="submit" name="search" value="Search Courses">
    </form>

    <?php
    // Display the retrieved data or form to input data into course_load
    if (isset($getCourses)) {
    ?>
        <form method="post" action="">
            <input type="hidden" name="semester" value="<?php echo $selectedSemester; ?>">
            <input type="hidden" name="batch" value="<?php echo $selectedBatch; ?>">
            <table>
                <tr>
                    <th>Course Code</th>
                    <th>Department</th>
                    <th>Semester</th>
                    <th>Batch</th>
                    <th>Select Course</th>
                </tr>
                <?php
                while ($row = sqlsrv_fetch_array($getCourses, SQLSRV_FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td><?php echo $row['course_code']; ?></td>
                        <td><?php echo $row['department']; ?></td>
                        <td><?php echo $row['semester']; ?></td>
                        <td><?php echo $row['batch']; ?></td>
                        <td>
                            <input type="hidden" name="department[]" value="<?php echo $row['department']; ?>">
                            <input type="radio" name="selected_course" value="<?php echo $row['course_code']; ?>">
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>
            <input type="submit" name="load" value="Load Course">
        </form>
    <?php
    }
    ?>

    <?php
    // Insert data into course_load on form submission
    if (isset($_POST['load'])) {
        $selectedCourses = isset($_POST['selected_course']) ? (array)$_POST['selected_course'] : array();
        $departments = $_POST['department'];

        // Find the index of the selected course in the array
        $selectedDepartment = '';
        foreach ($selectedCourses as $code) {
            $index = array_search($code, (array)$_POST['selected_course']);
            if ($index !== false && isset($departments[$index])) {
                $selectedDepartment = $departments[$index];
                break;
            }
        }

        $insertQuery = "INSERT INTO course_load (course_code, facultyID, semester, department, batch) VALUES (?, ?, ?, ?, ?)";
        $params = array($selectedCourses[0], $FacultyId, $_POST['semester'], $selectedDepartment, $_POST['batch']);

        // Execute the insertion query
        $insertResult = sqlsrv_query($conn, $insertQuery, $params);

        if ($insertResult === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Redirect to the portal after insertion
        header("Location: ../");
        exit;
    }

    // Close the connection
    sqlsrv_close($conn);
    ?>
</body>

</html>