
<?php
   
   session_start();
  if(isset($_SESSION['username'])){
  include 'init.php';
  include 'contact.php';
   

  	if(isset($_GET['action'])){
   
   if($_GET['action'] == "login"){

   echo '<script type="text/javascript">';
  echo 'setTimeout(function () { swal("KokoBook","welcome to your website","success");';
  echo '}, 10);</script>'; }

  else if($_GET['action'] == 'edit'){

   echo '<script type="text/javascript">';
  echo 'setTimeout(function () { swal("KokoBook","Edit Done","success");';
  echo '}, 10);</script>'; }


}


}
  else {
  	header('Location:login.php');
  
  }


?>


<div class="container-fluid">
	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 ads" >
		 <?php include $tmbl.'ads.php' ?>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 " >
		<?php include $tmbl.'search.php' ?>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 " >
		<?php include $tmbl.'users.php' ?>
		 
	</div>

	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 " >
		<?php include $tmbl.'control.php' ?>
	</div>


</div>
 



<?php

 include $tmbl .'footer.php';

?> 
