<?php

$errors = array();





    if(isset($_POST['createCollectionButton'])){
        
        $state_Of_Share='';


        if(empty($_POST['collection_Name']))
        {
            $errors['collection_Name'] = "Collection name required";
        }
        if(empty($_POST['collection_Topic']))
        {
            $errors['collection_Topic'] = "Collection topic required";
        }
        if(empty($_POST['StateRadio']))
        {
            $errors['collection_StateRadio'] = "Collection state of privacy required";
        }

            $name_Collection=$_POST['collection_Name']; 
            $author=$_SESSION['username']; 
            $topic=$_POST['collection_Topic'];
            $state_Of_Share = $_POST['StateRadio'];

            if($state_Of_Share=="Public"){
                $state_Of_Share=0;
            }else{
                $state_Of_Share=1;
            }
        

        if(count($errors) === 0){
            //name_Collection	author	amount_Fc	date_Created	date_Modified	topic	state_Of_Share
            
            $sql = "INSERT INTO collection (name_Collection, author, date_Created, topic, state_Of_Share) VALUES (?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $data= date("Y-m-d");
            $stmt ->bind_param('ssssi', $name_Collection, $author, $data , $topic, $state_Of_Share);

            if($stmt->execute()){

                header('Location: Collections.php');
                exit();
            }
            else{
                echo $stmt->error;
            }

        }
    }





?>