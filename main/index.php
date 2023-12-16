<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./images/logo.png">
    <title>Stamford University Bangladesh</title>
    <link rel="stylesheet" href="./style/index.css">
</head>

<body>

    <?php
    require './nav.php';
    include './header_slider.php';
    ?>


    <div class="admission">
        <img src="https://img.freepik.com/free-photo/i-m-prepared-exam-very-well_329181-2973.jpg?w=996&t=st=1701532633~exp=1701533233~hmac=8921bb0fb13d819e6665bc723b58a7e18348b20d55a92707c47b3982e21de1e3" alt="" loading="lazy">

        <div class="text">
            <h1>Admission Open Spring 2024</h1>
            <p>The options to choose from when it comes to higher education in Bangladesh may seem many but few are on par in quality and history with Stamford.</p>

            <div>
                <h2>Admission Timeline ( 28 Oct, 2023 - 5 Dec, 2023 )</h2>
                <p><i class="fa-solid fa-phone-volume"></i> 01700000000</p>
                <a href="mailto:aaaa@gmail.com"><i class="fa-solid fa-envelope"></i>aaaa@gmail.com</a>
            </div>
        </div>
    </div>

    <section id="info" class="info">

        <div class="notice_wrapper">
            <div class="notice">
                <h1>NOTICE BOARD</h1>
                <div id="notice_body">
                    <?php
                    require('../conn.php');
                    require_once('./notice_board/notice_board.php');
                    ?>
                </div>
            </div>
        </div>

        <div class="facebook">

            <div id="fb-root"></div>
            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v18.0" nonce="yjeyGAHv"></script>

            <div class="fb-page" data-href="https://www.facebook.com/stamfordedubd" data-tabs="timeline" data-width="600" data-height="800" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                <blockquote cite="https://www.facebook.com/stamfordedubd" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/stamfordedubd">Stamford University Bangladesh</a></blockquote>
            </div>
        </div>

        <div class="details">
            <h1>Lorem ipsum dolor sit amet.</h1>
            <span>Lorem ipsum dolor sit. Lorem, ipsum. Lorem, ipsum dolor.</span><br><br>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Est adipisci commodi illum quod non labore dicta aliquid amet quos saepe. Deleniti repellendus rerum voluptatum quod sit dicta qui facilis, obcaecati maxime! Tenetur saepe perspiciatis aliquam repudiandae perferendis voluptate enim quod facere vitae? Delectus nesciunt amet doloremque corrupti officiis totam, perferendis ut molestiae eum non iure pariatur quasi at possimus, architecto suscipit, explicabo modi corporis? Dolorem, minicumque nostrum? Modi molestiae eius, sapiente voluptates quos quibusdam reiciendis. Aspernatur, accusamus porro voluptates animi ab quia architecto deleniti eos, in officiis ex? Molestiae maiores est, alias perferendis magnam accusamus velit provident consequuntur, tempore totam consequatur qui tenetur ratione et praesentium nostrum laudantium aut eaque quod iusto quasi.</p><br><br>
            <iframe src="https://www.youtube.com/embed/D5wY4go2m3E?si=f7KZG9T2Utc-k8tj" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
    </section>

    <h1 class="degree_title">Degrees and Departments</h1>

    <p class="degree_details">Providing more than <?php //echo $count; 
                                                    // TODO: import this from database
                                                    ?> Degrees in Bachelors and Masters programs in the fields of Engineering, Business, Law, Sciences, Social Sciences and many more.</p>

    <div class="card_container">
        <div class="card">
            <img src="https://img.freepik.com/free-photo/active-conversation-group-young-people-casual-clothes-working-modern-office_146671-16458.jpg?w=996&t=st=1701530668~exp=1701531268~hmac=3d76ca00fc2fd64eb39cd72e9fbe983808c805ba5c05f6ba1fd1396652ad873b" loading="lazy">
            <div class="card-content">
                <h1 class="card-title">Bachelor of Science in Computer Science & Engineering</h1>
                <h2 class="card-subtitle">Department of Computer Science & Engineering</h2>
                <p class="card-text">Seamlessly visualize quality capital without superior collaboration and idea locality.</p>
                <a href="#" class="card-btn">Read More</a>
            </div>
        </div>

        <div class="card">
            <img src="https://img.freepik.com/free-photo/cheerful-vietnamese-chemist_1098-21169.jpg?w=996&t=st=1701530466~exp=1701531066~hmac=9b2a39200c585ca657ab5a43e39ea858f6f4ee37b5958888a8056cdcacdb0328" loading="lazy">
            <div class="card-content">
                <h1 class="card-title">B.Sc. (Hons.) in Microbiology</h1>
                <h2 class="card-subtitle">Department of Microbiology</h2>
                <p class="card-text">Seamlessly visualize quality capital without superior collaboration and idea locality.</p>
                <a href="#" class="card-btn">Read More</a>
            </div>
        </div>

        <div class="card">
            <img src="https://images.unsplash.com/photo-1596496357130-e24a50408378?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NjZ8fGNvbXB1dGVyJTIwc2NpZW5jZSUyMHN0dWRlbnR8ZW58MHwwfDB8fHww" loading="lazy">
            <div class="card-content">
                <h1 class="card-title">Bachelor of Science in Computer Science & Engineering</h1>
                <h2 class="card-subtitle">Department of Computer Science & Engineering</h2>
                <p class="card-text">Seamlessly visualize quality capital without superior collaboration and idea locality.</p>
                <a href="#" class="card-btn">Read More</a>
            </div>
        </div>

        <div class="card">
            <img src="https://images.unsplash.com/photo-1596496357130-e24a50408378?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NjZ8fGNvbXB1dGVyJTIwc2NpZW5jZSUyMHN0dWRlbnR8ZW58MHwwfDB8fHww" loading="lazy">
            <div class="card-content">
                <h1 class="card-title">Bachelor of Science in Computer Science & Engineering</h1>
                <h2 class="card-subtitle">Department of Computer Science & Engineering</h2>
                <p class="card-text">Seamlessly visualize quality capital without superior collaboration and idea locality.</p>
                <a href="#" class="card-btn">Read More</a>
            </div>
        </div>

    </div>




    <div class="banner">
        <div class="text-section">
            <h1>Our Best Features</h1>
            <div class="feature skill">
                <h2>Skilled wedding planners</h2>
                <p>Our skilled wedding planners are experienced and dedicated to making your special day perfect. With our team, you can relax and enjoy your day while we handle the details.</p>
            </div>
            <div class="feature Packages">
                <h2>Affordable Packages</h2>
                <p>We offer a variety of packages to suit every budget. Our packages are designed to provide you with everything you need for your wedding day at an affordable price.</p>
            </div>
            <div class="feature Efficient">
                <h2>Efficient & Flexible</h2>
                <p>We understand that every wedding is unique. That's why we offer flexible options to customize your wedding package. We're here to make your wedding day as special and unique as you are.</p>
            </div>
        </div>



        <img src="https://img.freepik.com/free-photo/front-view-male-student-green-checkered-shirt-wearing-black-backpack-holding-files-smiling-blue-wall_140725-42410.jpg?w=996&t=st=1701532264~exp=1701532864~hmac=6c63c5336dcb4b839fd78148d683030ba2a1cccb351e91b24c940ed629e5455f" loading="lazy">

    </div>







    <?php require_once './footer.php'; ?>

    <script type="module" src="../cursor.js"></script>

</body>

</html>