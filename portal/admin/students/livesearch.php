<?php
require($_SERVER['DOCUMENT_ROOT'] . '/conn.php');

$search = isset($_GET['data']) ? $_GET['data'] : ''; // Check if search parameter is set


// If search box has input, perform the search
$sql = "SELECT TOP 2 * FROM students WHERE StudentId LIKE '%$search%' OR Email LIKE '%$search%'";


$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

if (sqlsrv_has_rows($stmt)) {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo "<div class='search_result'>";
        echo "<div> <strong>" . "ID" . "</strong><p>" . $row['StudentId'] . "</p> </div>";
        echo "<div> <strong>" . "NAME" . "</strong><p>" . $row['FirstName'] . "&nbsp;" . $row['LastName'] . "</p> </div>";
        echo "<div> <strong>" . "E-mail" . "</strong><p>" . $row['Email'] . "</p> </div>";
        echo "<div> <strong>" . "Batch" . "</strong><p>" . $row['Batch'] . "</p> </div>";
        echo "<div> <strong>" . "Department" . "</strong><p>" . $row['Department'] . "</p> </div>";
        echo "<div> <strong>" . "Program" . "</strong><p>" . $row['Program'] . "</p> </div>";
        echo "<div> <strong>" . "Gender" . "</strong><p>" . $row['Gender'] . "</p> </div>";
        echo "</div>";
    }
} else {
    echo "<p>No results found.</p>";
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
