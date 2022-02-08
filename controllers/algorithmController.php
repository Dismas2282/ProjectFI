<?php


require "../config/db.php";



// jeśli lvl>499 to nie pojawia się,itd.
// max przejrzeń 120

//jeśli host kilka nie to 000 + lvl jaki miał wcześniej
//jeśli tak to +98 + lvl

    $id_Collection=$_SESSION['id_Collection'];

    
    $sql ="SELECT * FROM flashcards WHERE id_Collection = ? ORDER BY study_Power , id ASC"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_Collection);
    $stmt->execute();
    $result=$stmt->get_result();
    $row=$result->fetch_All();




    $watchedFlash = array();

    function answerYes($idFlashcard1)
    {
        require "../config/db.php";
  

        $sql = "UPDATE flashcards SET study_Power=study_Power+90+(study_Power/100)  WHERE id=$idFlashcard1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();


    }

    function answerNo($idFlashcard1)
    {
        
        require "../config/db.php";

        $sql = "UPDATE flashcards SET study_Power=0+(study_Power/100)  WHERE id=$idFlashcard1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();


    }


?>
