<link rel="stylesheet" href="./style/nav.css">

<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/main';

$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
$host = 'http://' . $_SERVER['HTTP_HOST'];
$hostPath = $host . "/main";
?>

<?php // echo  $host . "<br>" . $hostPath; 
?>

<nav>
    <section class="top">
        <img class="logo" src="<?php echo  $hostPath; ?>/images/logo.png" alt="">

        <div class="top_nav">
            <div>
                <div class="search_box">
                    <i class="fa-brands fa-searchengin"></i>
                    <input type="text" id="searchInput" placeholder="Search...">
                    <i class="fa-solid fa-arrows-spin"></i>
                </div>
                <div id="suggestions"></div>
            </div>
            <a href="<?php echo  $hostPath; ?>/course_search/">Search Courses</a>
            <a href="<?php echo  $host; ?>/library">Library</a>
            <a href="<?php echo  $hostPath; ?>/career/">Career</a>
            <a href="#">avbryry</a>
        </div>

    </section>

    <section class="main">
        <div class="dropdown">
            <a href="#">About Us</a>
            <div class="dropdown-content">
                <a href="<?php echo  $hostPath; ?>/mvg/">Mission, Vision and Goals</a>
                <a href="<?php echo  $hostPath; ?>/genralinformation/">General Information</a>
                <a href="<?php echo  $hostPath; ?>/contact/">Contact</a>
            </div>
        </div>
        <a href="#">avbryry</a>
        <a href="#">avbryry</a>
        <div class="dropdown">
            <a href="#">Dropdown</a>
            <div class="dropdown-content">
                <a href="#">Dropdown Item A</a>
                <a href="#">Dropdown Item B</a>
                <a href="#">Dropdown Item C</a>
            </div>
        </div>
        <div class="dropdown">
            <a href="#">Dropdown2</a>
            <div class="dropdown-content">
                <a href="#">Dropdown Item A</a>
                <a href="#">Dropdown Item B</a>
                <a href="#">Dropdown Item C</a>
            </div>
        </div>
        <a href="#">avbryry</a>
        <div class="dropdown">
            <a href="#">Portal</a>
            <div class="dropdown-content">
                <a href="<?php echo  $host; ?>/portal/students/">Student Portal</a>
                <a href="#">Faculty Portal</a>
                <a href="#">Staff Portal</a>
                <a href="<?php echo  $host; ?>/portal/admin/">Admin Portal</a>
            </div>
        </div>
    </section>
</nav>

<script src="<?php echo  $hostPath; ?>/script/search.js"></script>