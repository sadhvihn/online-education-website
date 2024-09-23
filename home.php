<?php 
include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id=$_COOKIE['user_id'];
}else{
    $user_id='';
}

$count_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id=?");
$count_likes->execute([$user_id]);
$total_likes = $count_likes->rowCount();

$count_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id=?");
$count_comments->execute([$user_id]);
$total_comments = $count_comments->rowCount();

$count_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id=?");
$count_bookmark->execute([$user_id]);
$total_bookmark = $count_bookmark->rowCount();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
     <!-- font awesome cdn link  -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- custom css link  -->
<link rel="stylesheet" href="/css/style.css">
</head>
<body>
<!-- header section starts  -->
<?php include 'components/user_header.php';?>
<!-- header section ends  -->

<!-- quick section starts  -->
<section class="quick-select">
    <h1 class="heading">quick options</h1>
    <div class="box-container">
        <?php if($user_id != ''){?>
            <div class="box">
                <h3 class="title">likes and comments</h3>
                <p>total likes : <span><?= $total_likes;?></span></p>
                <a href="likes.php" class="inline-btn">view likes</a>
                <p>total comments : <span><?= $total_comments;?></span></p>
                <a href="comments.php" class="inline-btn">view comments</a>
                <p>total bookmark : <span><?= $total_bookmark;?></span></p>
                <a href="bookmark.php" class="inline-btn">view bookmark</a>
            </div>

         <?php }else{?> 
            <div class="box" style="text-align: center;">
                <h3 class="title">login or register</h3>
                <div class="flex-btn">
                    <a href="login.php" class="option-btn">login</a>
                    <a href="register.php" class="option-btn">register</a>
                </div>
            </div>
            
         <?php }?>   
            <div class="box">
                <h3 class="title">top categories</h3>
              <div class="flex">
                    <a href="#"><i class="fas fa-code"></i><span>development</span></a>
                    <a href="#"><i class="fas fa-chart-simple"></i><span>business</span></a>
                    <a href="#"><i class="fas fa-pen"></i><span>design</span></a>
                    <a href="#"><i class="fas fa-chart-line"></i><span>marketing</span></a>
                    <a href="#"><i class="fas fa-music"></i><span>music</span></a>
                    <a href="#"><i class="fas fa-camera"></i><span>photography</span></a>
                    <a href="#"><i class="fas fa-cog"></i><span>software</span></a>
                    <a href="#"><i class="fas fa-vial"></i><span>science</span></a>
              </div>
            </div>

            <div class="box">
                <h3 class="title">popular topics</h3>
               <div class="flex">
                    <a href="#"><i class="fab fa-html5"></i><span>HTML</span></a>
                    <a href="#"><i class="fab fa-css3"></i><span>CSS</span></a>
                    <a href="#"><i class="fab fa-js"></i><span>JavaScript</span></a>
                    <a href="#"><i class="fab fa-react"></i><span>react</span></a>
                    <a href="#"><i class="fab fa-php"></i><span>PHP</span></a>
                    <a href="#"><i class="fab fa-bootstrap"></i><span>bootstrap</span></a>
               </div>
            </div>

        <div class="box tutor" >
            <h3 class="title">become a tutor</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta id ratione consequuntur atque suscipit voluptatem neque dicta animi sit ipsam.</p>
            <a href="admin/register.php" class="inline-btn">get started</a>
        </div>

    </div>
</section>
<!-- quick section ends  -->

<!-- courses section starts  -->
<section class="course">
    <h1 class="heading">latest courses</h1>

    <div class="box-container">
        <?php
            $select_courses = $conn->prepare("SELECT * FROM `playlist` WHERE status=? ORDER BY date DESC LIMIT 6");
            $select_courses->execute(['active']);
            if($select_courses->rowCount()>0){
                while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)){
                    $course_id = $fetch_course['id'];

                    $count_course = $conn->prepare("SELECT * FROM `content` WHERE playlist_id=? AND status=?");
                    $count_course->execute([$course_id,'active']);
                    $total_courses= $count_course->rowCount();
                    
                    $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id=?");
                    $select_tutor->execute([$fetch_course['tutor_id']]);
                    $fetch_tutor= $select_tutor->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="box">
            <div class="tutor">
                <img src="upload_files/<?= $fetch_tutor['image'];?>" alt="">
                <div>
                    <h3><?= $fetch_tutor['name'];?></h3>
                    <span><?= $fetch_course['date'];?></span>
                </div>
            </div>
            <div class="thumb">
                <span><?= $total_courses;?></span>
                <img src="upload_files/<?= $fetch_course['thumb'];?>" alt="">
            </div>
       
            <h3 class="title"><?= $fetch_course['title'];?></h3>
            <a href="playlist.php?get_id=<?= $course_id;?>" class="inline-btn">view course</a>
        </div>
        <?php
           }
        }else{
            echo '<p class="empty">no courses added yet!</p>';
        }
        ?> 
    </div>
    <div style="margin-top: 2rem;text-align:center;">
    <a href="courses.php" class="inline-option-btn">view all</a></div>
</section>
<!-- courses section ends  -->




















<!-- footer section starts  -->
<?php include 'components/footer.php';?>
<!-- footer section ends  -->

<script src="js/script.js"></script>
</body>
</html>