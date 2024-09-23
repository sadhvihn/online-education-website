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
    <title>Search Courses</title>
     <!-- font awesome cdn link  -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- custom css link  -->
<link rel="stylesheet" href="/css/style.css">
</head>
<body>
<!-- header section starts  -->
<?php include 'components/user_header.php';?>
<!-- header section ends  -->

<!-- search course section starts  -->
<section class="course">
    <h1 class="heading">search results</h1>

    <div class="box-container">
        <?php
            if(isset($_POST['search-box']) or isset($_POST['search_btn'])){
                $search_box=$_POST['search_box'];
                $select_courses = $conn->prepare("SELECT * FROM `playlist` WHERE title LIKE '%{$search_box}%' AND status=? ORDER BY date DESC");
                $select_courses->execute(['active']);
                if($select_courses->rowCount()>0){
                    while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)){
                        $course_id = $fetch_course['id'];

                        $count_course = $conn->prepare("SELECT * FROM `content` WHERE playlist_id=?");
                        $count_course->execute([$course_id]);
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
            echo '<p class="empty">no courses found!</p>';
        }
    }else{
        echo '<p class="empty">please search something!</p>';
    }
        ?> 
    </div>
    
</section>


















<!-- search course section ends  -->
<!-- footer section starts  -->
<?php include 'components/footer.php';?>
<!-- footer section ends  -->

<script src="js/script.js"></script>
</body>
</html>