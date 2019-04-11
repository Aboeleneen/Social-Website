<?php
session_start();

 include 'contact.php';

 if($_SERVER['REQUEST_METHOD'] == 'POST'){

   $username = $_POST['username'];
   $password = $_POST['password'];

   $sql = $con->prepare('SELECT * FROM users WHERE userName=? AND password=?');
   $sql->execute(array($username,$password));
   $row=$sql->fetch();
   $count = $sql ->rowCount();

   if($count > 0 ){ 
   	
   
  

  $_SESSION['username']=$username;
  $_SESSION['userID']=$row['userID'];

  header('Location:index.php?action=login');

  
	
   }
   else{
    echo '<script type="text/javascript">';
      echo "setTimeout(function () { swal({
  
  imageUrl: 'images/3.jpg',
  imageWidth: 400,
  imageHeight: 400,
  imageAlt: 'Custom image',
  animation: true
});";






     echo '}, 100);</script>'; 

   }
 }


?> 





<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>login</title>
	 <!-- materialize -->
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">

      <!-- materialize icon -->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

       <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">


      <style type="text/css">
      	.card-panel{
      		height: 400px;
      		width: 400px;
      		position: relative;
      		    top: 70px;
    left: 300px;
      	}
      	body{
      		background: url('images/2.jpg');
      		
      		background-size: cover;
      	}
        img{
              margin-bottom: 10px;
        }
 
      </style>
</head>
<body>
        <div class="container">
           
	        	<div class="col m12 offset-m1 card-panel  ">
	        		<h4 class="center blue-text logo"><img src="logo/3.png"></h4> 
		      <form class="col m12" action="login.php" method="post">
      <div class="row">
        <div class="input-field">
          <i class="material-icons prefix">account_circle</i>
          <input id="icon_prefix" type="text" class="validate" name="username">
          <label for="icon_prefix">User Name</label>
        </div>
        <div class="input-field">
          <i class="material-icons prefix">fingerprint</i>
          <input id="icon_telephone" type="tel" class="validate" name="password">
          <label for="icon_telephone">password</label>
        </div>
     
        	
       
      </div>
      <div class="row">
       <button class="btn waves-effect waves-light col m5 offset-m1" type="submit" name="action">Login
    <i class="material-icons right">login</i> </button>
     <a class="btn waves-effect deep-orange darken-2 col m5 offset-m1" href="signup.php">Signup
    <i class="material-icons right">signup</i>
  </a>
</div>
    </form>
		        </div>
           
        </div>


        	<script src="js/sweetalert2.all.min.js"></script>
<!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>

</body>
</html>