<?php 
include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id=$_COOKIE['user_id'];
}else{
    $user_id='';
}
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    

    $verify_user = $conn->prepare("SELECT * FROM `users` WHERE email =? AND password=? LIMIT 1");
                $verify_user->execute([$email, $pass]);
                $row = $verify_user->fetch(PDO::FETCH_ASSOC);

                
                if ($verify_user->rowCount() > 0) {
                        setcookie('user_id', $row['id'], time() + 60 * 60 * 24 * 30, '/');
                        header('location:home.php');
                    } else {
                        $message[] = 'incorrect email or password';
                    }
                
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
     <!-- font awesome cdn link  -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- custom css link  -->
<link rel="stylesheet" href="/css/style.css">
</head>
<body>
<!-- header section starts  -->
<?php include 'components/user_header.php';?>
<!-- header section ends  -->

    <!-- register section starts  -->
    <section class="form-container">
        <form action="" class="login" method="post" enctype="multipart/form-data">

            <h3>Welcome Back!</h3>
           
                    <p>your email <span>*</span></p>
                    <input type="email" name="email" maxlength="50" required placeholder="enter your email" class="box">
                
                    <p>your password <span>*</span></p>
                    <input type="password" name="pass" maxlength="20" required placeholder="enter your password" class="box">
                
            
            <input type="submit" value="login now" name="submit" class="btn">
        </form>
    </section>
    <!-- register section ends  -->




















<!-- footer section starts  -->
<?php include 'components/footer.php';?>
<!-- footer section ends  -->

<script src="js/script.js"></script>
</body>
</html>