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

require('../../../conn.php');

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
foreach ($matchingCourses as $course) {
    $courseCode = $course['courseCode'];
    $semester = $course['semester'];
        // Check to see if courses are already registered for the same student and semester.
        $sqlcheck = "SELECT * FROM CRS_confirm WHERE course_code = ? AND studentID = ? AND semester = ?";
        $params_check = array($courseCode, $studentId, $semester);
        $options_check = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $result_check = sqlsrv_query($conn, $sqlcheck, $params_check, $options_check);
    
        if (!$result_check) {
            // Handle query error
            die(print_r(sqlsrv_errors(), true));
        }
    }
    
        $num_rows = sqlsrv_num_rows($result_check);
if($num_rows > 0){
    echo "You are already registered for all the courses!";
}
else
if ($dueamount <= 0) {
    ?>
    
     <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
     <input type="submit" name="register" value="Register">
     </form>
     <?php
} else {
    echo "Please pay your dues before registering.";
}

// Check if the register button is clicked
if (isset($_POST['register'])) {
    require('../../../conn.php');
    // Establish a new connection for the registration process
    $conn = sqlsrv_connect($serverName, $connectionInfo);

    // Check connection
    if (!$conn) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Iterate through matching courses and insert into CRS_confirm table
    foreach ($matchingCourses as $course) {
        $courseCode = $course['courseCode'];
        $semester = $course['semester'];

            // Insert data into CRS_confirm table
            $sql_insert = "INSERT INTO CRS_confirm (course_code, studentID, semester) VALUES (?, ?, ?)";
            $params_insert = array($courseCode, $studentId, $semester);
            $options_insert = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
            $result_insert = sqlsrv_query($conn, $sql_insert, $params_insert, $options_insert);
    
            if (!$result_insert) {
                // Handle insertion error (you can customize this part)
                die(print_r(sqlsrv_errors(), true));
            // }
        }
    }
    if (isset($_SESSION['success_message'])) {
        echo "<script>alert('{$_SESSION['success_message']}');</script>";
        unset($_SESSION['success_message']);
    } elseif (isset($_SESSION['error_message'])) {
        echo "<script>alert('{$_SESSION['error_message']}');</script>";
        unset($_SESSION['error_message']);
    }
    $_SESSION['success_message'] = "Your courses have been successfully registered";


    header("Location: ../");
    

    exit;
}

// Close the database connection
sqlsrv_close($conn);
?>
