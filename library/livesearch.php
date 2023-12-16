<?php
require '../conn.php';

$search = isset($_GET['data']) ? $_GET['data'] : ''; // Check if search parameter is set

if (empty($search)) {
    // If search box is empty, display the full table
    $sql = "SELECT TOP 100 * FROM library_shelf";
} else {
    // If search box has input, perform the search
    $sql = "SELECT TOP 100 * FROM library_shelf WHERE Title LIKE '%$search%' OR Author LIKE '%$search%' OR Publisher LIKE '%$search%' OR department LIKE '%$search%'";
}

$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

echo "<table border='1'>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Publish Year</th>
            <th>Publisher</th>
            <th>shelf Number</th>
            <th>Department</th>
        </tr>";

if (sqlsrv_has_rows($stmt)) {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['Title'] . "</td>";
        echo "<td>" . $row['Author'] . "</td>";
        echo "<td>" . $row['publishYear'] . "</td>";
        echo "<td>" . $row['Publisher'] . "</td>";
        echo "<td>" . $row['shelfNumber'] . "</td>";
        echo "<td>" . $row['department'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No results found.</td></tr>";
}

echo "</table>";

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
