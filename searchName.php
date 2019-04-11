
<?php
   session_start();
  if(isset($_SESSION['username'])){
  include 'init.php';
  include 'contact.php';


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
		<div class="panel panel-default">
 	
		 	<div class="panel-heading">
		 	 	<p>Users</p>
		 	</div>

		 	<div class="panel-body">
		 		<?php
              $searchName=$_POST['searchName'];
              
		      $sql = $con->prepare("SELECT * FROM users WHERE userName LIKE '$searchName' OR firstName LIKE '$searchName' OR lastName LIKE '$searchName' OR email LIKE '$searchName' ");
		      $sql->execute();

		      $info = $sql->fetchAll();

		    

		 		?>
				<div class="row">

					<?php foreach ($info as $info) { ?>
						
					
					<div class="col-sm-6 col-md-4">
						<div class="thumbnail">
						  <img src="images/1.jpeg" alt="...">
						  <div class="caption">
						    <h4 class="text-center"><strong><?php echo $info['userName'] ?></strong></h4>
						    <p class="text-center"><?php echo $info['city']."  ".$info['age'] ?></p>
						    <p class="text-center"><a href="#" class="btn btn-primary" role="button"><i class="fa fa-user-plus"> </i></a> <a href="#" class="btn btn-default" role="button"><i class="fa fa-comments"> </i></a></p>
						  </div>
						</div>
					</div>

				<?php } ?>
		        </div>
 	        </div>
        </div>
		 
	</div>

	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 " >
		<?php include $tmbl.'control.php' ?>
	</div>


</div>




<?php

 include $tmbl .'footer.php';

?> 
