<?php
session_start();
    require "../config/db.php";

    $id_Collection=$_GET['id_Collection'];

    $sql =" SELECT * FROM collection WHERE id_Collection = ? LIMIT 1"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $id_Collection);
    $stmt->execute();
    $result=$stmt->get_result();
    $coll= $result->fetch_All();

    $sql = "INSERT INTO collection (name_Collection, author, date_Created, topic, amount_FC, state_Of_Share) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $data= date("Y-m-d");
    $one=1;
    $stmt ->bind_param('sssssi', $coll[0][1], $_SESSION['username'] , $data , $coll[0][6], $coll[0][3], $one );
    $stmt->execute();


    $sql =" SELECT * FROM collection WHERE author = ? AND date_Created = ? AND state_Of_Share=? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $_SESSION['username'], $data, $one);
    $stmt->execute();
    $result=$stmt->get_result();
    $row2=$result->fetch_All();

    
    $sql =" SELECT * FROM flashcards WHERE id_Collection = ?"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_Collection);
    $stmt->execute();
    $result=$stmt->get_result();
    $row=$result->fetch_All();
    //print_r($row);

    
    foreach($row as $flashcard)
    {   
        
        $sql = "INSERT INTO flashcards (id_Collection, name_Front, name_Back, study_Power) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $zero = 0;
        $stmt ->bind_param('issi', $row2[0][0], $flashcard[2], $flashcard[3], $zero);
        $stmt->execute();

    }
    header("Location: Collections.php");
    exit();

?>