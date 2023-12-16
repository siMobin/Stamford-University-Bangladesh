<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form>
        <input type="text" size="30" onkeyup="showResult(this.value)" placeholder="Search...">
    </form>

    <div id="tableContent">
        <?php
        require '../conn.php';

        $sql = "SELECT TOP 100 * FROM library_shelf";
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
              <th>Shelf Number</th>
              <th>Department</th>
          </tr>";

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
        echo "</table>";

        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
        ?>
    </div>

    <script src="./script/live_search.js"></script>
</body>

</html>