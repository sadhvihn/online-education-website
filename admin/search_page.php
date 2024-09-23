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


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Page</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom css link  -->
    <link rel="stylesheet" href="/css/admin_style.css">
</head>
<body>
   <!-- header section link   -->
   <?php  include'../components/admin_header.php'?>
<!-- contents section starts  -->
<section class="contents">
  <h1 class="heading"> contents</h1>
  <div class="box-container">

  <?php
    if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
      $search_box=$_POST['search_box'];
    

    $select_content = $conn->prepare("SELECT * FROM `content` WHERE title LIKE '%{$search_box}%' AND tutor_id=?  ORDER BY date DESC");
    $select_content->execute([$tutor_id,]);
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
    echo '<p class="empty">no contents was found!</p>';
    
  }
  }else{
    echo '<p class="empty">search something</p>';
  }
  ?>
  
  </div>

</section>
<section class="playlists">
  <h1 class="heading">playlists</h1>
  <div class="box-container">
    <?php
       if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){

      $select_playlist=$conn->prepare("SELECT * FROM `playlist` WHERE title LIKE '%{$search_box}%' AND tutor_id=?  ORDER BY date DESC");
      $select_playlist->execute([$tutor_id]);
      if($select_playlist->rowCount()> 0){
        while($fetch_playlist=$select_playlist->fetch(PDO::FETCH_ASSOC)){
          $playlist_id=$fetch_playlist['id'];
          $count_content = $conn->prepare("SELECT * FROM `content` WHERE playlist_id=?");
          $count_content ->execute([$playlist_id]);
          $total_contents = $count_content->rowCount();

    
    ?>
    <div class="box">
      <div class="flex">
        <div><i class="fas fa-circle-dot" style="color:<?php if($fetch_playlist['status']== 'active'){echo 'limegreen';}else{echo 'red';}?>;"></i><span style="color:<?php if($fetch_playlist['status']== 'active'){echo 'limegreen';}else{echo 'red';}?>;"><?= $fetch_playlist['status'];?></span></div>
        <div><i class="fas fa-calendar"></i><span><?= $fetch_playlist['date'];?></span></div>
      </div>
      <div class="thumb">
        <span><?= $total_contents;?></span>
        <img src="../upload_files/<?= $fetch_playlist['thumb'];?>" alt="">
      </div>
      <h3 class="title"><?= $fetch_playlist['title'];?></h3>
      <p class="description"><?= $fetch_playlist['description'];?></p>
      <form action="" method="post" class="flex-btn">
        <input type="hidden" name="delete_id" value="<?= $playlist_id;?>" id="">
        <a href="update_playlist.php?get_id=<?= $playlist_id;?>" class="option-btn">update</a>
        <input type="submit"name="delete_playlist"value="delete" class="delete-btn">
      </form>
      <a href="view_playlist.php?get_id=<?= $fetch_playlist['id']; ?>" class="btn">view playlist</a>
    </div>
    <?php
       
        }

      }else{
          echo '<p class="empty">no playlists was found!</p>';
      }
      }else{
        echo '<p class="empty">search something</p>';
      }
    ?>
  </div>
</section>
<!-- content section ends  -->


  <!-- footer section link   -->
  <?php  include'../components/footer.php'?>
<!-- custom js link  -->
<script src="/js/admin_script.js"></script>
<script>

document.querySelectorAll('.description').forEach(content =>{
    if(content.innerHTML.length>100)content.innerHTML=content.innerHTML.slice(0,100);
  });
</script>

</body>
</html>