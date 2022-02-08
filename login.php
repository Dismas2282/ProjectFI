<?php

require_once 'controllers/authController.php';


?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset="UTF-8">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">  

    <!-- Bootstrap 4 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" type='text/css'>
  
    <link rel="stylesheet" href="css/style.css">

    <title>LOGIN</title>
</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4 form-div login">
            <form action="login.php" method="post">
               <h3 class="text-center">Login</h3> 

               <?php if(count($errors)>0):  ?>

                    <div class= "alert alert-danger">
                        <?php foreach($errors as $error): ?>
                            <li> <?php echo $error; ?></li>
                        <?php endforeach;?>
                    </div>

                <?php endif;?>

                <div class="form-group">
                    <label for="username">Username or Email</label>
                    <input type="text" name="username" value="<?php echo $username;?>" class="form-control form-control-lg">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg">
                </div>
                
                <div class="form-group">
                    <button type="submit" name="login-btn" class="btn btn-primary btn-block btn-lg">Login</button>
                </div>

                <p class="text-center">Not yet a member? <a href="signup.php">Sign In</a></p>

            </form>
        </div>
    </div>
</div>

</body>

</html>
