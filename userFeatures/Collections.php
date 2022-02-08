<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$username=$_SESSION['username'];
require '../config/db.php';


$sql =" SELECT * FROM collection WHERE author = ?"; 
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result=$stmt->get_result();
$row=$result->fetch_All();


$RequestSignature = md5($_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'].print_r($_POST, true));
if ($_SESSION['LastRequest'] == $RequestSignature)
{
  //echo 'This is a refresh.';
  $_SESSION['watchedFlash']=array();
  $_SESSION['val']=0;
}
else
{
  //echo 'This is a new request.';
  unset($_SESSION['watchedFlash']);
  $_SESSION['watchedFlash']=array();
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
        <a href="CreateCollection.php" class="list-group-item list-group-item-action flex-column align-items-start active">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">Create new flashcard collection!</h5>
                    
                    <svg xmlns="http://www.w3.org/2000/svg" width="5%" height="5%" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                    
            </div>
            <p class="mb-1">Create flashcards for diffrent topics. Learn with us!</p>
            
        </a>


    
        <?php if(isset($row)){
                if(count($row)>0){
                    foreach($row as $rw){?>
                    <a href="add_Flashcards.php?id=<?php echo $rw[0]?>" class="list-group-item list-group-item-action flex-column align-items-start ">
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
