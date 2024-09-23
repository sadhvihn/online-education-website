<?php 
include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id=$_COOKIE['user_id'];
}else{
    $user_id='';
    header('location:home.php');
}

if(isset($_POST['delete'])){
    $delete_id=$_POST['delete_id'];
    $delete_id=filter_var($delete_id,FILTER_SANITIZE_STRING);

    $verify_like=$conn->prepare("SELECT * FROM `likes` WHERE content_id=?");
    $verify_like->execute([$delete_id]);

    if($verify_like->rowCount()>0){
        $remove_likes=$conn->prepare("DELETE FROM `likes` WHERE content_id=?");
        $remove_likes->execute([$delete_id]);
        $message[]='removed from likes!';
    }else{
        $message[]='already removed from likes!';
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Likes</title>
     <!-- font awesome cdn link  -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- custom css link  -->
<link rel="stylesheet" href="/css/style.css">
</head>
<body>
<!-- header section starts  -->
<?php include 'components/user_header.php';?>
<!-- header section ends  -->
<!-- courses section starts  -->
<section class="course">
    <h1 class="heading">liked videos</h1>

    <div class="box-container">
        <?php
            $select_likes= $conn->prepare("SELECT * FROM `likes` WHERE user_id=?");
            $select_likes->execute([$user_id]);
            if($select_likes->rowCount()>0){
                while($fetch_likes = $select_likes->fetch(PDO::FETCH_ASSOC)){
                    $select_courses = $conn->prepare("SELECT * FROM `content` WHERE id=? AND status=? ORDER BY date DESC");
                    $select_courses->execute([$fetch_likes['content_id'],'active']);
                    if($select_courses->rowCount()>0){
                        while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)){
                        $course_id = $fetch_course['id'];

                        
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
                <img src="upload_files/<?= $fetch_course['thumb'];?>" alt="">
            </div>
       
            <h3 class="title"><?= $fetch_course['title'];?></h3>
            <form action="" method="post" class="flex-btn">
                <input type="hidden" name="delete_id" value="<?= $fetch_likes['content_id'];?>">
                <a href="watch_video.php?get_id=<?= $course_id;?>" class="inline-btn">view video</a>
                <input type="submit" value="remove" class="inline-delete-btn" name="delete">

            </form>
        </div>
        <?php
           }
        }else{
            echo '<p class="empty">no courses added yet!</p>';
        }
                        
    }
}else{
        echo '<p class="empty">nothing added to likes yet!</p>';
    }
        ?> 
    </div>
    
</section>
<!-- courses section ends  -->





















<!-- footer section starts  -->
<?php include 'components/footer.php';?>
<!-- footer section ends  -->

<script src="js/script.js"></script>
</body>
</html>