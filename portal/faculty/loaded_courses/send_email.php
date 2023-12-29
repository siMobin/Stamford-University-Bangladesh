<?php
set_time_limit(0);
require($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']); // .env path
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$parsedown = new ParsedownExtra();

session_start();

$FacultySign = ''; // Initializing the variable to store the FacultySign

// Check if FacultyId is set in the session
if (!isset($_SESSION["FacultyId"])) {
    $FacultySign = "<p style'color:red'>No record found for the Faculty</p>";
} else {
    $FacultyId = $_SESSION["FacultyId"];

    require($_SERVER['DOCUMENT_ROOT'] . '/conn.php');

    // SQL query to fetch details based on FacultyId, joining with Faculty_phone
    $sql = "SELECT Faculty.*, Faculty_phone.Phone 
            FROM Faculty 
            LEFT JOIN Faculty_phone ON Faculty.FacultyId = Faculty_phone.FacultyId 
            WHERE Faculty.FacultyId = ?";

    $params = array($FacultyId);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $FacultySign .= "<small style = 'font-size: 12px; line-height: 1.5'><br> <br> <hr> <br>";
        $FacultySign .= "<strong style = 'font-size: 14px; color:blue;'>" . $row['FirstName'] . " " . $row['LastName'] . "</strong><br>";
        $FacultySign .= $row['Position'] . "<br>";
        $FacultySign .= "Department of " . $row['Department'] . "<br><i> Stamford University Bangladesh </i><br>";
        $FacultySign .= "Email: <a href=" . "mailto:" . $row['Email'] . ">" . $row['Email'] . "</a><br>";

        // Check if phone number exists or is null
        $phone = isset($row['Phone']) ? $row['Phone'] : "<p style'color:red'>No phone number found</p>";
        $FacultySign .= "Contact: " . $phone . "<br></small>";
        $FacultySign .= "<img src = 'https://www.stamforduniversity.edu.bd/asset/images/logoname.png'/>";
    } else {
        $FacultySign .= "<p style'color:red'>No record found for the Faculty</p>";
    }

    // Free the statement and close the connection
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
}


if (isset($_POST['send_email'])) {

    $email_subject = $_POST['email_subject'];

    $email_message = $_POST['email_message'];
    $selected_students = isset($_POST['selected_students']) ? $_POST['selected_students'] : [];

    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV["EMAIL"];
        $mail->Password = $_ENV["MAIL_PASSWORD"];
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Set sender
        $mail->setFrom($_ENV["EMAIL"]);

        // Loop through selected students and add emails directly
        foreach ($selected_students as $email) {
            // Add recipient
            $mail->addAddress($email);
        }

        // Set other email details
        $mail->addReplyTo($_ENV["EMAIL"]);
        $mail->addReplyTo($row['Email']);
        $mail->isHTML(true);
        $mail->Subject = $email_subject;
        $mail->Body = $parsedown->text($email_message) . $FacultySign;

        if (!empty($_FILES['attachment']['name'][0])) {
            foreach ($_FILES['attachment']['tmp_name'] as $key => $tmp_name) {
                $attachment_name = $_FILES['attachment']['name'][$key];
                $mail->addAttachment($tmp_name, $attachment_name);
            }
        }

        // Send emails
        $mail->send();

        $_SESSION['result'] = 'Messages have been sent';
        $_SESSION['status'] = 'ok';
    } catch (Exception $e) {
        $_SESSION['result'] = 'Messages could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        $_SESSION['status'] = 'error';
    }

    header("location: view_students.php?course_code={$_SESSION['courseCode']}");
    set_time_limit(ini_get('max_execution_time'));
}
