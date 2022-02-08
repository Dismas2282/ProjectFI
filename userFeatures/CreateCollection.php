<?php 
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require '../config/db.php';
require '../controllers/collectionController.php';

if(!isset($_SESSION['id']))
{
    header('Location: ../login.php');
    exit();
}
 //print_r($_POST['StateRadio']);

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

    <link rel="stylesheet" href="../css/style_ShowCollections.css" type='text/css'>

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

<?php if(count($errors)>0):  ?>
  <div class="alert alert-danger" role="alert">

      <?php foreach($errors as $error):?>
        <li> <?php echo $error; ?> </li>
      <?php endforeach;?>

  </div>
<?php endif;?>


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
    <div class="col-sm-6">
      <form action="createCollection.php" method='POST' >

        <div class="main-content row">
          <div class="form-group col-sm-5">
                <label for="collection_Name">Name your collection</label>
                <input type="text" name="collection_Name" class="form-control form-control-sm">
            
                <label for="collection_Topic">Topic of your collection</label>
                <input type="text" name="collection_Topic" class="form-control form-control-sm">
          </div>
          <div class="radiocheck col-sm-5">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="StateRadio" value="Private" id="flexRadioDefault1"checked>
              <label class="form-check-label" for="flexRadioDefault1">
              Private
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="StateRadio" value="Public" id="flexRadioDefault2" >
              <label class="form-check-label" for="flexRadioDefault2">
              Public
              </label>
            </div>
            <button class="btn btn-primary" type="submit" name='createCollectionButton'>Create</button>
          </div>
        </div>

          
      </form>
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
