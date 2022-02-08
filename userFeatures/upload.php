<?php
session_start();

require '../config/db.php';

$id_Collection = $_SESSION['idCollection1'];

if(isset($_FILES['fileFc']))
{
    $file = $_FILES['fileFc'];




    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];

    

    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));

    $allowed = 'txt';

    if($file_ext == $allowed){

        if($file_error === 0){
            if($file_size <= 2097152){

                $file_name_new = uniqid('', true) . '.' . $file_ext;
                
                
                if(move_uploaded_file($file_tmp, $file_name_new)){
                    
                    $file = fopen($file_name_new, 'r');
                    $zawartosc ='';

                    while(!feof($file))
                    {

                    $linia = fgets($file);
                    $zawartosc .= $linia;

                    $cleared = trim($linia);
                    $cleared = str_replace(' ', '', $cleared);
                    $cleared = explode('-', $cleared);

                    $name_Front = $cleared[0];
                    $name_Back  = $cleared[1];

                    $sql = "INSERT INTO flashcards (id_Collection, name_Front, name_Back, study_Power) VALUES (?,?,?,?)";
                    $stmt = $conn->prepare($sql);
                    $study_Power=0;
                    $stmt ->bind_param('issi', $id_Collection, $name_Front, $name_Back, $study_Power);


                    if($stmt->execute())
                    {


                        $sql = "UPDATE collection SET amount_Fc=amount_Fc+1  WHERE id_Collection=$id_Collection";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();

                        unlink($file_name_new);

                        header("Location: add_Flashcards.php?id=".$id_Collection);

                    }
                    else{
                        echo $stmt->error;
                    }

                    }
                }
            }
        }
    }
}
header("Location: add_Flashcards.php?id=".$id_Collection);













?>