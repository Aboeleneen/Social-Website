<style>
	.fa-star{
		color:#ff8f00;
		font-size: 20px;
	}
	.fa-eye{
		font-size: 20px
	}
	.fa-heart{
		color: red;
		font-size: 20px;
	}
	.fa-circle{
		color: green;
	}
	.fa-warning{
		font-size: 20px;
	}
	.fa-bell{
		color:#2f4bb3;
		font-size: 20px;
	}
</style>
<div class="panel panel-default">
 	 <div class="panel-heading">
 	 	<p> Control </p>
 	 </div>
 	 <div class="panel-body">
 	 	<ul class="list-group">
			  <a class="list-group-item"> <i class="fa fa-star"> </i> Favourite</a>
			  <a class="list-group-item" href="visitors.php?action=visit" ><i class="fa fa-eye"> </i> Visitors</a>
			  <a class="list-group-item" href="visitors.php?action=follow" ><i class="fa fa-heart"> </i> Followers</a>
			  <a class="list-group-item"> <i class="fa fa-circle"> </i> Active List</a>
			  <a class="list-group-item"> <i class="fa fa-warning"> </i> Block List</a>
			  <a class="list-group-item" href="visitors.php?action=notify" > <i class="fa fa-bell"> </i>  Notifactions 
                 
                 <?php  

                  $sql = $con->prepare("SELECT * FROM users WHERE userID = ?");
                  $sql->execute(array($_SESSION['userID']));
                  $info = $sql->fetch();
                  echo '<span class="badge" >'.$info['notifactions'].'</span>' ;



                 ?>

			  </a>
       </ul>
 	 </div>
</div>