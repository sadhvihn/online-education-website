<?php 
include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id=$_COOKIE['user_id'];
}else{
    $user_id='';
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
     <!-- font awesome cdn link  -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- custom css link  -->
<link rel="stylesheet" href="/css/style.css">
</head>
<body>
<!-- header section starts  -->
<?php include 'components/user_header.php';?>
<!-- header section ends  -->

<!-- about section starts  -->

<section class="about">
    <div class="row">
        <div class="image">
            <img src="images/about-img.svg" alt="">
        </div>
        <div class="content">
            <h3>why choose us?</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam sint ipsa pariatur corporis quasi. Exercitationem aliquid blanditiis voluptatum excepturi, similique, voluptas esse sequi molestiae impedit dolorem ducimus necessitatibus, quisquam nulla.</p>
            <a href="courses.php" class="inline-btn">our courses</a>
        </div>
    </div>
    <div class="box-container">
        <div class="box">
            <i class="fas fa-graduation-cap"></i>
            <div>
                <h3>+1k</h3>
                <span>online courses</span>
            </div>
        </div>
        <div class="box">
            <i class="fas fa-user-graduate"></i>
            <div>
                <h3>+1k</h3>
                <span>brilliant students</span>
            </div>
        </div>
        <div class="box">
            <i class="fas fa-chalkboard-user"></i>
            <div>
                <h3>+5k</h3>
                <span>expert teachers</span>
            </div>
        </div>
        <div class="box">
            <i class="fas fa-briefcase"></i>
            <div>
                <h3>100%</h3>
                <span>job placement</span>
            </div>
        </div>
    </div>
</section>
<!-- about section ends  -->

<!-- review section starts  -->

<section class="reviews">
    <h1 class="heading">student's reviews</h1>
    <div class="box-container">
        <div class="box">
            <div class="user">
                <img src="images/pic-2.jpg" alt="">
                <div>
                    <h3>Sanjana Dutt</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Similique, qui quaerat reiciendis soluta assumenda iure beatae culpa impedit recusandae aut.</p>
        </div>
        <div class="box">
            <div class="user">
                <img src="images/pic-3.jpg" alt="">
                <div>
                    <h3>Raghav Jain</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Similique, qui quaerat reiciendis soluta assumenda iure beatae culpa impedit recusandae aut.</p>
        </div>
        <div class="box">
            <div class="user">
                <img src="images/pic-4.jpg" alt="">
                <div>
                    <h3>Sahil Suresh</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Similique, qui quaerat reiciendis soluta assumenda iure beatae culpa impedit recusandae aut.</p>
        </div>
        <div class="box">
            <div class="user">
                <img src="images/pic-7.jpg" alt="">
                <div>
                    <h3>Amaira Singh</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Similique, qui quaerat reiciendis soluta assumenda iure beatae culpa impedit recusandae aut.</p>
        </div>
        <div class="box">
            <div class="user">
                <img src="images/img2.jpg" alt="">
                <div>
                    <h3>Viashnavi Bhatt</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Similique, qui quaerat reiciendis soluta assumenda iure beatae culpa impedit recusandae aut.</p>
        </div>
        <div class="box">
            <div class="user">
                <img src="images/pic-6.jpg" alt="">
                <div>
                    <h3>Shankar Simha</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Similique, qui quaerat reiciendis soluta assumenda iure beatae culpa impedit recusandae aut.</p>
        </div>
    </div>
</section>










<!-- review section ends  -->


















<!-- footer section starts  -->
<?php include 'components/footer.php';?>
<!-- footer section ends  -->

<script src="js/script.js"></script>
</body>
</html>