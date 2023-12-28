<?php
set_time_limit(0);
require_once('../../../vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']); // .env path
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

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
        $mail->isHTML(true);
        $mail->Subject = $email_subject;
        $mail->Body = $email_message;

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
    // exit;
}
