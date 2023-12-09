<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../images/logo.png">
    <title>Career</title>
    <link rel="stylesheet" href="../style/career.css">
</head>

<body>
    <header>
        <?php
        require '../nav.php';
        // include './header_slider.php';
        ?>
    </header>

    <div class="table_container">
        <table>
            <tr>
                <th>TITLE</th>
                <th>DOWNLOAD</th>
            </tr>

            <tr>
                <td>Admin CV Format</td>
                <td><a href="../../../storage/file/AdminCVNew.doc" download><i class="fa-solid fa-download"></i></a></td>
            </tr>

            <tr>
                <td>Full Time Faculty CV Format</td>
                <td><a href="../../../storage/file/FacultyCVNew.doc" download><i class="fa-solid fa-download"></i></a></td>
            </tr>

            <tr>
                <td>Part Time Faculty CV Format</td>
                <td><a href="../../../storage/file/ParTimeFacultyCVNew.doc" download><i class="fa-solid fa-download"></i></a></td>
            </tr>
        </table>
    </div>

    <div class="image_wrapper">
        <img src="https://stamforduniversity.edu.bd/asset/circular/cse_ad_23nov.jpg" alt="">
    </div>
    <?php
    require '../footer.php';
    ?>
</body>

</html>