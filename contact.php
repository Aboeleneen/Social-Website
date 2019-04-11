<?php
 
 $dsn='mysql:host=localhost;dbname=social';
 $user = 'root';
 $pass='';
 $options =array(
     PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' 

  );

 try {
 	$con = new PDO($dsn,$user,$pass,$options);
 	 $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 } catch (Exception $e) {
 		echo 'Failed To Connect' . $e->getmessage();
 }
 


?>