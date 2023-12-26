<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/main';

$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
$host = 'http://' . $_SERVER['HTTP_HOST'];
?>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/conn.php');
require($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
error_reporting(E_ALL & ~E_DEPRECATED); // Check

// Create an instance of Parsedown
$parsedown = new ParsedownExtra();

// Fetch all records from the notice_board table
$sql = "SELECT TOP 20 * FROM notice_board ORDER BY timestamp desc";
$result = sqlsrv_query($conn, $sql);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

?>

<link rel="stylesheet" href="<?php echo $host ?>/portal/notice.css">
<section class="notice_board">
    <?php while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) : ?>
        <div class="main">
            <h3 class="title"><?php echo $row['title']; ?></h3>
            <p class="timestamp"><?php echo $row['timeStamp']; ?></p>
            <p>
                <?php
                // $decodedContent = base64_decode($row['content']);
                // Parse Markdown content
                $parsedContent = $parsedown->text(base64_decode($row['content']));
                echo $parsedContent;
                ?></p>

            <?php
            $filePath = $row['filePath'];
            $fileType = $row['fileType'];

            // Display the file based on the file type
            if (in_array($fileType, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'])) {
                echo '<img src="' . $filePath . '" alt="Image">';
                echo '<p class="filename">Filename: ' . $row['fileName'] . '</p>';
            } elseif (in_array($fileType, ['mp4', 'webm', 'mov'])) {
                echo '<video controls poster="./images/thumbnail.svg" preload="none"><source src="' . $filePath . '" type="video/' . $fileType . '"></video>';
                echo '<p class="filename">Filename: ' . $row['fileName'] . '</p>';
            } elseif ($fileType === 'pdf') {
                // Generate PDF download link
                echo "<div class='pdf_file'>";
                echo '<i class="fa-solid fa-file-pdf"></i>';
                echo '<a href="' . $filePath . '" download="' . '">Download PDF</a>';
                echo "</div>";
                echo '<p class="filename">Filename: ' . $row['fileName'] . '</p>';
            } else {
                echo '<p class="null">No Attachment.</p>';
            }
            ?>
        </div>
        <br>

    <?php
    endwhile;
    // Close the SQL Server connection and free up resources
    sqlsrv_close($conn);
    ?>

    <p class="end">END</p>
</section>