<?php
require_once('../../../tempconn.php');

// Fetch all records from the notice_board table
$sql = "SELECT * FROM notice_board ORDER BY timestamp desc";
$result = sqlsrv_query($conn, $sql);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File List</title>
</head>
<body>
    <h2>File List</h2>
    <?php while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) : ?>
        <div>
            <h3><?php echo $row['title']; ?></h3>
            <p><?php echo $row['content']; ?></p>
            <p>Timestamp: <?php echo $row['timeStamp'];?></p>
            <?php
                $filePath = $row['filePath'];
                $fileType = $row['fileType'];

                // Display the file based on the file type
                if (in_array($fileType, ['jpg', 'png', 'webp', 'gif'])) {
                    echo '<img src="' . $filePath . '" alt="Image">';
                } elseif (in_array($fileType, ['mp4', 'webm', 'mov'])) {
                    echo '<video controls><source src="' . $filePath . '" type="video/' . $fileType . '"></video>';
                } elseif ($fileType === 'pdf') {
                    // Generate PDF download link
                    echo '<a href="' . $filePath . '" download="' . $row['fileName'] . '">Download PDF</a>';
                } else {
                    echo 'File type not supported for direct display.';
                }
            ?>
            <p>Filename: <?php echo $row['fileName']; ?></p>
        </div>
    <?php endwhile; ?>
</body>
</html>

<?php
// Close the SQL Server connection and free up resources
sqlsrv_close($conn);
?>
