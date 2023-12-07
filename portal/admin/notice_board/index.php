<?php
// sometimes this will not work and you need to configure from php.ini file manually.
// ini_set('upload_max_filesize', '20M'); // Set maximum upload file size to 20 megabytes
// ini_set('post_max_size', '20M');        // Set maximum POST data size to 20 megabytes

require_once('../../../tempconn.php');
date_default_timezone_set('Asia/Dhaka');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $content = $_POST['content'];
    $timestamp = date('Y-m-d-H-i-s');

    // Process file upload if a file is provided
    if (isset($_FILES['file']) && $_FILES['file']['error'] !== UPLOAD_ERR_NO_FILE) {

        // Process file upload
        $targetPdf = "../../../storage/pdf/";
        $targetImage = "../../../storage/image/";
        $targetVideo = "../../../storage/video/";

        $fileName = $_FILES['file']['name'];
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $timestampString = str_replace([' ', ':', '-'], '', $timestamp); // Convert timestamp to a string without spaces, colons, and hyphens

        $maxFileSize = 20 * 1024 * 1024; // 20MB in bytes
        if ($_FILES['file']['size'] > $maxFileSize) {
            echo "File size exceeds the 20MB limit.";
            exit;
        }

        switch ($fileType) {
            case 'pdf':
                $filePath = $targetPdf . $timestampString . '_' . $fileName;
                break;
            case 'jpg':
            case 'png':
            case 'webp':
            case 'gif':
                $filePath = $targetImage . $timestampString . '_' . $fileName;
                break;
            case 'mp4':
            case 'webm':
            case 'mov':
                $filePath = $targetVideo . $timestampString . '_' . $fileName;
                break;
            default:
                // Handle other file types or show an error message
                break;
        }

        if (!empty($filePath)) {
            // Move the uploaded file to the specified folder
            move_uploaded_file($_FILES['file']['tmp_name'], $filePath);

            // Insert data into the notice_board table
            $timestampFormatted = date('Y-m-d H:i:s', strtotime($timestampString));
            $sql = "INSERT INTO notice_board (timeStamp, title, content, fileName, filePath, fileType)
                    VALUES ('$timestamp', '$title', '$content', '$fileName', '$filePath', '$fileType')";

            $queryResult = sqlsrv_query($conn, $sql);
            if ($queryResult === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            echo "File uploaded successfully!";
        } else {
            echo "Unsupported file type or error during upload.";
        }

    } else {
        $timestampFormatted = date('Y-m-d H:i:s', strtotime($timestampString));
        $sql = "INSERT INTO notice_board (timeStamp, title, content, fileName, filePath, fileType)
                VALUES ('$timestamp', '$title', '$content', NULL, NULL, NULL)";

        $queryResult = sqlsrv_query($conn, $sql);
        if ($queryResult === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload Form</title>
</head>
<body>
    <h2>File Upload Form</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" required><br>

        <label for="content">Content:</label>
        <textarea name="content" required></textarea><br>

        <label for="file">Choose File (20 MB max):</label>
        <input type="file" name="file" accept=".pdf, .jpg, .png, .webp, .gif, .mp4, .webm, .mov"><br>

        <button type="submit">Upload File</button>
    </form>
</body>
</html>
