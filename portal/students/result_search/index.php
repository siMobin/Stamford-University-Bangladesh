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

// Include the database connection file
require('../../../conn.php');

/**
 * Displays the results of the CRS_confirm table for a given student ID and semester.
 *
 * @param resource $conn The connection to the database.
 * @param int $studentId The ID of the student.
 * @param string $semester The semester for which to display the results.
 * @throws Exception If there is an error in the SQL query execution.
 * @return void
 */
function displayResults($conn, $studentId, $semester)
{
    $query = "SELECT * FROM CRS_confirm WHERE studentID = ? AND semester = ?";
    $stmt = sqlsrv_query($conn, $query, array(&$studentId, &$semester));

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true)); // Check for errors in the query execution
    }

    // Initialize variables for CGPA calculation
    $totalCredits = 0;
    $totalGradePoints = 0;

    // Display the matching courses
    echo "<table class='result_table' border='1' style=' border-collapse: collapse;'>
    <tr>
    <th>Course Code</th>
    <th>Name</th>
    <th>Semester</th>
    <th>Mid</th>
    <th>Final</th>
    <th>30%</th>
    <th>Total</th>
    <th>CGPA</th>
    <th>Grade</th>
    </tr>";

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // Process each course
        echo "<tr>";
        echo "<td>" . (isset($row['course_code']) ? $row['course_code'] : '') . "</td>";
        echo "<td>" . (isset($row['courseName']) ? $row['courseName'] : '') . "</td>";
        echo "<td>" . (isset($row['semester']) ? $row['semester'] : '') . "</td>";
        echo "<td>" . (isset($row['mid']) ? $row['mid'] : '') . "</td>";
        echo "<td>" . (isset($row['final']) ? $row['final'] : '') . "</td>";
        echo "<td>" . (isset($row['30%']) ? $row['30%'] : '') . "</td>";

        // Calculate CGPA for each course
        // TODO: Update credit dynamically
        $courseCredits = 3; // Assuming each course has 3 credits, adjust as needed
        $gradePoints = calculateGradePoints($row['mid'], $row['final'], $row['30%']);
        $totalCredits += $courseCredits;
        $totalGradePoints += $gradePoints;
        global $totalScore;
        $totalScore = $row['mid'] + $row['final'] + $row['30%'];

        echo "<td>" . $totalScore . "</td>";

        // $cgpa = ($totalCredits > 0) ? (($totalScore / $totalCredits) / 10) : 0;
        $grade = calculateGrade($gradePoints);

        echo "<td>" . number_format($gradePoints, 2) . "</td>";
        echo "<td>" . $grade . "</td>";

        echo "</tr>";
    }
    echo "</table>";

    sqlsrv_free_stmt($stmt);
}

/**
 * Calculates the grade points based on the scores of the midterm, final, and thirty percent components.
 *
 * This is a simplified example; adjust it based on your grading system.
 *
 * @param int $mid The score of the midterm component.
 * @param int $final The score of the final component.
 * @param int $thirtyPercent The score of the thirty percent component.
 * @return float The calculated grade points.
 */
function calculateGradePoints($mid, $final, $thirtyPercent)
{
    // Implement your own logic for calculating grade points based on scores
    // This is a simplified example; adjust it based on your grading system
    $totalScore = $mid + $final + $thirtyPercent;

    if ($totalScore >= 80) {
        return 4.0;
    } elseif ($totalScore >= 75) {
        return 3.5;
    } elseif ($totalScore >= 70) {
        return 3.0;
    } elseif ($totalScore >= 65) {
        return 2.5;
    } elseif ($totalScore >= 60) {
        return 2.0;
    } elseif ($totalScore >= 55) {
        return 1.5;
    } elseif ($totalScore >= 50) {
        return 1.0;
    } else {
        return 0.0;
    }
}

/**
 * Calculate the grade based on the given CGPA.
 *
 * @param float $cgpa The CGPA to calculate the grade for.
 * @return string The calculated grade.
 */
function calculateGrade($cgpa)
{
    // Implement your own logic for assigning grades based on CGPA
    // This is a simplified example; adjust it based on your grading system
    if ($cgpa >= 4) {
        return 'A+';
    } elseif ($cgpa >= 3.5) {
        return 'A';
    } elseif ($cgpa >= 3.0) {
        return 'B';
    } elseif ($cgpa >= 2.5) {
        return 'C';
    } elseif ($cgpa >= 2.0) {
        return 'D';
    } else {
        return 'F';
    }
}

// Check if the AJAX request is made
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if 'semester' is set in POST data
    if (isset($_POST['semester'])) {
        $selectedSemester = $_POST['semester'];

        // Call the displayResults function
        displayResults($conn, $studentId, $selectedSemester);
        exit;
    }
}
?>

<form method="post" id="searchForm">
    <label for="semester">Select Semester:</label>
    <?php
    //Select Query
    $sql = "SELECT DISTINCT semester FROM CRS_confirm Order by semester";
    $getResults = sqlsrv_query($conn, $sql);

    if ($getResults == FALSE)
        die(print_r(sqlsrv_errors(), true));

    echo "<select name='semester' id='semester'>";
    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
        echo "<option value='" . $row['semester'] . "'>" . $row['semester'] . "</option>";
    }
    echo "</select>";
    sqlsrv_free_stmt($getResults);
    ?>

    <input class="submit" type="button" value="Search" id="searchButton">
</form>

<!-- TODO: Add function/option to show total cgpa -->

<!-- Container to display results -->
<div id="resultContainer">
    <!-- Results will be displayed here -->
</div>


<script>
    function searchResults() {
        var selectedSemester = $("#semester").val();

        $.ajax({
            type: "POST",
            url: "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>",
            data: {
                semester: selectedSemester
            },
            success: function(response) {
                // Display the results in the resultContainer
                $("#resultContainer").html(response);
            }
        });
    }

    // Attach the event handler to the searchButton
    $("#searchButton").click(searchResults);

    // Call the function when the page loads
    searchResults();
</script>

<?php
// Close the database connection
sqlsrv_close($conn);
?>