<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/main';

$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') !== false ? 'https://' : 'http://';
$host = 'http://' . $_SERVER['HTTP_HOST'];
$hostPath = $host . "/main";
?>

<?php // echo  $host . "<br>" . $hostPath; 
?>
<link rel="stylesheet" href="<?php echo $hostPath ?>/style/footer.css">
<footer>
    <div class="container">
        <div class="about">
            <img class="logo" src="<?php echo $hostPath; ?>/images/logo_big.png" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt aperiam quia ipsum eaque molestias facilis! Veniam molestias porro illo illum soluta itaque, laudantium maxime velit assumenda labore autem neque inventore.</p>
        </div>

        <div>
            <h3>Contact</h3>
            <ul>
                <li>51 Siddeswari Road (Ramna), Dhaka-1217.</li>
                <li>41032671, 41032672, 41032673, 41032674</li>
                <li>41032675, 41032676, 41032678, 41032679</li>
                <li>41032680, 41032681</li>
                <li><a href="mailto:admission@stamford.university">admission@stamford.university</a></li>
                <li><a href="mailto:admission@stamford.university">admission@stamford.university</a></li>
            </ul>
        </div>

        <div>
            <h3>Quick Links</h3>
            <ul>
                <li><a href="">Link 1</a></li>
                <li><a href="">Academic Calendar</a></li>
                <li><a href="">Link 3</a></li>
                <li><a href="">Link 4</a></li>
            </ul>
        </div>

        <div>
            <h3>Useful Links</h3>
            <ul>
                <li><a href="">University Grants Commission</a></li>
                <li><a href="">Link 2</a></li>
                <li><a href="">Direction Against Sexual Harassment</a></li>
                <li><a href="">Link 4</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <iframe frameborder="0" style="border:0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14545.447616804183!2d90.40396326487762!3d23.75014548729103!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c6ec4b98fc4f%3A0x4056cdd3b6c0c00f!2sYour%20Location!5e0!3m2!1sen!2sbd!4v1637014915386!5m2!1sen!2sbd&z=1" allowfullscreen>
        </iframe>

        <div class="campus">
            <img src="https://www.stamforduniversity.edu.bd/asset/images/permanent_campus/permanent_campus_fullview.jpeg" alt="">
            <h4>Proposed permanent Campus</h4>
        </div>

        <div class="campus">
            <img src="https://www.stamforduniversity.edu.bd/asset/images/siddeswari_campus/siddeswari_campus.jpg" alt="">
            <h4>Siddeswari Campus</h4>
        </div>

        <div class="social">
            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
            <a href="#"><i class="fa-brands fa-twitter"></i></a>
            <a href="#"> <i class="fa-brands fa-youtube"></i></a>
        </div>
    </div>

    <p class="copyright">&copy; Copyright <?php echo date('Y'); ?>. All Rights Reserved.</p>
</footer>