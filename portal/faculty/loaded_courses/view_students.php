<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/main';

$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') !== false ? 'https://' : 'http://';
$host = 'http://' . $_SERVER['HTTP_HOST'];
$hostPath = $host . "/main";
$node_modulesPath = $host . "/node_modules";

session_start();

if (!isset($_SESSION["FacultyId"])) {
    // User isn't logged in, redirect to the login page
    header("Location: ../login/");
    exit;
} else {
    $FacultyId = $_SESSION["FacultyId"];
}

echo "<a class='back_to' href='../$FacultyId'><i class='fa-solid fa-arrow-right-from-bracket fa-rotate-180'></i>BACK</a>";

if (!isset($_GET["course_code"])) {
    // Redirect if course_code is not provided in the URL
    header("Location: ../"); // Redirect to your courses page
    exit;
} else {
    $courseCode = $_GET["course_code"];
    $_SESSION['courseCode'] = $courseCode;
}

require($_SERVER['DOCUMENT_ROOT'] . '/conn.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "SUB-$FacultyId@$courseCode"; ?></title>
    <link rel="stylesheet" href="./view_students.css">
</head>

<body>
    <form method="POST" action="send_email.php" enctype="multipart/form-data">

        <?php
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
        echo '<div class="table_wrapper">';
        echo '<table id="sqlTable" border="1">';
        echo '<tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mail To</th>
            <th>Mid</th>
            <th>Final</th>
            <th>30%</th>
            <th>Total</th>';
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $row['total'] = $row['mid'] + $row['final'] + $row['thirtyPercent'];
            echo '<tr>';
            echo '<td>' . $row['studentID'] . '</td>';
            echo '<td>' . $row['name'] . '</td>';
            echo '<td class="email">' . $row['Email'] . '</td>';
            // Add checkbox for each student
            echo '<td><input type="checkbox" checked name="selected_students[]" value="' . $row['Email'] . '">
      
            <span>
                <i class="fa-solid fa-check-double"></i>
            </span>
         
            </td>';
            echo '<td contenteditable="true" data-col="mid" data-row="' . $row['studentID'] . '">' . $row['mid'] . '</td>';
            echo '<td contenteditable="true" data-col="final" data-row="' . $row['studentID'] . '">' . $row['final'] . '</td>';
            echo '<td contenteditable="true" data-col="thirtyPercent" data-row="' . $row['studentID'] . '">' . $row['thirtyPercent'] . '</td>';
            echo '<td>' . $row['total'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '<br>';

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

                    echo "<a class='submit' href='download.php?course_code=$courseCode'>Download</a>";
                }
            } else {
                echo "Server Error";
            }
        }

        sqlsrv_free_stmt($result);
        sqlsrv_close($conn);
        ?>

        <br>
        <br>
        <h1 class="mail_title">Send Email To Selected Students</h1>

        <div class="mail_box">
            <div class="box">
                <label class="required">Subject</label>
                <input type="text" name="email_subject" spellcheck="true" required placeholder="Subject" autocomplete="off" autocapitalize="on">
            </div>

            <div class="box">
                <label>
                    Body
                    <span>
                        <strong> 💡 </strong>
                        Your email client supports HTML and Markdown formats. Visit
                        <a href="https://www.w3schools.com/html/" target="_blank">HTML Guide</a>
                        or
                        <a href="https://www.markdownguide.org" target="_blank">Markdown Guide</a>
                        for more information.
                    </span>
                </label>

                <textarea name="email_message" rows="5" cols="150" spellcheck="true" placeholder="Message"></textarea>
            </div>


            <div class="box">
                <label>Attachments</label>
                <div><strong>Drag and Drop files of Select Files</strong>
                    <input type="file" name="attachment[]" onchange="readFiles(this);" onclick="this.value=null;" id="file" multiple>
                </div>
                <div id="previews"></div>
            </div>

        </div>

        <?php
        if (isset($_SESSION['status'])) {
            if ($_SESSION['status'] == "ok") {
        ?>
                <div class="alert alert-info"><?php echo $_SESSION['result'] ?></div>
            <?php
            } else {
            ?>
                <div class="alert alert-danger"><?php echo $_SESSION['result'] ?></div>
        <?php
            }
            unset($_SESSION['result']);
            unset($_SESSION['status']);
        }
        ?>

        <button type="submit" name="send_email" class="submit">Send Email</button>

    </form>

    <script src="<?php echo  $node_modulesPath; ?>/jquery/dist/jquery.min.js"></script>
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
    <script src="<?php echo  $host; ?>/portal/faculty/script/input_preview.js"></script>
</body>

</html>