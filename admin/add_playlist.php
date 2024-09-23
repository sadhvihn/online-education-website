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

if(isset($_POST['submit'])){
  $id=create_unique_id();
  $status =$_POST['status'];
  $status = filter_var($status,FILTER_SANITIZE_STRING);
  $title =$_POST['title'];
  $title = filter_var($title,FILTER_SANITIZE_STRING);
  $description =$_POST['description'];
  $description = filter_var($description,FILTER_SANITIZE_STRING);

  $thumb = $_FILES['thumb']['name'];
  $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
  $ext = pathinfo($thumb, PATHINFO_EXTENSION);
  $rename = create_unique_id() . '.' . $ext;
  $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
  $thumb_size = $_FILES['thumb']['size'];
  $thumb_folder = '../upload_files/'.$rename;

  $verify_playlist=$conn->prepare("SELECT * FROM `playlist` WHERE id=? AND tutor_id=? AND title=? AND description=? AND thumb=? AND status=?");
  $verify_playlist->execute([$id,$tutor_id,$title,$description,$thumb,$status]);

  if($verify_playlist->rowCount()>0){
    $message[]='playlist already created!';
  }
  else{
    $add_playlist = $conn->prepare("INSERT INTO `playlist`(id,tutor_id,title,description,thumb,status) VALUES(?,?,?,?,?,?)");
    $add_playlist->execute([$id,$tutor_id,$title, $description,$rename,$status]);
    move_uploaded_file($thumb_tmp_name,$thumb_folder);
  $message[]='new playlist created!';
  }


  

}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Playlist</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom css link  -->
    <link rel="stylesheet" href="/css/admin_style.css">
</head>
<body>
   <!-- header section link   -->
   <?php  include'../components/admin_header.php'?>
<!-- add playlist section starts  -->
<section class="crud-form">
  <h1 class="heading">add playlist</h1>
  <form action="" method="post" enctype="multipart/form-data">
    <p>playlist status <span>*</span></p>
    <select name="status" required class="box">
      <option value="active" >active</option>
      <option value="deactive">deactive</option>
    </select>
    <p>playlist title <span>*</span></p>
    <input type="text" class="box" name="title" maxlength="100" placeholder="enter playlist title" required>
    <p>playlist description <span>*</span></p>
    <textarea name="description" id="" cols="30" rows="10" placeholder="enter playlist description" maxlength="1000"required class="box"></textarea>
    <p>playlist thumbnail <span>*</span></p>
    <input type="file" name="thumb" required accept="image/*" class="box">
    <input type="submit" class="btn" value="create playlist" name="submit">
  </form>
</section>
<!-- add playlist section ends  -->


  <!-- footer section link   -->
  <?php  include'../components/footer.php'?>
<!-- custom js link  -->
<script src="/js/admin_script.js"></script>
</body>
</html>