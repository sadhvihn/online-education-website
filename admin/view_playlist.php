<?php
include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
  $tutor_id = $_COOKIE['tutor_id'];
} else {
  $tutor_id = '';
  header('location:login.php');
}

if (isset($_GET['get_id'])) {
  $get_id = $_GET['get_id'];
} else {
  $get_id = '';
  echo 'get_id not set.';
  // or use var_dump($_GET); to see the entire GET parameters
  exit;  // exit the script or handle the error as needed
}

if(isset($_GET['get_id'])){
  $get_id=$_GET['get_id'];
}else{
  $get_id='';
  header('location:playlists.php');
}

if(isset($_POST['delete_playlist'])){

  $verify_playlist=$conn->prepare("SELECT * FROM `playlist` WHERE id=?");
  $verify_playlist->execute([$get_id]);

  if($verify_playlist->rowCount()>0){
    $fetch_thumb=$verify_playlist->fetch(PDO::FETCH_ASSOC);
    $prev_thumb=$fetch_thumb['thumb'];
    if($prev_thumb!=''){
      unlink('../upload_files/'.$prev_thumb);
    }
    $delete_bookmark=$conn->prepare("DELETE FROM `bookmark` WHERE playlist_id=?");
    $delete_bookmark->execute([$get_id]);
    $delete_playlist=$conn->prepare("DELETE FROM `playlist` WHERE id=?");
    $delete_playlist->execute([$get_id]);
    header('location:playlists.php');
  }else{
    $message[]='playlist was already deleted!';
  }
 }

 if(isset($_POST['delete_content'])){

  $delete_id=$_POST['content_id'];
  $delete_id=filter_var($delete_id,FILTER_SANITIZE_STRING);

  $verify_content= $conn->prepare("SELECT * FROM `content` WHERE id=?");
  $verify_content->execute([$delete_id]);

  if($verify_content->rowCount()>0){
    $fetch_content=$verify_content->fetch(PDO::FETCH_ASSOC);
    unlink('../upload_files/'.$fetch_content['thumb']);
    unlink('../upload_files/'.$fetch_content['video']);
    $delete_comment=$conn->prepare("DELETE FROM `comments` WHERE content_id=?");
    $delete_comment->execute([$delete_id]);
    $delete_likes=$conn->prepare("DELETE FROM `likes` WHERE content_id=?");
    $delete_likes->execute([$delete_id]);
    $delete_content=$conn->prepare("DELETE FROM `content` WHERE id=?");
    $delete_content->execute([$delete_id]);

    $message[]='content deleted successfully!';

  }else{
    $message[]='content already deleted';
  }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Playlists</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom css link  -->
    <link rel="stylesheet" href="/css/admin_style.css">
</head>
<body>
   <!-- header section link   -->
   <?php  include'../components/admin_header.php'?>
<!-- view playlist section starts  -->
  <section class="playlist-details">
      <h1 class="heading">playlist details</h1>
    <?php
      $select_playlist=$conn->prepare("SELECT * FROM `playlist` WHERE id=? LIMIT 1");
      $select_playlist->execute([$get_id]);
      if($select_playlist->rowCount()> 0){
        while($fetch_playlist=$select_playlist->fetch(PDO::FETCH_ASSOC)){
          $playlist_id=$fetch_playlist['id'];
          $count_content = $conn->prepare("SELECT * FROM `content` WHERE playlist_id=?");
          $count_content ->execute([$get_id]);
          $total_contents = $count_content->rowCount();
    
    
    ?>
      <div class="row">
        <div class="thumb">
          <img src="../upload_files/<?= $fetch_playlist['thumb']; ?>" alt="">
            <div class="flex">
            <p><i class="fas fa-video"></i><span><?= $total_contents;?></span></p>
            <p><i class="fas fa-calendar"></i><span><?= $fetch_playlist['date']; ?></span></p>
            </div>
        </div>
      
      <div class="details">
            <h3 class="title"><?= $fetch_playlist['title'];?></h3>
            <p class="description"><?= $fetch_playlist['description']?></p>
            <form action="" method="post" class="flex-btn">
              <input type="hidden" name="delete_id" value="<?= $fetch_playlist['id'];?>" id="">
              <a href="update_playlist.php?get_id=<?= $fetch_playlist['id'];?>" class="option-btn">update</a>
              <input type="submit"name="delete_playlist"value="delete" class="delete-btn">
          </form>
      </div>
      </div>
    <?php
       
      }

    }else{
        echo '<p class="empty"> playlist not found</p>';
    }
  ?>

  </section>

<!-- view playlist section ends  -->
<!-- contents section starts  -->
<section class="contents">
  <h1 class="heading">playlist contents</h1>
  <div class="box-container">

  <?php
    $select_content = $conn->prepare("SELECT * FROM `content` WHERE tutor_id=? AND playlist_id=?");
    $select_content->execute([$tutor_id,$get_id]);
    if($select_content->rowCount()>0){
      while($fetch_content= $select_content->fetch(PDO::FETCH_ASSOC)){
  ?>
    <div class="box">
          <div class="flex">
            <p><i class="fas fa-circle-dot" style="color:<?php if($fetch_content['status']== 'active'){echo 'limegreen';}else{echo 'red';}?>;"></i><span style="color:<?php if($fetch_content['status']== 'active'){echo 'limegreen';}else{echo 'red';}?>;"><?= $fetch_content['status'];?></span></p>
            <p><i class="fas fa-calendar"><?= $fetch_content['date'];?></i><span></span></p>
          </div>
          <img src="../upload_files/<?= $fetch_content['thumb'];?>" alt="">
          <h3 class="title"><?= $fetch_content['title'];?></h3>
          <a href="view_content.php?get_id=<?= $fetch_content['id'];?>" class="btn">view content</a>
          <form action="" class="flex-btn" method="post">
            <input type="hidden" name="content_id" value="<?= $fetch_content['id'];?>">
            <a href="update_content.php?get_id=<?= $fetch_content['id'];?>" class="option-btn">update</a>
            <input type="submit" value="delete" name="delete_content" class="delete-btn">
          </form>
    </div>
  <?php 
   }

  }else{
    echo '<p class="empty">no contents added yet!<a href="add_content.php" style="margin-top: 1.5rem;" class="btn">add new content</a></p>';
    
  }
  ?>
  
  </div>

</section>

<!-- content section ends  -->

  <!-- footer section link   -->
  <?php  include'../components/footer.php'?>
<!-- custom js link  -->
<script src="/js/admin_script.js"></script>
</body>
</html>