<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$username=$_SESSION['username'];
require '../config/db.php';


$sql =" SELECT * FROM collection WHERE state_Of_Share = 0"; 
$stmt = $conn->prepare($sql);
$stmt->execute();
$result=$stmt->get_result();
$row=$result->fetch_All();


$RequestSignature = md5($_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'].print_r($_POST, true));
if ($_SESSION['LastRequest'] == $RequestSignature)
{
  
  $_SESSION['watchedFlash']=array();
  $_SESSION['val']=0;
}
else
{
  unset($_SESSION['watchedFlash']);
  $_SESSION['watchedFlash']=array();
  $_SESSION['val']=0;
  $_SESSION['LastRequest'] = $RequestSignature;
  $_SESSION['val']=0;
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
      <a class="nav-item nav-link active" href="#">Search Collections</a>
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

    
        <?php if(isset($row)){
                if(count($row)>0){
                    foreach($row as $rw){?>
                    <a href="show_Flashcards.php?id=<?php echo $rw[0]?>" class="list-group-item list-group-item-action flex-column align-items-start ">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?php echo $rw[1];?></h5>
                            <small class="text-muted"><?php echo $rw[5];?></small>
                        </div>
                        

                        <p class="mb-1"><?php echo $rw[6];?></p>
                        <small class="text-muted"><?php if($rw[7]==0){echo "State: Public";}
                        else{echo "State: Private";}
                        ?></small>
                                             <?php if($rw[3]!=0){ ?><span class="badge bg-primary rounded-pill"><?php  echo $rw[3];?></span>
                        <?php } ?>
                    </a>
       <?php }}}?>
    

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
