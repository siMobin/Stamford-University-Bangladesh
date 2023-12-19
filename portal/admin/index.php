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
        <div class="menu-item active" data-page="home">Page 1</div>
        <div class="menu-item" data-page="admissionoffline">Offline Admission</div>
        <div class="menu-item" data-page="notice_board">Notice</div>
        <div class="menu-item" data-page="course_assign">Course Assign</div>

        <!-- More menu items... -->

        <div class="menu-drop" onclick="toggleSubmenu(event)">
            Library <i class="fa-solid fa-caret-down"></i>
            <div class="submenu" id="submenu">
                <div class="menu-item submenu-item" data-page="./p3/">Submenu 1</div>
                <div class="menu-item submenu-item" data-page="./p3/">Submenu 2</div>
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

    <main>
        <!-- Page content will be loaded here -->
    </main>


    <script src="./script/index.js"></script>
    <script src="./script/admissionoffline.js"></script>
    <script src="./script/course_assign.js"></script>

</body>

</html>