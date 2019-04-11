<?php

session_start();

include 'init.php';
include 'contact.php';

if(isset($_GET['id'])){
	$userID = $_GET['id'];
}


   


?>
<style>
	
  .profile .img-thumbnail{
    min-width: 100%;
    height: 255px;}

</style>

<div class="container-fluid">
	<div class="posts col-xs-12 col-md-offset-1 col-lg-offset-1 col-sm-12 col-md-9 col-lg-10 col-md-10">
		
			<div class="panel panel-default">
			 	 <div class="panel-heading">
			 	 	<p>Profile Pictures</p>
			 	 </div>
			 	 <div class="panel-body profile">
			 	 	

			 	 	  <?php  
			 	 	       $sql1 = $con->prepare('SELECT * FROM avatars WHERE userID = ? ORDER BY avatarID ');
                           $sql1->execute(array($userID));
                           $img1 = $sql1->fetchAll();

                           

                           foreach ($img1 as $img1) { ?>
                                  <div class="col-md-3 col-lg-3 col-xs-12 col-sm-12"> 
			 	 	   	           <?php   

                                   
			 	 	   	            echo '<img src="upload/avatar/'. $img1['avatarName']. '"class="img-responsive img-thumbnail">' ;
			 	 	   	              

			 	 	   	                    ?>
			 	 	              </div>
                   <?php        }
			 	 	     ?>

			 	 </div>
			
	</div>
	</div>


	<div class="posts col-xs-12 col-md-offset-1 col-lg-offset-1 col-sm-12 col-md-9 col-lg-10 col-md-10">
		
			<div class="panel panel-default">
			 	 <div class="panel-heading">
			 	 	<p>Posts Pictures</p>
			 	 </div>
			 	 <div class="panel-body profile">
			 	 	

			 	 	  <?php  
			 	 	       $sql1 = $con->prepare('SELECT * FROM posts WHERE userID = ? AND postType = ? ORDER BY postID ');
                           $sql1->execute(array($userID,'2'));
                           $img1 = $sql1->fetchAll();

                           

                           foreach ($img1 as $img1) { ?>
                                  <div class="col-md-3 col-lg-3 col-xs-12 col-sm-12"> 
			 	 	   	           <?php   

                                   
			 	 	   	            echo '<img src="upload/avatar/'. $img1['postContain']. '"class="img-responsive img-thumbnail">' ;
			 	 	   	            
			 	 	   	                    ?>
			 	 	              </div>
                   <?php        }
			 	 	     ?>

			 	 </div>
			
	</div>
	</div>

</div>


<?php

 include $tmbl . 'footer.php' ;

?>