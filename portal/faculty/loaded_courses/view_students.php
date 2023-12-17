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
        $_SESSION['courseCode'] = $courseCode;
    }


    require('../../../conn.php');

        // Fetch student details for the selected course, including firstname, lastname, and email
        $query = "SELECT c.studentID, c.mid, c.final, c.thirtyPercent, 
        CONCAT(s.FirstName, ' ', s.LastName) AS name, s.Email
 FROM CRS_confirm c
 INNER JOIN students s ON c.studentID = s.StudentId
 WHERE c.course_code = ?";
$params = array($courseCode);
$result = sqlsrv_query($conn, $query, $params);
if ($result === false) {
die(print_r(sqlsrv_errors(), true));
}


echo '<table id="sqlTable">';
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $row['total']=$row['mid'] + $row['final'] + $row['thirtyPercent'] ;
echo '<tr>';
echo '<td>' . $row['studentID'] . '</td>';
echo '<td>' . $row['name'] . '</td>';
echo '<td>' . $row['Email'] . '</td>';
// echo '<td>' . $row['batch'] . '</td>';
echo '<td contenteditable="true" data-col="mid" data-row="' . $row['studentID'] . '">' . $row['mid'] . '</td>';
echo '<td contenteditable="true" data-col="final" data-row="' . $row['studentID'] . '">' . $row['final'] . '</td>';
echo '<td contenteditable="true" data-col="thirtyPercent" data-row="' . $row['studentID'] . '">' . $row['thirtyPercent'] . '</td>';
echo '<td>' . $row['total'] . '</td>';
echo '</tr>';
}
echo '</table>';

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $('#sqlTable td').on('input', function() {
        var col = $(this).data('col');
        var row = $(this).data('row');
        var value = $(this).text();
        $.post('updateCell.php', {
            col: col,
            row: row,
            value: value
        });
    });
</script>
</body>



</html>
