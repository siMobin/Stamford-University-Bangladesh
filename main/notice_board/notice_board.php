<?php
// require('../../conn.php');

// Fetch all records from the notice_board table
$sql = "SELECT * FROM notice_board ORDER BY timestamp desc";
$result = sqlsrv_query($conn, $sql);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

?>
<section class="notice_board">
    <?php while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) : ?>
        <div class="main">
            <h3 class="title"><?php echo $row['title']; ?></h3>
            <p class="timestamp"><?php echo $row['timeStamp']; ?></p>
            <p><?php echo $row['content']; ?></p>

            <?php
            $filePath = $row['filePath'];
            $fileType = $row['fileType'];

            // Display the file based on the file type
            if (in_array($fileType, ['jpg', 'png', 'webp', 'gif'])) {
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