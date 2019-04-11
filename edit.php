<?php

session_start();
include 'init.php';
include 'contact.php';


  
  if(isset($_SESSION['username'])){
         
         

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    	$firstName = $_POST['fname'] ;
    	$lastName = $_POST['lname'] ;
    	$userName = $_POST['username'] ;
    	$password = $_POST['Password'] ;
    	$city = $_POST['city'] ;
    	$relation = $_POST['relation'] ;

    	$sql = $con->prepare('UPDATE users SET firstName = ? ,lastName = ? ,userName = ? ,password = ? ,city = ? ,relation = ?  WHERE userID = ?');
        $sql->execute(array($firstName,$lastName,$userName,$password,$city,$relation,$_SESSION['userID']));


        header('Location:index.php?action=edit') ;
    }
  

         if(isset($_GET['id'])){
         	$userID = $_GET['id'];
         	$sql = $con->prepare('SELECT * FROM users WHERE userID = ?');
         	$sql->execute(array($userID));
         	$info = $sql->fetch();
         }

         ?>


    <div class="container-fluid">
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">
		      <div class="panel panel-default">
		      	<div class="panel-heading">
		      		<p>Edit Profile</p>
		      	</div>

		      	<div class="panel-body">
		      		<form class="form-horizontal" action="edit.php" method="post">
		      			<div class="form-group">
		      				<label class="col-sm-3 col-md-3 col-lg-3 col-xs-3"> First Name</label>
		      				<div class="col-sm-9 col-md-9 col-lg-9 col-xs-9">
		      					<input type="text" name="fname" class="form-control" value="<?php echo $info['firstName'] ?>">
		      				</div>
		      			</div>

		      			<div class="form-group">
		      				<label class="col-sm-3 col-md-3 col-lg-3 col-xs-3"> Last Name</label>
		      				<div class="col-sm-9 col-md-9 col-lg-9 col-xs-9">
		      					<input type="text" name="lname" class="form-control" value="<?php echo $info['lastName'] ?>" >
		      				</div>
		      			</div>



		      			<div class="form-group">
		      				<label class="col-sm-3 col-md-3 col-lg-3 col-xs-3"> User Name</label>
		      				<div class="col-sm-9 col-md-9 col-lg-9 col-xs-9">
		      					<input type="text" name="username" class="form-control" value="<?php echo $info['userName'] ?>" >
		      				</div>
		      			</div>

		      			<div class="form-group">
		      				<label class="col-sm-3 col-md-3 col-lg-3 col-xs-3"> Email</label>
		      				<div class="col-sm-9 col-md-9 col-lg-9 col-xs-9">
		      					<input type="email" name="email" class="form-control" value="<?php echo $info['email'] ?>" >
		      				</div>
		      			</div>


		      			<div class="form-group">
		      				<label class="col-sm-3 col-md-3 col-lg-3 col-xs-3"> Password</label>
		      				<div class="col-sm-9 col-md-9 col-lg-9 col-xs-9">
		      					<input type="text" name="Password" class="form-control" value="<?php echo $info['password'] ?>" >
		      				</div>
		      			</div>


		      			<div class="form-group">
		      				<label class="col-sm-3 col-md-3 col-lg-3 col-xs-3"> Relation</label>
		      				<div class="col-sm-9 col-md-9 col-lg-9 col-xs-9">

		      					<select class="form-control" name="relation">
		      						<option value="single" <?php if($info['relation'] == 'single') echo 'selected' ?> > Single</option>
		      						<option value="married" <?php if($info['relation'] == 'married') echo 'selected' ?> > Married</option>
		      					</select>
		      				<!--	<input type="text" name="relation" class="form-control"> -->
		      				</div>
		      			</div>


		      			<div class="form-group">
		      				<label class="col-sm-3 col-md-3 col-lg-3 col-xs-3"> City </label>
		      				<div class="col-sm-9 col-md-9 col-lg-9 col-xs-9">
		      					<input type="text" name="city" class="form-control" value="<?php echo $info['city'] ?>">
		      				</div>
		      			</div>

		      			<div class="form-group">
		      				<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
		      					<button type="submit" class="form-control btn btn-success btn-block">Save <i class="fa fa-save"></i></button>
		      				</div>
		      			</div>
		      		</form>
		      	</div>
		      </div>
		    </div>
		</div>
    </div>


        <?php
  }
  else{
  	header('Location:login.php');
  }



?>





<?php 

 include $tmbl. 'footer.php';

?>