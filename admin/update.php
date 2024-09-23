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

    $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE ID=? LIMIT 1 ");
    $select_tutor->execute([$tutor_id]);
    $fetch_tutor=$select_tutor->fetch(PDO::FETCH_ASSOC);

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $profession = $_POST['profession'];
    $profession = filter_var($profession, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
   
    if(!empty($name)){
        $update_name=$conn->prepare("UPDATE `tutors` SET name=? WHERE id=?");
        $update_name->execute([$name,$tutor_id]);
        $message[]='name updated successfully!';
    }

    if(!empty($profession)){
        $update_profession=$conn->prepare("UPDATE `tutors` SET profession=? WHERE id=?");
        $update_profession->execute([$profession,$tutor_id]);
        $message[]='profession updated successfully!';
    }

    if(!empty($email)){
        $select_tutor_email = $conn->prepare("SELECT * FROM `tutors` WHERE email=?");
        $select_tutor_email->execute([$email]);
        if($select_tutor_email->rowCount()>0){
            $message[]='email already exists';
        }else{
            $update_email=$conn->prepare("UPDATE `tutors` SET email=? WHERE id=?");
            $update_email->execute([$email,$tutor_id]);
            $message[]='email updated successfully!';
        }
       
    }
   
    $prev_image=$fetch_tutor['image'];
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = create_unique_id() . '.' . $ext;
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_folder = '../upload_files/'.$rename;

    if(!empty($image)){
        if($image_size>2000000){
            $message[]='imag size is too large';
        }
        else{
            $update_image=$conn->prepare("UPDATE `tutors` SET image=? WHERE id=?");
            $update_image->execute([$rename,$tutor_id]);
            move_uploaded_file($image_tmp_name,$image_folder);
            if($prev_image!='' AND $prev_image!=$rename){
                    unlink('../upload_files/'.$prev_image);
            }
            $message[]='image updated successfully!';
        }
    }
    $empty_pass='c45d0f25a5cc2fd5a97b561c0848f603e0fc2a5f';
    $prev_pass=$fetch_tutor['password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $c_pass = sha1($_POST['c_pass']);
    $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);


    if($old_pass!=$empty_pass){
        if($old_pass!=$prev_pass){
            $message[]='old password not matched!';
        }
        elseif($new_pass!=$c_pass){
            $message[]='confirm password not matched!';
        }else{
            if($new_pass!=$empty_pass){
                $update_pass=$conn->prepare("UPDATE `tutors` SET password=? WHERE id=?");
                $update_pass->execute([$c_pass,$tutor_id]);
                $message[]='password updated successfully!';
            }
            else{
                $message[]='please enter new password';
            }
        }
    }
 }
// $count_content = $conn->prepare("SELECT * FROM `content` WHERE tutor_id=?");


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom css link  -->
    <link rel="stylesheet" href="/css/admin_style.css">
</head>
<body>
   <!-- header section link   -->
   <?php  include'../components/admin_header.php'?>
<!-- update section starts  -->
<section class="form-container">
        <form action="" method="post" enctype="multipart/form-data">

            <h3>update profile</h3>
            <div class="flex">

                <div class="col">
                    <p>your name </p>
                    <input type="text" name="name" maxlength="50"  placeholder="<?= $fetch_profile['name'];?>" class="box">
                    <p>your profession </p>
                    <select name="profession" id="" class="box">
                        <option value="<?= $fetch_profile['profession'];?>"  selected><?= $fetch_profile['profession'];?></option>
                        <option value="developer">developer</option>
                        <option value="designer">designer</option>
                        <option value="musician">musician</option>
                        <option value="biologist">biologist</option>
                        <option value="teacher">teacher</option>
                        <option value="engineer">engineer</option>
                        <option value="lawyer">lawyer</option>
                        <option value="accountant">accountant</option>
                        <option value="doctor">doctor</option>
                        <option value="journalist">journalist</option>
                        <option value="photographer">photographer</option>
                    </select>
                    <p>your email </p>
                    <input type="email" name="email" maxlength="50"  placeholder="<?= $fetch_profile['email'];?>" class="box">
                </div>
                <div class="col">
                <p>old password </p>
                    <input type="password" name="old_pass" maxlength="20"  placeholder="enter your old password" class="box">
                   
                    <p>new password </p>
                    <input type="password" name="new_pass" maxlength="20"  placeholder="enter your new password" class="box">
                    <p>confirm password </p>
                    <input type="password" name="c_pass" maxlength="20"  placeholder="confirm your new password" class="box">
                   
                </div>
            </div>
            <p>select image </p>
                    <input type="file" name="image" class="box"  accept="image/*">
            <input type="submit" value="update now" name="submit" class="btn">
            
        </form>
    </section>
<!-- update section ends  -->


  <!-- footer section link   -->
  <?php  include'../components/footer.php'?>
<!-- custom js link  -->
<script src="/js/admin_script.js"></script>
</body>
</html>