<?php require_once 'controllers/authController.php';


unset($_SESSION['watchedFlash']);



$RequestSignature = md5($_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'].print_r($_POST, true));
$_SESSION['LastRequest'] = $RequestSignature;

if(isset($_GET['token']))
{
    $token = $_GET['token'];
    verifyUser($token);
}

if(!isset($_SESSION['id']))
{
    header('Location: login.php');
    exit();
}else
{
    //$_SESSION['id'] = $user['id']; 
    //$_SESSION['username'] = $user['username'];
    //$_SESSION['email'] = $user['email'];

}
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

    <title>Homepage</title>
</head>

<body>



<nav class="navbar navbar-expand-lg navbar-light bg-light">

  <a class="navbar-brand" href="#">
  <img src="images/login.png" width="60" height="60" class="d-inline-block align-center" alt=""> ProjectFI</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="#">Home</a>
      <a class="nav-item nav-link active" href="userFeatures/Collections.php">My Flashcards</a>
      <a class="nav-item nav-link active" href="userFeatures/SearchCollections.php">Search Collections</a>
      <a class="nav-item nav-link active" href="userFeatures/account.php">My Account</a>
    </div>
  </div>
</nav>



<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4 form-div login">
            <?php if(isset($_SESSION['message']))
            {?>
            <div class="alert <?php echo $_SESSION['alert-class']; ?>">

            <?php 
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            unset($_SESSION['alert-class']); ?>

            </div>
            <?php } ?>

            <h3>Welcome, <?php echo $_SESSION['username']; ?></h3>

            <a href='index.php?logout=1' class="logout">Logout</a>

            <?php if(!$_SESSION['verified']){?>
                <div class="alert alert-warning">
                    You need to verify your accout.
                    Signin to your email account and click on teh 
                    verification link we just emailed you at
                    <strong><?php echo $_SESSION['email'];?></strong>
                </div>
            <?php } ?>

            <?php if($_SESSION['verified']){?>
                <button class="btn btn-block btn-lg btn-primary">I am verified!</button>
            <?php } ?>


            

        </div>
    </div>
</div>

</body>

</html>
