<?php

    require '../config/db.php';

    $errors=array();


    $id_Collection = $_GET['id'];
    $_SESSION['id_Collection']=$id_Collection;
    $study_Power=0;



    $RequestSignature = md5($_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'].print_r($_POST, true));
    if ($_SESSION['LastRequest'] == $RequestSignature)
    {

    unset($_POST['btn_Add_FC']);
    unset($_POST['flashcard_Front']);
    unset($_POST['flashcard_Back']);

    }
    else
    {
        if(isset($_FILES['fileFc']))
        {
            $file = $_FILES['fileFc'];

            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];
            $file_size = $file['size'];

            $file_ext = explode('.', $file_name);

            print_r($file_ext);

            
        }
        else{

        
            if(isset($_POST['btn_Add_FC']))
            {   
                
                if(empty($_POST['flashcard_Front'])){
                        $errors['Front'] = "Please fill front form!";
                }
                if(empty($_POST['flashcard_Back'])){
                        $errors['Back'] = "Please fill back form!";}
                
                $name_Front=$_POST['flashcard_Front'];
                $name_Back=$_POST['flashcard_Back'];


                if(count($errors) === 0){
                    //id	id_Collection	name_Front	name_Back	study_Power
                    $sql = "INSERT INTO flashcards (id_Collection, name_Front, name_Back, study_Power) VALUES (?,?,?,?)";
                    $stmt = $conn->prepare($sql);
                    $stmt ->bind_param('issi', $id_Collection, $name_Front, $name_Back, $study_Power);


                    if($stmt->execute())
                    {
                        $alert= "Successfully added flashcard!";


                        $sql = "UPDATE collection SET amount_Fc=amount_Fc+1  WHERE id_Collection=$id_Collection";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();

                    }
                    else{
                        echo $stmt->error;
                    }
                }
            }
        }
    $_SESSION['LastRequest'] = $RequestSignature;
    }
?>