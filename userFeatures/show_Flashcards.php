<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$username=$_SESSION['username'];

require "../config/db.php";



$_SESSION['val']=0;

$id_Collection=$_GET['id'];

//id	id_Collection	name_Front	name_Back	study_Power
$sql =" SELECT * FROM flashcards WHERE id_Collection = ?"; 
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $id_Collection);
$stmt->execute();
$result=$stmt->get_result();
$row=$result->fetch_All();

$RequestSignature = md5($_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'].print_r($_POST, true));





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

                <a href="BorrowCollection.php?id_Collection=<?php echo $_GET['id']; ?>" class="studylink">
                    <div class="studyflashcards">

                        <h1 class="h1study">Borrow these flashcards</h1>

                    </div>
                </a>

                    <?php if(isset($row)){
                            if(count($row)>0){$nb_flash=0;
                            foreach($row as $rw){$nb_flash++;?>
                                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1"><?php echo $nb_flash;?></h5>

                                    </div>
                                    
                                    <p class="mb-1"><?php echo $rw[2];?></p>
                                    <small class="text-muted"><?php echo $rw[3]?></small>
                                </a>
                                
                    <?php }}}?>

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
