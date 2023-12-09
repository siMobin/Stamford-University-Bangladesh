<?php
// sometimes this will not work and you need to configure from php.ini file manually.
// ini_set('upload_max_filesize', '20M'); // Set maximum upload file size to 20 megabytes
// ini_set('post_max_size', '20M');        // Set maximum POST data size to 20 megabytes

require_once('../../../conn.php');
date_default_timezone_set('Asia/Dhaka');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // $title = $_POST['title'];
    $title = htmlspecialchars($_POST["title"]);
    // $content = $_POST['content'];
    $content = htmlspecialchars($_POST["content"]);
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

            $sql = "INSERT INTO notice_board (timeStamp, title, content, fileName, filePath, fileType)
                    VALUES ('$timestamp', '$title', '$content', '$fileName', '$filePath', '$fileType')";

            $queryResult = sqlsrv_query($conn, $sql);
            if ($queryResult === false) {
                die(print_r(sqlsrv_errors(), true));
            }
            // echo "File uploaded successfully!";
            header("Location: ../../../portal/admin/");
        } else {
            echo "Unsupported file type or error during upload.";
        }
    } else {
        $sql = "INSERT INTO notice_board (timeStamp, title, content, fileName, filePath, fileType)
                VALUES ('$timestamp', '$title', '$content', NULL, NULL, NULL)";

        $queryResult = sqlsrv_query($conn, $sql);
        if ($queryResult === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        // echo "File uploaded successfully!";
        header("Location: ../../../portal/admin/");
    }
}
?>

<div class="main_notice">

    <section>

        <form action=" <?php echo $_SERVER['PHP_SELF']; ?> " method="post" enctype="multipart/form-data">
            <h2>Publish Global Notice</h2>
            <div>
                <label class="required" for="title">Title</label>
                <input type="text" name="title" required placeholder="Title">
            </div>

            <div>
                <label for="content">Content</label>
                <textarea name="content" rows="3" placeholder="Enter content here"></textarea>
            </div>

            <div>
                <label for="file">Choose File <i>(20 MB max)</i></label>
                <input type="file" name="file" accept=".pdf, .jpg, .png, .webp, .gif, .mp4, .webm, .mov">
            </div>

            <button class="submit" type="submit">Publish Notice</button>
        </form>
    </section>

    <section>

        <div class="notice">
            <h1>NOTICE BOARD</h1>
            <div id="notice_body">
                <?php
                require('../../../conn.php');
                require_once('./notice_board.php');
                ?>
            </div>
        </div>
    </section>
</div>