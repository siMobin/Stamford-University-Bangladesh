<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Information</title>
    <link rel="stylesheet" href="../style/contact.css">
</head>

<body>
    <header>
        <?php
        require '../nav.php';
        // include './header_slider.php';
        ?>
    </header>
    <section class="main-content">

        <div class="left-section card-box">
            <h2 class="section-title">Siddeswari Campus</h2>
            <address>
                51 Siddeswari Road (Ramna), Dhaka-1217.<br>
                Phone: 09613622622, +88-02-41032671-81<br>
                Mobile: 01321143632, 01321143633, 01321143634, 01321143635<br>
                Email: admission@stamford.university, controller@stamforduniversity.edu.bd,
                registrar@stamforduniversity.edu.bd, prd@stamforduniversity.edu.bd<br>
                Website: <a href="http://www.stamforduniversity.edu.bd" target="_blank">www.stamforduniversity.edu.bd</a>
            </address>
        </div>

        <div class="right-section card-box">
            <h2 class="section-title">Regional Information Office</h2>
            <address>
                6 No. Shayamacharan Roy Road Natun Bazar, Janata Bank (3rd Floor) Mymensingh
            </address>
        </div>

    </section>

    <!-- Second part of the webpage with Google Maps -->
    <section class="maps-section">
        <!-- Additional Card Box 1 (Google Map for Siddeswari Campus) -->

        <!-- Google Maps Embed for Siddeswari Campus -->
        <iframe frameborder="0" style="border:0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14545.447616804183!2d90.40396326487762!3d23.75014548729103!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c6ec4b98fc4f%3A0x4056cdd3b6c0c00f!2sYour%20Location!5e0!3m2!1sen!2sbd!4v1637014915386!5m2!1sen!2sbd&z=1" allowfullscreen>
        </iframe>

        <!-- Additional Card Box 2 (Google Map for Regional Information Office) -->

        <!-- Google Maps Embed for Regional Information Office -->
        <iframe frameborder="0" style="border:0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14545.447616804183!2d90.40396326487762!3d23.75014548729103!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c6ec4b98fc4f%3A0x4056cdd3b6c0c00f!2sYour%20Location!5e0!3m2!1sen!2sbd!4v1637014915386!5m2!1sen!2sbd&z=1" allowfullscreen>
        </iframe>
    </section>

    <?php
    require '../footer.php';
    ?>
</body>

</html>