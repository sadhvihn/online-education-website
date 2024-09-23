<?php
include '../components/connect.php';
if(isset($_COOKIE['tutor_id'])){
  $tutor_id=$_COOKIE['tutor_id'];
}
 else{
  $tutor_id='';
  header('location:login.php');
 }
 if(isset($_POST['submit'])){
  $id=create_unique_id();
  $status =$_POST['status'];
  $status = filter_var($status,FILTER_SANITIZE_STRING);
  $title =$_POST['title'];
  $title = filter_var($title,FILTER_SANITIZE_STRING);
  $description =$_POST['description'];
  $description = filter_var($description,FILTER_SANITIZE_STRING);
  $playlist_id =$_POST['playlist'];
  $playlist_id = filter_var($playlist_id,FILTER_SANITIZE_STRING);

  $thumb = $_FILES['thumb']['name'];
  $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
  $thumb_ext = pathinfo($thumb, PATHINFO_EXTENSION);
  $rename_thumb = create_unique_id() . '.' . $thumb_ext;
  $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
  $thumb_size = $_FILES['thumb']['size'];
  $thumb_folder = '../upload_files/'.$rename_thumb;

  $video = $_FILES['video']['name'];
  $video = filter_var($video, FILTER_SANITIZE_STRING);
  $video_ext = pathinfo($video, PATHINFO_EXTENSION);
  $rename_video = create_unique_id() . '.' . $video_ext;
  $video_tmp_name = $_FILES['video']['tmp_name'];
  $video_folder = '../upload_files/'.$rename_video;

  $verify_content=$conn->prepare("SELECT * FROM `content` WHERE id=? AND tutor_id=? AND playlist_id=? AND title=? AND description=? AND video=? AND thumb=? AND status=?");
  $verify_content->execute([$id,$tutor_id,$playlist_id,$title,$description,$rename_video,$rename_thumb,$status]);

  if($verify_content->rowCount()>0){
    $message[]='playlist already created!';
  }
  else{
    if($thumb_size>2000000){
      $message[]='image size is too large';
    }
    else{
      $add_content = $conn->prepare("INSERT INTO `content`(id,tutor_id,playlist_id,title,description,video,thumb,status) VALUES(?,?,?,?,?,?,?,?)");
      $add_content->execute([$id,$tutor_id,$playlist_id,$title, $description,$rename_video,$rename_thumb,$status]);
      move_uploaded_file($thumb_tmp_name,$thumb_folder);
      move_uploaded_file($video_tmp_name,$video_folder);
    $message[]='new content created!';
    }
  }
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Content</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom css link  -->
    <link rel="stylesheet" href="/css/admin_style.css">
</head>
<body>
   <!-- header section link   -->
   <?php  include'../components/admin_header.php'?>
<!-- add content section starts  -->
<section class="crud-form">
  <h1 class="heading">add content</h1>
  <form action="" method="post" enctype="multipart/form-data">
  <p>content status <span>*</span></p>
    <select name="status" required class="box">
      <option value="active" >active</option>
      <option value="deactive">deactive</option>
    </select>
    <p>content title <span>*</span></p>
    <input type="text" class="box" name="title" maxlength="100" placeholder="enter content title" required>
    <p>content description <span>*</span></p>
    <textarea name="description" id="" cols="30" rows="10" placeholder="enter content description" maxlength="1000"required class="box"></textarea>
    <select name="playlist" class="box" required>
      <option value="" disabled selected>--select content</option>
      <?php 
      $select_playlist=$conn->prepare("SELECT * FROM `playlist` WHERE tutor_id=?");
      $select_playlist->execute([$tutor_id]);
      if($select_playlist->rowCount()>0){
          while($fetch_playlist= $select_playlist->fetch(PDO::FETCH_ASSOC)){
      ?>
      <option value="<?= $fetch_playlist['id'];?>"><?= $fetch_playlist['title'];?></option>
      <?php 
        }
      }else{
        echo '<option value="" disabled>no playlists created yet!</option>';
      }
      ?>
    </select>
    <p>select thumbnail <span>*</span></p>
    <input type="file" name="thumb" required accept="image/*" class="box">
    <p>select video <span>*</span></p>
    <input type="file" name="video" required accept="video/*" class="box">
    <input type="submit" class="btn" value="add content" name="submit">
  </form>
</section>
<!-- add content section ends  -->


  <!-- footer section link   -->
  <?php  include'../components/footer.php'?>
<!-- custom js link  -->
<script src="/js/admin_script.js"></script>
</body>
</html>