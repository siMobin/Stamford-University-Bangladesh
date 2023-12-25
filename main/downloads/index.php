<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../images/logo.png">
    <link rel="stylesheet" href="../style/downloads.css">
    <title>SUB-Downloads</title>
</head>

<body>

    <header>
        <?php
        require '../nav.php';
        // include './header_slider.php';
        ?>
    </header>

    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/main/downloads/body.php';
    ?>

    <?php
    require '../footer.php';
    ?>

    <?php
    $path = $_SERVER['DOCUMENT_ROOT'] . '/main';

    $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
    $host = 'http://' . $_SERVER['HTTP_HOST'];
    $hostPath = $host . "/main";
    ?>

    <script src="<?php echo $hostPath ?>/script/downloads.js"></script>
</body>

</html>