<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/main';

$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') !== false ? 'https://' : 'http://';
$host = 'http://' . $_SERVER['HTTP_HOST'];
$hostPath = $host . "/main";
$node_modulesPath = $host . "/node_modules";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUB</title>
    <link rel="stylesheet" href="./style/index.css">
</head>

<body>
    <div id="sidebar">
        <div class="logo"><img src="./images/logo_medium.png" alt=""></div>
        <div class="menu-item" data-page="home" hx-get="home" hx-target="main">Home</div>
        <div class="menu-item" data-page="Students" hx-get="Students" hx-target="main">Students</div>
        <div class="menu-item" data-page="admissionoffline" hx-get="admissionoffline" hx-target="main">Offline Admission</div>
        <div class="menu-item" data-page="notice_board" hx-get="notice_board" hx-target="main">Notice</div>
        <div class="menu-item" data-page="course_assign" hx-get="course_assign" hx-target="main">Course Assign</div>

        <!-- More menu items... -->

        <div class="menu-drop" onclick="toggleSubmenu(event)">
            Library <i class="fa-solid fa-caret-down"></i>
            <div class="submenu" id="submenu">
                <div class="menu-item submenu-item" data-page="p3" hx-get="p3" hx-target="main">sub page</div>
                <div class="menu-item submenu-item" data-page="p4" hx-get="p4" hx-target="main">sub page</div>
                <a href="./p3/">
                    <div class="menu-item submenu-item">Submenu link</div>
                </a>

                <!-- Add more submenu items as needed -->
            </div>
        </div>
    </div>


    <header>
        <h1>Lorem ipsum dolor sit amet header.</h1>
    </header>

    <!-- Sidebar toggle button -->
    <i id="sidebar-toggle" class="fa-solid fa-chevron-down"></i>

    <main>
        <!-- Page content will be loaded here -->
    </main>

    <!-- scripts  -->
    <script src="<?php echo $node_modulesPath ?>/htmx.org/dist/htmx.min.js"></script>
    <script src="./script/index.js"></script> <!-- NOTE: Require Top -->
    <script src="<?php echo  $node_modulesPath; ?>/jquery/dist/jquery.min.js"></script>
    <!-- Other scripts will be included bellow -->

    <script src="./script/admissionoffline.js"></script>
    <script src="./script/course_assign.js"></script>
    <script src="./script/live_search.js"></script>
    <script src="./script/input_preview.js"></script>

</body>

</html>