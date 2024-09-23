<?php
include '../components/connect.php';
if(isset($_COOKIE['tutor_id'])){
  $tutor_id=$_COOKIE['tutor_id'];
}
 else{
  $tutor_id='';
  header('location:login.php');
 }
$count_content = $conn->prepare("SELECT * FROM `content` WHERE tutor_id=?");
$count_content ->execute([$tutor_id]);
$total_contents = $count_content->rowCount();

$count_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id=?");
$count_playlist ->execute([$tutor_id]);
$total_playlists = $count_playlist->rowCount();

$count_likes = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id=?");
$count_likes ->execute([$tutor_id]);
$total_likes = $count_likes->rowCount();

$count_comments = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id=?");
$count_comments ->execute([$tutor_id]);
$total_comments = $count_comments->rowCount();


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom css link  -->
    <link rel="stylesheet" href="/css/admin_style.css">
</head>
<body>
   <!-- header section link   -->
   <?php  include'../components/admin_header.php'?>

<!-- profile section starts  -->
<section class="profile">
    <h1 class="heading">profile details</h1>
    <div class="details">
      <div class="tutor">
      <img src="../upload_files/<?=$fetch_profile['image'];?>" alt="">
        <h3><?=$fetch_profile['name'];?></h3>
        <span><?= $fetch_profile['profession'];?></span>
        <a href="update.php" class="inline-btn">update profile</a>
    
      </div>
    <div class="box-container">
    <div class="box">
        <h3><?=$total_contents?></h3>
        <p>total contents</p>
        <a href="contents.php" class="btn">view contents</a>
    </div>
    <div class="box">
        <h3><?=$total_playlists?></h3>
        <p>total playlists</p>
        <a href="playlists.php" class="btn">view playlists</a>
    </div>

    <div class="box">
        <h3><?=$total_likes?></h3>
        <p>total likes</p>
        <a href="contents.php" class="btn">view likes</a>
    </div>
    <div class="box">
        <h3><?=$total_comments?></h3>
        <p>total comments</p>
        <a href="comments.php" class="btn">view comments</a>
    </div>
    </div>
    </div>
</section>
<!-- profile section ends  -->

  <!-- footer section link   -->
  <?php  include'../components/footer.php'?>
<!-- custom js link  -->
<script src="/js/admin_script.js"></script>
</body>
</html>