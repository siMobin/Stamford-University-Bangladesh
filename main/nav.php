<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/main';

$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
$host = 'http://' . $_SERVER['HTTP_HOST'];
$hostPath = $host . "/main";
$node_modulesPath = $host . "/node_modules";
$current_page = basename($_SERVER['REQUEST_URI']);
?>

<?php // echo  $host . "<br>" . $hostPath; 
?>

<link rel="stylesheet" href="<?php echo $node_modulesPath ?>/aos/dist/aos.css">
<link rel="stylesheet" href="<?php echo $hostPath ?>/style/nav.css">
<script src="<?php echo  $node_modulesPath; ?>/htmx.org/dist/htmx.min.js"></script>

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

            <!-- Dynamic Navigation -->
            <?php
            if ($current_page == "course_search") {
                echo "<a hx-get='allcourse.php' hx-target='#courseList'>see all</a>";
            }
            ?>
        </div>

    </section>

    <section class="main" data-aos="fade-up" data-aos-duration="1000">
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
                <a href="<?php echo  $host; ?>/portal/faculty/">Faculty Portal</a>
                <a href="<?php echo  $host; ?>/portal/staff/">Staff Portal</a>
                <a href="<?php echo  $host; ?>/portal/admin/">Admin Portal</a>
            </div>
        </div>
    </section>
</nav>


<!-- script -->
<script src="<?php echo  $hostPath; ?>/script/search.js"></script>
<script src="<?php echo  $node_modulesPath; ?>/aos/dist/aos.js"></script>
<script src="<?php echo  $host; ?>/aos.js"></script>
<!-- TODO: Buy a powerful PC -->
<script type="module" src="<?php echo  $host; ?>/wave.js"></script>