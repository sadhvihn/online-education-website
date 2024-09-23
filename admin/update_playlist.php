<?php
include '../components/connect.php';
if(isset($_COOKIE['tutor_id'])){
  $tutor_id=$_COOKIE['tutor_id'];
}
 else{
  $tutor_id='';
  header('location:login.php');
 }
if(isset($_GET['get_id'])){
  $get_id=$_GET['get_id'];
}else{
  $get_id='';
  header('location:playlists.php');
}

if(isset($_POST['update'])){
  $status =$_POST['status'];
  $status = filter_var($status,FILTER_SANITIZE_STRING);
  $title =$_POST['title'];
  $title = filter_var($title,FILTER_SANITIZE_STRING);
  $description =$_POST['description'];
  $description = filter_var($description,FILTER_SANITIZE_STRING);


  $old_thumb = isset($_POST['old_thumb']) ? $_POST['old_thumb'] : '';
$old_thumb = filter_var($old_thumb, FILTER_SANITIZE_STRING);


  //$old_thumb = ($_POST['old_thumb']);
  //$old_thumb=filter_var($old_thumb,FILTER_SANITIZE_STRING);

  $thumb = $_FILES['thumb']['name'];
  $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
  $ext = pathinfo($thumb, PATHINFO_EXTENSION);
  $rename = create_unique_id() . '.' . $ext;
  $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
  $thumb_size = $_FILES['thumb']['size'];
  $thumb_folder = '../upload_files/'.$rename;


  $update_playlist= $conn->prepare("UPDATE `playlist` SET status=?,title=?,description=? ,thumb=? WHERE id=?");
  $update_playlist->execute([$status,$title,$description,$thumb,$get_id]);
  $message[]='playlist updated successfully'; 


  if(!empty($thumb)){
    if($thumb_size>2000000){
      $message[]='image size is too large';
    }else{
      $update_thumb=$conn->prepare("UPDATE `playlist` SET thumb=? WHERE id=?");
      $update_thumb->execute([$rename, $get_id]);
      move_uploaded_file($thumb_tmp_name,$thumb_folder);
      if($old_thumb !='' AND $old_thumb != $rename){
        unlink('../upload_files/'.$old_thumb);
      }

    }
  }
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
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Playlist</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom css link  -->
    <link rel="stylesheet" href="/css/admin_style.css">
</head>
<body>
   <!-- header section link   -->
   <?php  include'../components/admin_header.php'?>
<!-- update playlist section starts  -->
<section class="crud-form">
  <h1 class="heading">update playlist</h1>

  
  <?php
      $select_playlist=$conn->prepare("SELECT * FROM `playlist` WHERE id=?");
      $select_playlist->execute([$get_id]);
      if($select_playlist->rowCount()> 0){
        while($fetch_playlist=$select_playlist->fetch(PDO::FETCH_ASSOC)){
          $playlist_id=$fetch_playlist['id'];
    
    
    ?>
   
  <form action="" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="playlist_id" value="<?php  $playlist_id; ?>">
    <input type="hidden" name="old_thumb" value="<?= $fetch_playlist['thumb'];?>">

    <p>update status </p>
    <select name="status" required class="box">
      <option value="<?= $fetch_playlist['status'];?>" ><?= $fetch_playlist['status'];?></option>
      <option value="active" >active</option>
      <option value="deactive">deactive</option>
    </select>
    <p>update title </p>
    <input type="text" class="box"required name="title" maxlength="100" placeholder="enter playlist title"value="<?= $fetch_playlist['title'];?>" >
    <p>update description </p>
    <textarea name="description" id="" cols="30" rows="10" placeholder="enter playlist description" maxlength="1000" class="box"required><?= $fetch_playlist['description'];?></textarea>
    <p>update thumbnail </p>
    <img src="../upload_files/<?= $fetch_playlist['thumb'];?>" alt="">
    <input type="file" name="thumb"  accept="image/*" class="box" required>
    <input type="submit" class="btn" value="update playlist" name="update">
    <div class="flex-btn">
      <input type="submit" value="delete playlist" name="delete_playlist" class="delete-btn">
      <a href="view_playlist.php?get_id=<?= $playlist_id;?>" class="option-btn">view playlist</a>
    </div>
  </form>
  <?php
       
      }

    }else{
        echo '<p class="empty"> playlist not found</p>';
    }
  ?>
</section>
<!-- update playlist ends  -->




  <!-- footer section link   -->
  <?php  include'../components/footer.php'?>
<!-- custom js link  -->
<script src="/js/admin_script.js"></script>
</body>
</html>
