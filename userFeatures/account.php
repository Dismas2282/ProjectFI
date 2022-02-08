<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$username=$_SESSION['username'];

require "../config/db.php";



$_SESSION['val']=0;



//id	id_Collection	name_Front	name_Back	study_Power
$sql =" SELECT username, email FROM users WHERE username = ?"; 
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result=$stmt->get_result();
$row=$result->fetch_All();

$RequestSignature = md5($_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'].print_r($_POST, true));


if(isset($_POST["btn-change"]))
{
    if(!empty($_POST["change-email-btn"])){

        $email=$_POST["change-email-btn"];

        echo "asdad";
        $sql = "UPDATE users SET email='$email'  WHERE username='$username'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        
    }
    if(!empty($_POST["change-pass-btn"])){

        $pass=$_POST["change-pass-btn"];
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        

        $sql = "UPDATE users SET password='$pass' WHERE username='$username'";
        $stmt = $conn->prepare($sql);
        //$stmt->execute();

        if($stmt->execute())
        {


        }
        else{
            echo $stmt->error;
        }
    }

    //echo "2222222222222222";
}
 


if(!isset($_SESSION['id']))
{
    header('Location: ../login.php');
    exit();
}
 
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset="UTF-8">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">  

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" type='text/css'>

    <link rel="stylesheet" href="../css/style_Collections.css">


    <title>Homepage</title>
</head>

<body>




<nav class="navbar navbar-expand-lg navbar-light bg-light">

  <a class="navbar-brand" href="#">
  <img src="../images/login.png" width="60" height="60" class="d-inline-block align-center" alt=""> ProjectFI</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="../index.php">Home</a>
      <a class="nav-item nav-link active" href="Collections.php">My Flashcards</a>
      <a class="nav-item nav-link active" href="SearchCollections.php">Search Collections</a>
      <a class="nav-item nav-link active" href="account.php">My Account</a>
    </div>
  </div>

    <div class="row">
        <div class="col-md-4 offset-md-4 form-div login">

            Welcome, <?php echo $_SESSION['username']; ?>

        </div>
    </div>
    <a href='../index.php?logout=1' class="logout">Logout</a>

</nav>


<div class="container-fluid text-center"> 
    <div class="row content">

        <div class="col-sm-2 bg-primary sidenav_left">
            <div class="well">
                <h1></h1>
            </div>
            <div class="well">
                <h1></h1>
            </div>
        </div>

        <div class="col-sm-6 list-group">
            <div class= "flashcards-input">
                        
                
                    <div class="studyflashcards">

                        <h1 class="h1study">Change your account</h1>


                    </div>
                    <form class="form-change" method=POST action="#">
                            <h6 class="h6user">Change your password</h6>
                            <input class="form-control" name="change-pass-btn" type="password" placeholder="" aria-label="change password">
                            <h6 class="h6email">Change your email</h6>
                            <input class="form-control" type="text" name="change-email-btn" placeholder="<?php echo $row[0][1];  ?>" aria-label="change email">

                            <button class="btn btn-primary" name="btn-change">SEND</button>
                    </form>

                    

            </div>

        </div>
        
        
            <div class="col-sm-2 bg-primary sidenav_right">
                <div class="container-fluid text-white">
                    <h1></h1>
                </div>
                <div class="container-fluid text-white">
                    <h1></h1>
                </div>
            </div>


    </div>
</div>


</body>

</html>
