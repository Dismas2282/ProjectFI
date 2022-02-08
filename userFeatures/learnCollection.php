<?php 
session_start();

error_reporting(E_ERROR | E_WARNING | E_PARSE);



$username=$_SESSION['username'];

require "../config/db.php";


require "../controllers/algorithmController.php";






$RequestSignature = md5($_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'].print_r($_POST, true));

if ($_SESSION['LastRequest'] == $RequestSignature)
{
    

    

}else{
    
    
    $_SESSION['LastRequest'] = $RequestSignature;
}




if(!isset($_SESSION['id']))
{
    header('Location: ../login.php');
    exit();
}

if(isset($_POST['btn-learn-yes']) ){
    $_SESSION['YesOrNO'] = "YES";
    
    
}
if(isset($_POST['btn-learn-no']) ){
    $_SESSION['YesOrNO'] = "NO";
    
    
}

if(isset($_POST['btn-learn-next'])){
    if( $_SESSION['val'] + 2 > count($row)){
        $_SESSION['val']=0;
    }
    else{
        
        if($_SESSION['YesOrNO'] == "NO"){
            answerNo($row[$_SESSION['val']][0]);
            //echo "NO";
        }
        elseif($_SESSION['YesOrNO'] == "YES")
        {
            answerYes($row[$_SESSION['val']][0]);
             //echo "YES";

        }  

        

        array_push($_SESSION['watchedFlash'],$row[$_SESSION['val']][0]);


       
        $_SESSION['val']++;
        
    }
    unset($_POST['btn-learn-yes']);
    unset($_POST['btn-learn-no']);
    unset($_POST['btn-learn-next']);
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

    <link rel="stylesheet" href="../css/style_Learning.css">


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
      <a class="nav-item nav-link active" href="#">My Account</a>
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

                
                    <h1> <?php if(isset($_POST['btn-learn-yes']) || isset($_POST['btn-learn-no']) )
                    {echo $row[$_SESSION['val']][3];}
                    else{
                        if($_SESSION['val']==0){
                            echo $row[$_SESSION['val']][2];
                        }
                        else{
                            echo $row[$_SESSION['val']+1][2];
                        }
                    }?> </h1>

                    <h2><?php if(isset($_POST['btn-learn-yes']) || isset($_POST['btn-learn-no']) )
                    {echo $row[$_SESSION['val']][2];
                        ;}?>
                    </h2>
                
                

            </div>
            <h3>You know it?</h3>
            <div class="buttons">
                <form method="post" class="form-btn">
                    <div class="btn-yes">
                        <button name="btn-learn-yes" class="btn btn-success">YES</button>
                    </div>

                    <div class="btn-no">
                        <button name="btn-learn-no" class="btn btn-danger">NO</button>
                    </div>


                </form>

            </div>

            <form method="post" class="btn-next">
                    <div class="btn-next">
                        <button name="btn-learn-next" class="btn btn-primary">NEXT</button>
                    </div>
                </form>

        </div>
        
        
        <div class="col-sm-2 bg-primary sidenav_left">
            <div class="well">
                <h1></h1>
            </div>
            <div class="well">
                <h1></h1>
            </div>
        </div>


    </div>
</div>



</body>

</html>
