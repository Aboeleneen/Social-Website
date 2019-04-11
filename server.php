<?php
 session_start();
 include 'contact.php';
 
 
 $userID = $_SESSION['userID'];
 $postID = $_REQUEST['postID'];



 $sql = $con->prepare("SELECT * FROM likes WHERE userID = ? AND postID = ?");
 $sql->execute(array($userID,$_REQUEST['postID']));
 $count = $sql->rowCount();

 if($count == 0){
 	$sql = $con->prepare("INSERT INTO likes (userID,postID) VALUES ($userID,$postID)");
 	$sql->execute();
 }

 $sql = $con->prepare("SELECT * FROM likes WHERE postID = ?");
 $sql->execute(array($postID));

 echo $sql->rowCount() ;



 ?>