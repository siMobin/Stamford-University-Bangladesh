<script type="module" crossorigin src="./header_slider/assets/index.js"></script>
<link rel="modulepreload" href="./header_slider/assets/vendor.js">
<link rel="stylesheet" href="./header_slider/assets/index.css">

<!-- Shaders slider -->
<div class="swiper">
    <div class="swiper-wrapper">
        <?php
        $imageExtensions = ['jpg', 'png', 'webp'];
        $imageFolder = './header_slider/images/';

        $images = array_filter(scandir($imageFolder), function ($file) use ($imageExtensions) {
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            return in_array($extension, $imageExtensions);
        });

        foreach ($images as $image) {
        ?>
            <a class="swiper-slide" href="#" data-cursor-text="LINK">
                <!-- <div > -->
                <img class="swiper-gl-image" src="<?= $imageFolder . $image ?>" alt="" loading="lazy">
                <!-- </div> -->
            </a>
        <?php
        }
        ?>
    </div>

    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>