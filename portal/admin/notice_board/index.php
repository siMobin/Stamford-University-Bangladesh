<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/main';

$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
$host = 'http://' . $_SERVER['HTTP_HOST'];

// sometimes this will not work and you need to configure from php.ini file manually.
// ini_set('upload_max_filesize', '20M'); // Set maximum upload file size to 20 megabytes
// ini_set('post_max_size', '20M');        // Set maximum POST data size to 20 megabytes

require($_SERVER['DOCUMENT_ROOT'] . '/conn.php');
date_default_timezone_set('Asia/Dhaka');

require($_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php");

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = htmlspecialchars($_POST["title"]);
    // Encode content before insertion
    $content = base64_encode($_POST['content']);
    $timestamp = date('Y/m/d - h:i:s A');

    // Process file upload if a file is provided
    if (isset($_FILES['file']) && $_FILES['file']['error'] !== UPLOAD_ERR_NO_FILE) {

        // Process file upload
        $targetPdf = "../../../storage/pdf/";
        $targetImage = "../../../storage/image/";
        $targetVideo = "../../../storage/video/";

        $fileName = $_FILES['file']['name'];
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $timestampString = str_replace(['/', ' ', ':', '-', 'AM', 'PM'], '', $timestamp); // Convert timestamp to a string without spaces, colons, and hyphens

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
            case 'jpeg':
            case 'png':
            case 'webp':
            case 'svg':
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
                header("Location: $host/portal/admin/");
                echo "<script>alert('Unsupported file type or error during upload.')</script>";
                break;
        }

        if (!empty($filePath)) {
            // Move the uploaded file to the specified folder
            move_uploaded_file($_FILES['file']['tmp_name'], $filePath);

            // Retrieve the file extension
            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

            // Check if the file extension corresponds to an image type
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            if (in_array(strtolower($fileExtension), $allowedExtensions)) {
                // Open the uploaded image using Intervention Image
                $manager = new ImageManager(Driver::class);

                // Read file using Intervention Image
                $image = $manager->read($filePath);

                // scale down to fixed width
                $image->scaleDown(width: 500);

                // Convert the image to webp
                $encode = $image->toWebp();

                // Save the image after modifications with the new extension
                $newFilePath = str_replace($fileExtension, 'webp', $filePath);
                $encode->save($newFilePath);

                // Update $filePath to the new file path with the WebP extension if needed
                $filePath = $newFilePath;
            }

            // Insert data into the notice_board table

            $sql = "INSERT INTO notice_board (timeStamp, title, content, fileName, filePath, fileType)
                    VALUES ('$timestamp', '$title', '$content', '$fileName', '$filePath', '$fileType')";

            $queryResult = sqlsrv_query($conn, $sql);
            if ($queryResult === false) {
                die(print_r(sqlsrv_errors(), true));
            }
            // echo "File uploaded successfully!";
            header("Location: $host/portal/admin/");
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
        header("Location: $host/portal/admin/");
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
                <textarea name="content" rows="3" placeholder="Enter content here...&#10;Tips: Content support Markdown"></textarea>
            </div>

            <div class="file">
                <span id="fileUpload">Drop or Click to add file <i>(20 MB max)</i></span>
                <input onchange="readFile(this);" onclick="this.value=null;" type="file" name="file" id="file" accept="image/svg+xml, image/*, video/*, application/pdf">
                <img id="preview" />
            </div>

            <button class="submit" type="submit">Publish Notice</button>
        </form>
    </section>

    <section>

        <div class="notice">
            <h1 class="notice_title">NOTICE BOARD</h1>
            <div id="notice_body">
                <?php
                require_once($_SERVER['DOCUMENT_ROOT'] . '/notice_board.php');
                ?>
            </div>
        </div>
    </section>
</div>