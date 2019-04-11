<?php
 
 include 'contact.php';
 
 if(isset($_REQUEST['req'])){
     
        $userID = $_REQUEST['userID'];
        $friendID = $_REQUEST['friendID'];
      	$sql= $con->prepare("INSERT INTO friendlist (userID,friendID,status) VALUES ('$userID','$friendID','no') ");
      	$sql->execute();

      	$sql = $con->prepare("INSERT INTO notifactions(type,sender,recevier) VALUES ('5','$friendID','$userID')");
      	$sql->execute();
       
        $sql = $con->prepare("SELECT * FROM users WHERE userID = ? limit 1 " );
 		$sql->execute(array($userID));
 		$Name = $sql->fetch();
 		$num = $Name['notifactions'] + 1 ;
 		$sql = $con->prepare("UPDATE users SET notifactions = ? WHERE userID = ?");
 		$sql->execute(array($num,$userID));

      	echo "<button class='btn btn-warning' > <i class='fa fa-user-plus'> </i> </button>" ;
      
 }
 else if(isset($_REQUEST['accept'])){
     
     $sender = $_REQUEST['sender'];
     $recevier = $_REQUEST['recevier'];
 	 $sql = $con->prepare("DELETE FROM notifactions WHERE sender=? AND recevier=?  AND type=? ");
 	 $sql->execute(array($sender,$recevier,'5'));

 	 $sql = $con->prepare("UPDATE friendlist SET status='yes' WHERE userID = ? AND friendID = ?");
 	 $sql->execute(array($recevier,$sender));

 	 $sql = $con->prepare("SELECT * FROM users WHERE userID = ?");
 	 $sql->execute(array($sender));
 	 $name = $sql->fetch();

     echo "<P> You accept "."<a href='profile.php?id=".$name['userID']."'>".$name['userName']."</a>"." request </p>";
 }
 else {
 $user=$_REQUEST['userName'];
 if($user == ""){

 }
 else {
 $sql = $con->prepare("SELECT * FROM users WHERE userName = ?");
 $sql->execute(array($user));
 $count = $sql->rowCount();
 if($count > 0 ){
 	echo "Error" ;
 }
 else{
 	echo "Valid";
 }
}
}




 ?>