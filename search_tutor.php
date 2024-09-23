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
    <title>Search Tutor</title>
     <!-- font awesome cdn link  -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- custom css link  -->
<link rel="stylesheet" href="/css/style.css">
</head>
<body>
<!-- header section starts  -->
<?php include 'components/user_header.php';?>
<!-- header section ends  -->

<!-- search tutor section  starts  -->
<section class="teachers">
    <h1 class="heading">expert tutors</h1>

    <form action="search_tutor.php" method="post" class="tutor-search">
        <input type="text" name="search_tutor_box" placeholder="search tutors" maxlength="100" required >
        <button type="submit" name="search_tutor_btn" class="fas fa-search"></button>
    </form>
    <div class="box-container">


        <?php 

            if(isset($_POST['search_tutor_box']) or isset($_POST['search_tutor_btn']) ){

                $search_tutor=$_POST['search_tutor_box'];
                 $select_tutors=$conn->prepare("SELECT * FROM `tutors` WHERE name LIKE '%{$search_tutor}%' ");
                $select_tutors->execute();
                if($select_tutors->rowCount()>0){
                    while($fetch_tutor=$select_tutors->fetch(PDO::FETCH_ASSOC)){
                        $tutor_id=$fetch_tutor['id'];


                        $count_likes = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id=?");
                        $count_likes->execute([$tutor_id]);
                        $total_likes = $count_likes->rowCount();

                        $count_comments = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id=?");
                        $count_comments->execute([$tutor_id]);
                        $total_comments = $count_comments->rowCount();

                        $count_content = $conn->prepare("SELECT * FROM `content` WHERE tutor_id=?");
                        $count_content->execute([$tutor_id]);
                        $total_content = $count_content->rowCount();

                        $count_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id=?");
                        $count_playlist->execute([$tutor_id]);
                        $total_playlist = $count_playlist->rowCount();



        ?>
        <div class="box">
            <div class="tutor">
                <img src="upload_files/<?= $fetch_tutor['image'];?>" alt="">
                    <div>
                    <h3><?= $fetch_tutor['name'];?></h3>
                    <span><?= $fetch_tutor['profession'];?></span>
                </div>
            </div>
            <p>total videos: <span><?= $total_content;?></span></p>
            <p>total courses: <span><?= $total_playlist;?></span></p>
            <p>total likes: <span><?= $total_likes;?></span></p>
            <p>total comments: <span><?= $total_comments;?></span></p>
            <a href="tutor_profile.php?get_id=<?= $fetch_tutor['email'];?>" class="inline-btn">view profile</a>
        </div>
        <?php
                 }
                }else{
                    echo '<p class="empty">result not found!</p>';
                }   
            }else{
            echo '<p class="empty">👆 search something! 👆</p>';
        }
        ?>
    </div>
</section>
<!-- search tutor section ends  -->




















<!-- footer section starts  -->
<?php include 'components/footer.php';?>
<!-- footer section ends  -->

<script src="js/script.js"></script>
</body>
</html>