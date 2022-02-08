<?php


$idc=$_GET['idCollect'];
$id=$_GET['id'];


echo $idc;
echo $id;

require '../config/db.php';


//id	id_Collection	name_Front	name_Back	study_Power
$sql = " DELETE FROM flashcards WHERE id = ? AND id_Collection = ?"; 
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $id, $idc);
$stmt->execute();

header("Location: add_Flashcards.php?id=$idc");

?>