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

// Load course information from JSON file
$jsonFilePath = '../../../storage/json_files/course_info.json';
$courseInfo = json_decode(file_get_contents($jsonFilePath), true);

// Function to fetch and display results
function displayResults($conn, $studentId, $semester, $courseInfo)
{
    $query = "SELECT * FROM CRS_confirm WHERE studentID = ? AND semester = ?";
    $stmt = sqlsrv_query($conn, $query, array(&$studentId, &$semester));

    $department = substr($studentId, 0, 3);
    $jsonFilePath = '../../../storage/json_files/course_info.json';
    $courseInfo = json_decode(file_get_contents($jsonFilePath), true);

    $matchingCourses = array(); // Store matching courses in an array

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $courseCode2 = $row["course_code"];
        $semester = $row["semester"];
        $mid = $row["mid"];
        $final = $row["final"];
        $percentage = $row["30%"];

        // Check if the department exists in course_info.json
        if (isset($courseInfo[$department])) {
            foreach ($courseInfo[$department] as $courses) {
                foreach ($courses as $courseCode => $courseDetails) {
                    if ($courseCode === $courseCode2) {
                        // Store matching course details in the array, including mid, final, and 30%
                        $matchingCourses[] = array(
                            'courseCode' => $courseCode,
                            'semester' => $semester,
                            'name' => $courseDetails['name'],
                            'mid' => $mid,
                            'final' => $final,
                            '30%' => $percentage
                        );
                    }
                }
            }
        }
    }

    // Display the matching courses
    echo "<table border='1'><tr><th>Course Code</th><th>Name</th><th>Semester</th><th>Mid</th><th>Final</th><th>30%</th></tr>";

    foreach ($matchingCourses as $course) {
        // Process each course
        echo "<tr><td>{$course['courseCode']}</td><td>{$course['name']}</td><td>{$course['semester']}</td><td>{$course['mid']}</td><td>{$course['final']}</td><td>{$course['30%']}</td></tr>";
    }

    sqlsrv_free_stmt($stmt);
}
// Check if the AJAX request is made
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if 'semester' is set in POST data
    if (isset($_POST['semester'])) {
        $selectedSemester = $_POST['semester'];

        // Call the displayResults function
        displayResults($conn, $studentId, $selectedSemester, $courseInfo);
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Results</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <h2>Welcome, <?php echo $studentId; ?>!</h2>
    <form method="post" id="searchForm">
        <label for="semester">Select Semester:</label>
        <select name="semester" id="semester">
            <!-- Add your semester options dynamically if needed -->
            <option value="Spring 2024">Spring 2024</option>
            <option value="Summer 2023">Summer 2023</option>
        </select>
        <input type="button" value="Search" id="searchButton">
    </form>

    <!-- Container to display results -->
    <div id="resultContainer"></div>

    <!-- <script>
        function searchResults() {
            var selectedSemester = $("#semester").val();

            $.ajax({
                type: "POST",
                url: "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>",
                data: { semester: selectedSemester },
                success: function (response) {
                    // Display the results in the resultContainer
                    $("#resultContainer").html(response);
                }
            });
        }

        $(document).ready(function () {
            // Attach the event handler to the searchButton
            $("#searchButton").click(searchResults);

            // Call the function when the page loads
            searchResults();
        });
    </script> -->
</body>

</html>

<?php
// Close the database connection
sqlsrv_close($conn);
?>
