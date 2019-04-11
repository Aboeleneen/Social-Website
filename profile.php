<?php

session_start();

include 'init.php';
include 'contact.php';
$flag= 0 ;

 /* Visitors page */


 if(isset($_GET['visitor'])){
 	$userID = $_GET['id'];
 	$visitorID = $_GET['visitor'];
 	$sql = $con->prepare("SELECT * FROM visitors WHERE userID = ? AND visitorID = ?");
 	$sql->execute(array($userID,$visitorID));
 	$count = $sql->rowCount();
 	if( $count == 0 ){
 		$sql = $con->prepare("INSERT INTO visitors (userID,visitorID) VALUES ('$userID','$visitorID')");
 		$sql->execute();
 	}
 }


 /* end Visitors page */


 /* followers page */


if(isset($_GET['follower'])){
 	$userID = $_GET['id'];
 	$followerID = $_GET['follower'];
 	$sql = $con->prepare("SELECT * FROM followers WHERE userID = ? AND followerID = ?");
 	$sql->execute(array($userID,$followerID));
 	$count = $sql->rowCount();
 	if( $count == 0 ){
 		$sql = $con->prepare("INSERT INTO followers (userID,followerID) VALUES ('$userID','$followerID')");
 		$sql->execute();
 		$sql = $con->prepare("SELECT * FROM users WHERE userID = ? limit 1 " );
 		$sql->execute(array($userID));
 		$followName = $sql->fetch();
 		$num = $followName['notifactions'] + 1 ;
 		$sql = $con->prepare("UPDATE users SET notifactions = ? WHERE userID = ?");
 		$sql->execute(array($num,$userID));
 		$sql = $con->prepare("INSERT INTO notifactions (type,sender,recevier) VALUES ('4',$followerID,$userID)");
 		$sql->execute();
 	}
 }

 if(isset($_GET['unfollower'])){
 	$userID = $_GET['id'];
 	$followerID = $_SESSION['userID'];
 	$sql = $con->prepare("DELETE FROM followers WHERE userID = ? AND followerID = ?");
 	$sql->execute(array($userID,$followerID));
 }

 /* end followers page */


 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$userID = $_SESSION['userID'];
	$postContain = $_POST['postContain'];
	$sql = $con->prepare("INSERT INTO posts (postType, postContain,userID) VALUES ('3', '$postContain','$userID');");
	$sql->execute();
	/* notifaction */

	
       $sql = $con->prepare("SELECT * FROM posts ORDER BY postID DESC LIMIT  1 ");
       $sql->execute();
       $post= $sql->fetch();
       $postID = $post['postID']; 
       $text = $postContain ;
       $text = explode(" ", $text) ;
      
       foreach ($text as $word) {
           if(substr($word,0,1) == "@"){
            $mention = $con->prepare("SELECT * FROM users WHERE userName = ?");
            $mention->execute(array(substr($word,1,strlen($word)-1)));
            $mentionName = $mention->fetch();
            $sender = $_SESSION['userID'];
            $recevier = $mentionName['userID'];
            $num = $mentionName['notifactions'] + 1 ;
            $sql = $con->prepare("UPDATE users SET notifactions = ? WHERE userID = ?");
            $sql->execute(array($num,$recevier));
            $sql = $con->prepare("INSERT INTO notifactions (type, sender,recevier,postID) VALUES ('1', '$sender','$recevier','$postID');");
            $sql->execute();

           }
       }
         


                          


	/* End notifaction */
	$sql = $con->prepare('SELECT * FROM users WHERE userId=?');
    $sql->execute(array($userID));
	$info = $sql->fetch();
	$flag = 1 ;
}

if(isset($_GET['id']) AND $flag == 0 AND ! isset($_GET['action']) ){
	$userID = $_GET['id'];
	$sql = $con->prepare('SELECT * FROM users WHERE userId=?');
   $sql->execute(array($userID));
	$info = $sql->fetch();
}else if ($flag == 0 AND ! isset($_GET['action'])) {
	header('Location:index.php');
}

if(isset($_GET['postID']) AND ! isset($_GET['action'])){

	$postID = $_GET['postID'] ;
    $sql = $con->prepare('DELETE FROM posts WHERE postID=?');
    $sql->execute(array($postID));
}

if(isset($_GET['action'])){
    $userID=$_SESSION['userID'];
	$postID=$_GET['postID'];
	$userShare = $_GET['id'];
	$sql = $con->prepare("INSERT INTO posts (postType, postContain,userID,userShare) VALUES ('4', '$postID','$userID','$userShare');");
	$sql->execute();
	$sql = $con->prepare('SELECT * FROM users WHERE userId=?');
    $sql->execute(array($userID));
	$info = $sql->fetch();

	$sql = $con->prepare("SELECT * FROM posts ORDER BY postID DESC LIMIT 1");
	$sql->execute();
	$lastPost = $sql->fetch();
	$newPostID = $lastPost['postID'];
	
	$sql = $con->prepare("INSERT INTO notifactions (type,postID,sender,recevier) VALUES('2',$newPostID,$userID,$userShare)");
	$sql->execute();
    
    $sql = $con->prepare("SELECT * FROM users WHERE userID = ?");
    $sql->execute(array($userShare));
    $shareName = $sql->fetch();
    $num = $shareName['notifactions'] +1 ;
	 $sql = $con->prepare("UPDATE users SET notifactions = ? WHERE userID = ?");
	 $sql->execute(array($num,$userShare));
}

    $sql = $con->prepare('SELECT * FROM avatars WHERE userID = ? ORDER BY avatarID DESC LIMIT 1 ');
    $sql->execute(array($userID));
    $img = $sql->fetch();
    $count = $sql->rowCount();
 


?>
<style>
	

	 .Profile-avatar .img-thumbnail{
    height: 275px;
    width: 417px;
  }
  .gallery .img-thumbnail{
  min-width: 109px;
    height: 100px;
}

.post .pic{
     border-radius: 50%;
    height: 64px;
    margin-left: 20px;
    width: 100px;
}
.post .name {
	margin-left: -20px;
}

.post  .user{
	 color: red;
} 
.date{
	margin-top: 30px;
	margin-left: 10px;
}
.postPic .img-thumbnail{
	height: 440px;
    width: 400px;
}

.editPost a {
	float: right; 
	text-decoration: none;
	color: #FFF ;
}

.uploadAvatar p{
    position: relative;
    top: 6px;
    left: 100px;
     font-weight: bold;
	}

	.sharePost{
		margin-top: 30px;
		border: 2px solid;
		padding: 20px;
	}

	.fa-trash{
	font-size: 20px;
}


</style>

<div class="container-fluid">

     
     <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">

        <?php 

        if($userID == $_SESSION['userID']) {?>
     	 <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-lg-offset-2 col-md-offset-2">
     	 	<div class="panel panel-default">
			 	 <div class="panel-heading">
                       <p>Add new Post</p>
			 	 </div>

			 	 <div class="panel-body">
                      <form action="profile.php?id=<?php echo $_SESSION['userID'] ?>" method="post">
                      	<textarea name = "postContain" class="form-control" placeholder="What's in your mind ?" style="    min-height: 145px;"></textarea> <br>
                      	<button type="submit" class="btn btn-success btn-block">Post</button>
                      	<a href="uploadAvatar.php?action=post" class="btn btn-info btn-block">Add new photo</a>
                      </form>
			 	 </div>

			</div>
     		
     	</div>

     	




	<?php } ?>



     




     <?php 
     $sql2 = $con->prepare('SELECT * FROM posts WHERE userID = ? ORDER BY postID DESC  ');
     $sql2->execute(array($userID));
     $img2 = $sql2->fetchAll();
     $count2 = 0; 

     foreach ($img2 as $img2) { ?>
       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		
			<div class="panel panel-default">
			 	 <div class="panel-heading editPost">
			 	 	<p>Posts 
                     <?php 
                     if($_SESSION['userID'] == $userID) { ?>
			 	 		<a href="profile.php?id=<?php echo $userID ;?>&postID=<?php echo $img2['postID'] ;?>"> <i class="fa fa-trash"> </i> </a>  <?php } ?> </p>

			 	 	
			 	 </div>
			 	 <div class="panel-body post">
                       
			 	 	<div class="row">
			 	 	<?php 
                      
			 	 	if( $count > 0)  echo '<img src="upload/avatar/'. $img['avatarName']. '"class="img-responsive pic col-lg-2 col-md-2">' ;
                    else echo '<img src="upload/avatar/default.jpeg" class="img-responsive ">' ; ?>
                       

                       
                       <h3 class="col-lg-8 col-md-8 name"> <span class="user"> <?php echo $info['userName'] ?> </span>
                         

                         <?php 
                          if      ($img2['postType'] == '1' )echo '<span>Update his profile picture </span>' ;
                          else if ($img2['postType'] == '2' )echo '<span>Add a new photo </span>' ;
                          else if ($img2['postType'] == '3' )echo '<span>Add a new post </span>' ;
                          else if ($img2['postType'] == '4' ) {
                                 if($userID == $img2['userShare']){
                                      echo '<span> Share his post </span>' ;
                                 }

                                 else {
                                 	$sql = $con->prepare("SELECT * FROM users WHERE userID = ?");
                                 	$userID4 = $img2['userShare'] ;
                                 	$sql->execute(array($userID4));
                                 	$shareName = $sql->fetch();
                                 	echo '<span> Share ' .$shareName['userName'] . ' post </span>' ;
                                 }
                            }
                          ?>

                         	
                          <h5 class="date"> <?php echo $img2['postDate'] ?></h5> </h3>

                      
                    </div>

                         
                         <?php 

                          if($img2['postType'] == '1' ){ ?>
			                    <div class="row">


			                    	<div class="col-xs-12 col-sm-12 col-lg-8 col-md-8 col-md-offset-3 col-lg-offset-3 postPic" >
			                    	<?php 
			                      
						 	 	if( $count > 0)  echo '<img src="upload/avatar/'. $img2['postContain']. '"class="img-responsive img-thumbnail ">' ;
			                    else echo '<img src="upload/avatar/default.jpeg" class="img-responsive ">' ; ?>
			                        </div>
			                    </div>  
                         <?php } 


                          else if ($img2['postType'] == '2' ){ ?>
                                     <div class="row">


			                    	<div class="col-xs-12 col-sm-12 col-lg-8 col-md-8 col-md-offset-3 col-lg-offset-3 postPic" >
			                    	<?php 
			                      
						 	 	if( $count > 0)  echo '<img src="upload/avatar/'. $img2['postContain']. '"class="img-responsive img-thumbnail ">' ;
			                    else echo '<img src="upload/avatar/default.jpeg" class="img-responsive ">' ; ?>
			                        </div>
			                    </div>  
                          <?php   }

                          else if ($img2['postType'] == '3' ) { ?>

                          	     <div class="row">
                          	     	<div class="col-xs-12 col-sm-12 col-lg-10 col-md-10 col-md-offset-1 col-lg-offset-1" >
                                          <h3>
                                          	<?php 
						                           $text = $img2['postContain'] ;
						                           $text = explode(" ", $text) ;
						                           $newString=" ";
						                           foreach ($text as $word) {
						                               if(substr($word,0,1) == "@"){
						                                $mention = $con->prepare("SELECT * FROM users WHERE userName = ?");
						                                $mention->execute(array(substr($word,1,strlen($word)-1)));
						                                $mentionName = $mention->fetch();
						                                $newString .="<a href="."profile.php?id=".$mentionName['userID'] . ">" . $mentionName['userName']." " ."</a>" ;

						                               }
						                               else{
						                                 $newString.=$word." " ;
						                               }
						                           }
						                             echo $newString ;


						                           ?>
                                          </h3>
                          	     	</div>

                          	     </div>

                          <?php   } 

                         else if ($img2['postType'] == '4' ) { ?>
                                    
                                    <div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2 sharePost">
                                    	<?php 
                                          $postID = $img2['postContain'] ;
										  $sql = $con->prepare('SELECT * FROM posts WHERE postID = ?');
										  $sql->execute(array($postID));
										  $post = $sql->fetch();
										  $userID5 = $img2['userShare'];
										  $sql = $con->prepare('SELECT * FROM users WHERE userID = ?');
										  $sql->execute(array($userID5));
										  $info5 = $sql->fetch();
										  $sql = $con->prepare('SELECT * FROM avatars WHERE userID = ? ORDER BY avatarID DESC LIMIT 1');
										  $sql->execute(array($userID5));
										  $img5 = $sql->fetch();
										  $count5 = $sql->rowCount();
                                    	?>

                                    	 <div class="row">
									          <?php 
									                      
									          if( $count5 > 0)  echo '<img src="upload/avatar/'. $img5['avatarName']. '"class="img-responsive pic col-lg-2 col-md-2">' ;
									                    else echo '<img src="upload/avatar/default.jpeg" class="img-responsive ">' ; ?>
									                       

									                       
									                       <h3 class="col-lg-8 col-md-8 name"> <span class="user"> <?php echo $info5['userName'] ?> </span>
									                         

									                         <?php 
									                          if      ($post['postType'] == '1' )echo '<span>Update his profile picture </span>' ;
									                          else if ($post['postType'] == '2' )echo '<span>Add a new photo </span>' ;
									                          else if ($post['postType'] == '3' )echo '<span>Add a new post </span>' ;
									                          ?>

									                          
									                          <h5 class="date"> <?php echo $post['postDate'] ?></h5> </h3>

                      
                                        </div>

                                        <?php 

						                          if($post['postType'] == '1' ){ ?>
						                          <div class="row">


						                            <div class="col-xs-12 col-sm-12 col-lg-8 col-md-8 col-md-offset-3 col-lg-offset-3 postPic" >
						                            <?php 
						                            
						                                echo '<img src="upload/avatar/'. $post['postContain']. '"class="img-responsive img-thumbnail ">' ;
						                            ?>
						                              </div>
						                          </div>  
						                         <?php }  

						                          else if ($post['postType'] == '2' ){ ?>
						                                     <div class="row">


						                            <div class="col-xs-12 col-sm-12 col-lg-8 col-md-8 col-md-offset-3 col-lg-offset-3 postPic" >
						                            <?php 
						                            
						                           echo '<img src="upload/avatar/'. $post['postContain']. '"class="img-responsive img-thumbnail ">' ;
						                              ?>
						                              </div>
						                          </div>  
						                          <?php   } 


						                          else if ($post['postType'] == '3' ) { ?>

						                                 <div class="row">
						                                  <div class="col-xs-12 col-sm-12 col-lg-10 col-md-10 col-md-offset-1 col-lg-offset-1" >
						                                          <h3>
						                                            <?php 
											                           $text = $post['postContain'] ;
											                           $text = explode(" ", $text) ;
											                           $newString=" ";
											                           foreach ($text as $word) {
											                               if(substr($word,0,1) == "@"){
											                                $mention = $con->prepare("SELECT * FROM users WHERE userName = ?");
											                                $mention->execute(array(substr($word,1,strlen($word)-1)));
											                                $mentionName = $mention->fetch();
											                                $newString .="<a href="."profile.php?id=".$mentionName['userID'] . ">" . $mentionName['userName']." " ."</a>" ;

											                               }
											                               else{
											                                 $newString.=$word." " ;
											                               }
											                           }
											                             echo $newString ;


						                           ?>
						                                          </h3>
						                                  </div>

						                                 </div>

						                          <?php   } ?>



                                    </div>

                         <?php } ?>
			 	 </div>
			 	 <div class="panel-footer">
			 	 	  <div class="btn-group btn-group-justified">
							  <a class="btn btn-success" onclick="Like('<?php echo $img2['postID'] ?>')">Like <span id="<?php echo 'postID'.$img2['postID']?>"> <?php 
                                             $like = $con->prepare("SELECT * FROM likes WHERE postID = ?");
                                             $like->execute(array($img2['postID']));
                                             echo $like->rowCount();

							     ?> </span></a>
							  <a href="Comment.php?postID=<?php echo $img2['postID'] ?>" class="btn btn-info">Comment</a>
							  <a href="profile.php?id=<?php echo $userID ;?>&postID=<?php echo $img2['postID'] ;?>&action=share" class="btn btn-primary">Share</a>
					</div>
			 	 </div>
			
	</div>
	</div>
     <?php }
	?>


   </div>
	
	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 Profile-avatar">
			<div class="panel panel-default">
			 	 <div class="panel-heading">
			 	 	<p>Profile Picture</p>
			 	 </div>
			 	 <div class="panel-body uploadAvatar">  <?php 
                      
			 	 	if( $count > 0)  {
			 	 		echo '<img src="upload/avatar/'. $img['avatarName']. '"class="img-responsive img-thumbnail">' ;

			 	 		if($userID == $_SESSION['userID'])
			 	 		echo '<a href="uploadAvatar.php"  style="text-decoration: none;"> <P>Change</P></a>';
			 	 	    else{
			 	 	     $followerID = $_SESSION['userID'];
			 	 	    $sql4=$con->prepare("SELECT * FROM followers WHERE userID = ? AND followerID = ? ");
			 	 	    $sql4->execute(array($userID,$followerID));
			 	 	    $count4= $sql4->rowCount();
			 	 	    if($count4 > 0){
			 	 	    echo '<a href="profile.php?id='.$userID .'&unfollower='.$_SESSION['userID'].'"  style="text-decoration: none;"> <P>UnFollow</P></a>';}
			 	 	    else {
			 	 	    	echo '<a href="profile.php?id='.$userID .'&follower='.$_SESSION['userID'].'"  style="text-decoration: none;"> <P>Follow</P></a>';}
			 	 	    }
			 	 	}

                       else {
                       	echo '<img src="upload/avatar/default.jpeg" class="img-responsive img-thumbnail">' ;
                       	if($userID == $_SESSION['userID'])
                       	echo '<a href="uploadAvatar.php"  style="text-decoration: none;"> <P>Change</P></a>';

                       	} ?>
			 	     	
			 	 </div>
			</div>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			<div class="panel panel-default">
			 	 <div class="panel-heading">
			 	 	<p>Pictures</p>
			 	 </div>
			 	 <div class="panel-body gallery">
			 	 	    
			 	 	     <?php  
			 	 	       $sql1 = $con->prepare('SELECT * FROM avatars WHERE userID = ? ORDER BY avatarID DESC LIMIT 4 ');
                           $sql1->execute(array($userID));
                           $img1 = $sql1->fetchAll();

                           

                           foreach ($img1 as $img1) { ?>
                                  <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12"> 
			 	 	   	           <?php   

                                    echo '<a href="gallery.php?id='. $userID . '" >'  ;
			 	 	   	            echo '<img src="upload/avatar/'. $img1['avatarName']. '"class="img-responsive img-thumbnail">' ;
			 	 	   	            echo  '</a>' ;   

			 	 	   	                    ?>
			 	 	              </div>
                   <?php        }
			 	 	     ?>
			 	 	    

			 	 	    
			 	 </div>
			</div>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			<div class="panel panel-default info center">
			 	 <div class="panel-heading">
			 	 	<p>Personal Informations</p>
			 	 </div>
			 	 <div class="panel-body">
			 	 	<ul  class="list-unstyled">
			 	 		<li> <span>Age:</span> <?php echo $info['age'] ?> </li>
			 	 	    <li> <span>City:</span>  <?php echo $info['city'] ?> </li>
			 	 		<li> <span>Relation:</span>  <?php echo $info['relation'] ?> </li>
			 	 	</ul>
			 	 </div>

			 	 
			</div>
	</div>
</div>

<script>

	
	function Like(postID){
		var xhr = new XMLHttpRequest();

		var userID = <?php echo $_SESSION['userID'] ; ?> ;
         var postID= postID ;
        var postID2 = 'postID' + postID ;
		xhr.onreadystatechange = function() {
 			if(xhr.readyState==4 && xhr.status == 200){
                     if(xhr.readyState==4 && xhr.status == 200){
			          document.getElementById(postID2).innerHTML= this.responseText;
			
		   }
 			}
 		}


 		xhr.open("GET","server.php?userID="+userID+"&postID="+postID,true);
 		xhr.send();

	}


	</script>


<?php

 include $tmbl . 'footer.php' ;

?>