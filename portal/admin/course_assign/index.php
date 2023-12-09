<?php
require('../../../conn.php');

// Function to get the current semester
function getSemester()
{
    $currentMonth = date("n");
    $currentYear = date("Y");

    if ($currentMonth >= 5 && $currentMonth <= 8) {
        return "Summer $currentYear";
    } elseif ($currentMonth > 11) {
        return "Spring " . ($currentYear + 1);
    } elseif ($currentMonth < 3) {
        return "Spring $currentYear";
    } else {
        return "Unknown Semester";
    }
}

// Handle form submission and process assignment
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department = $_POST["department"];
    $semester = $_POST["semester"];
    $batch = $_POST["batch"];
    $flag = $_POST["flag"];
    $overrideFlag = isset($_POST["override_flag"]) ? 1 : 0; // Check if the checkbox is checked

    // Retrieve assigned courses based on form data
    $assignedCourses = [];

    if ($overrideFlag) {
        // Manual override: use manually entered courses
        $assignedCourses = isset($_POST["courses"]) ? $_POST["courses"] : [];
    } else {
        $jsonFile = '../../../storage/json_files/course_info.json';
        $jsonData = file_get_contents($jsonFile);
        $courseInfo = json_decode($jsonData, true);

        // Fetch course codes based on semester_flag
        $semesterFlag = $_POST["flag"];
        $assignedCourses = array_keys($courseInfo[$_POST["department"]][$semesterFlag]);
    }

    // Insert into course_assign table
    foreach ($assignedCourses as $courseCode) {
        $insertQuery = "INSERT INTO course_assign (course_code, department, semester, batch)
                        VALUES (?, ?, ?, ?)";
        $params = array($courseCode, $department, $semester, $batch);
        $insertResult = sqlsrv_query($conn, $insertQuery, $params);

        if (!$insertResult) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo "Course $courseCode assigned successfully!<br>";
        }
    }
    echo "Courses assigned successfully!";
}
?>

<h2>Course Assignment</h2>
<form class="course_assign" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="department">Department:</label>
    <select name="department" required>
        <option value="BBA">BBA</option>
        <option value="BPH">BPH</option>
        <option value="EEE">EEE</option>
        <option value="MBO">MBO</option>
        <option value="LLB">LLB</option>
        <option value="CEN">CEN</option>
        <option value="ENG">ENG</option>
        <option value="FLM">FLM</option>
        <option value="CSE">CSE</option>
        <option value="ECO">ECO</option>
        <option value="ENV">ENV</option>
        <option value="JRN">JRN</option>
        <option value="ARC">ARC</option>
        <option value="BPA">BPA</option>
        <option value="MBA">MBA</option>
        <option value="MCA">MCA</option>
        <option value="MFF">MFF</option>
        <option value="MFM">MFM</option>
        <option value="ENP">ENP</option>
        <option value="ENF">ENF</option>
        <option value="MMB">MMB</option>
        <option value="MES">MES</option>
        <option value="MPA">MPA</option>
        <option value="LMF">LMF</option>
        <option value="LMP">LMP</option>
        <option value="MPM">MPM</option>
        <option value="MJP">MJP</option>
        <option value="MJR">MJR</option>
        <option value="MEC">MEC</option>
        <option value="JLC">JLC</option>
        <option value="CNA">CNA</option>
    </select>

    <label for="semester">Semester:</label>
    <input type="text" name="semester" value="<?= getSemester(); ?>">

    <label class="required" for="batch">Batch:</label>
    <input type="text" name="batch" required placeholder="Enter Batch">

    <label for="flag">Select Flag:</label>
    <select name="flag" id="flagSelect" required>
        <!-- Options will be dynamically added using JavaScript -->
    </select>

    <label for="override">Override Flag:</label>
    <input type="checkbox" name="override_flag" id="override_flag" onclick="toggleCourseButtons()">

    <br>
    <br>
    <hr>

    <div id="courseList">
        <!-- JavaScript will add input boxes here based on user interaction -->
    </div>

    <button class="submit" type="button" id="addCourseBtn" style="display:none" onclick="addCourse()">Add Course</button>
    <button class="submit" type="button" id="removeCourseBtn" style="display:none" onclick="removeCourse()">Remove Course</button>

    <br><br>

    <input class="submit" type="submit" value="Assign Courses">
</form>
<!-- <script src="../script/course_assign.js"></script> -->