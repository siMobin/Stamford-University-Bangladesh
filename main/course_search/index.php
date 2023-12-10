<?php
require_once('../../TCPDF/tcpdf.php');
date_default_timezone_set('Asia/Dhaka'); // Set the timezone to Bangladesh

// Function to generate PDF
function generatePDF($department, $courses)
{
    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Stamford University Bangladesh');
    $pdf->SetTitle("Courses for $department department");
    $pdf->SetSubject("Courses for $department department");
    $pdf->SetKeywords('Courses, Department, PDF');


    // $formattedDateTime = "";
    // Get the current date and time with milliseconds
    $currentDateTime = new DateTime();
    $formattedDateTime = $currentDateTime->format("Y-m-d H:i:s.v");

    // Print the formatted date and time
    // Add a page
    $pdf->AddPage();

    $pdf->SetFont('times', 'I', 8);
    $pdf->Cell(0, 0, "Printed on $formattedDateTime", 0, 1, 'L');

    // Set font
    $pdf->SetFont('times', 'B', 16);

    // Add logo (replace 'path/to/logo.png' with the actual path to your logo)
    $logoPath = '../images/logo.png';
    $pdf->Image($logoPath, 100, 10, 20, 0, '', '', '', false, 300, '', false, false, 0);

    // Add big text in the center
    $pdf->SetXY(0, 35);
    $pdf->Cell(0, 0, 'Stamford University Bangladesh', 0, 1, 'C');

    // Generate PDF content
    $pdfContent = '';
    if (isset($courses[$department])) {
        // $pdfContent .= "<h2>Courses for $department department</h2>";
        $pdf->Cell(0, 0, "Courses for $department department", 0, 1, 'C');
        foreach ($courses[$department] as $semester => $coursesList) {
            $pdfContent .= "<h3>Semester $semester:</h3>";
            $pdfContent .= "<table>";
            $pdfContent .= "<tr><th>Course Code</th><th>Name</th><th>Credits</th><th>Prerequisite</th></tr>";
            foreach ($coursesList as $courseCode => $courseDetails) {
                $pdfContent .= "<tr>";
                $pdfContent .= "<td>$courseCode</td>";
                $pdfContent .= "<td>{$courseDetails['name']}</td>";
                $pdfContent .= "<td>{$courseDetails['credit']}</td>";
                $pdfContent .= "<td>";
                if (isset($courseDetails['prerequisite'])) {
                    $pdfContent .= $courseDetails['prerequisite'];
                } else {
                    $pdfContent .= "-";
                }
                $pdfContent .= "</td>";
                $pdfContent .= "</tr>";
            }
            $pdfContent .= "</table>";
        }
    } else {
        $pdfContent .= "<p>Department not found!</p>";
    }

    // Set font back to default
    $pdf->SetFont('times', '', 12);

    // Write content to PDF
    $pdf->writeHTML($pdfContent, true, false, true, false, '');

    // Close and output PDF
    $pdf->Output("Courses_$department.pdf", 'D');

    // Exit the script after sending the PDF
    exit;
}


// Check if form is submitted for generating PDF
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generatePDF"])) {
    if (isset($_POST["department"])) {
        $selectedDepartment = $_POST["department"];
        $jsonData = file_get_contents('../../storage/json_files/course_info.json');
        $courses = json_decode($jsonData, true);
        generatePDF($selectedDepartment, $courses);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../images/logo.png">
    <link rel="stylesheet" href="../style/course_search.css">
    <title>SUB-Course Search</title>
</head>

<body>
    <header>
        <?php
        // TODO: FIx this
        // require '../nav.php';
        ?>
    </header>

    <?php if ($_SERVER["REQUEST_METHOD"] !== "POST") { ?>
        <div class="select_area">
            <label for="department">Select Department:</label>
            <select name="department" id="department">
                <?php
                // Read the JSON file content
                $jsonData = file_get_contents('../../storage/json_files/course_info.json');

                // Decode the JSON data into an associative array
                $courses = json_decode($jsonData, true);

                // Extract department names from the JSON file
                $departmentNames = array_keys($courses);

                // Generate options for dropdown from department names
                foreach ($departmentNames as $department) {
                    echo "<option value=\"$department\">$department</option>";
                }
                ?>
            </select>
        </div>
    <?php } ?>

    <div id="courseList">
        <?php
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get selected department from the form
            if (isset($_POST["department"])) {
                $selectedDepartment = $_POST["department"];

                // Read the JSON file content
                $jsonData = file_get_contents('../../storage/json_files/course_info.json');

                // Decode the JSON data into an associative array
                $courses = json_decode($jsonData, true);

                // Function to display courses for a selected department
                function displayCourseList($department, $courses)
                {
                    ob_start();
                    if (isset($courses[$department])) {
                        echo "<h2>Courses for $department department:</h2>";
                        foreach ($courses[$department] as $semester => $coursesList) {
                            echo "<h3>Semester $semester:</h3>";
                            echo "<table>";
                            echo "  <tr>
                                        <th>Course Code</th>
                                        <th>Name</th>
                                        <th>Credits</th>
                                        <th>Prerequisite</th>
                                    </tr>";
                            foreach ($coursesList as $courseCode => $courseDetails) {
                                echo "<tr>";
                                echo "<td>$courseCode</td>";
                                echo "<td>{$courseDetails['name']}</td>";
                                echo "<td>{$courseDetails['credit']}</td>";
                                echo "<td>";
                                if (isset($courseDetails['prerequisite'])) {
                                    echo $courseDetails['prerequisite'];
                                } else {
                                    echo "-";
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                        }
                    } else {
                        echo "<p>Department not found!</p>";
                    }
                    return ob_get_clean();
                }

                // Display course list for the selected department
                echo displayCourseList($selectedDepartment, $courses);
            }
        }
        ?>
    </div>

    <!-- Add download button -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="generatePDF" value="true">
        <input type="hidden" name="department" value="<?php echo isset($_POST["department"]) ? $_POST["department"] : ''; ?>">
        <button class="submit" type="submit">Download as PDF</button>
    </form>


    <?php
    // TODO: Fix this
    // require '../footer.php';
    ?>

    <script>
        document.getElementById('department').addEventListener('change', function() {
            var department = this.value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("courseList").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("POST", "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("department=" + department);
        });
    </script>
</body>

</html>