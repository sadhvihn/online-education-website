<?php 
include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id=$_COOKIE['user_id'];
}else{
    $user_id='';
    header('location:home.php');
}


$count_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id=?");
$count_bookmark ->execute([$user_id]);
$total_bookmarks = $count_bookmark->rowCount();

$count_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id=?");
$count_likes ->execute([$user_id]);
$total_likes = $count_likes->rowCount();

$count_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id=?");
$count_comments ->execute([$user_id]);
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
<link rel="stylesheet" href="/css/style.css">
</head>
<body>
<!-- header section starts  -->
<?php include 'components/user_header.php';?>
<!-- header section ends  -->

<!-- profile section starts  -->
<section class="profile">
    <h1 class="heading">profile details</h1>
    <div class="details">
      <div class="tutor">
      <img src="upload_files/<?=$fetch_profile['image'];?>" alt="">
        <h3><?=$fetch_profile['name'];?></h3>
        <p><?=$fetch_profile['email'];?></p>
        <span>student</span>
        <a href="update.php" class="inline-btn">update profile</a>
    
      </div>
    <div class="box-container">

    <div class="box">
        <h3><?=$total_bookmarks?></h3>
        <p>playlist bookmarked</p>
        <a href="playlist.php" class="btn">view playlists</a>
    </div>

    <div class="box">
        <h3><?=$total_likes?></h3>
        <p>total liked</p>
        <a href="courses.php" class="btn">view likes</a>
    </div>
    <div class="box">
        <h3><?=$total_comments?></h3>
        <p>total commented</p>
        <a href="comments.php" class="btn">view comments</a>
    </div>
    </div>
    </div>
</section>


















<!-- profile section ends  -->

<!-- footer section starts  -->
<?php include 'components/footer.php';?>
<!-- footer section ends  -->

<script src="js/script.js"></script>
</body>
</html>