
<?php
   
   session_start();
  if(isset($_GET['postID'])){
  include 'init.php';
  include 'contact.php';

  $postID = $_GET['postID'] ;
  $sql = $con->prepare('SELECT * FROM posts WHERE postID = ?');
  $sql->execute(array($postID));
  $post = $sql->fetch();
  $userID = $post['userID'];
  $sql = $con->prepare('SELECT * FROM users WHERE userID = ?');
  $sql->execute(array($userID));
  $info = $sql->fetch();
  $sql = $con->prepare('SELECT * FROM avatars WHERE userID = ? ORDER BY avatarID DESC LIMIT 1');
  $sql->execute(array($userID));
  $img = $sql->fetch();
  $count = $sql->rowCount();
  $userID2 = $_SESSION['userID'];

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
   
  $commentContain = $_POST['commentContain'];
  $sql = $con->prepare("INSERT INTO comments (userID, commentType,commentContain,postID) VALUES ('$userID2','1','$commentContain','$postID')");
  $sql->execute();

  $text = $commentContain ;
  $text = explode(" ", $text) ;
      
       foreach ($text as $word) {
           if(substr($word,0,1) == "@"){
            $comment = $con->prepare("SELECT * FROM users WHERE userName = ?");
            $comment->execute(array(substr($word,1,strlen($word)-1)));
            $commentName = $comment->fetch();
            $sender = $_SESSION['userID'];
            $recevier = $commentName['userID'];
            $num = $commentName['notifactions'] + 1 ;
            $sql = $con->prepare("UPDATE users SET notifactions = ? WHERE userID = ?");
            $sql->execute(array($num,$recevier));
            $sql = $con->prepare("INSERT INTO notifactions (type, sender,recevier,postID) VALUES ('3', '$sender','$recevier','$postID');");
            $sql->execute();

           }
       }



}
   
}






  else {
  	header('Location:login.php');
  
  }


?>

<style>
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
  .panel-footer .pic {
    border-radius: 50%;
    height: 68px;
  }
  .comment .panel-heading{
    background-color: #c3c1c7;
  }
  .comment .panel-heading p {
    float: left;
  }
  .coment .panel-heading span {
    float: right;
  }
  .sharePost{
    margin-top: 30px;
    border: 2px solid;
    padding: 20px;
  }
</style>

<div class="container-fluid">
	

	 <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-md-offset-1 col-lg-offset-1">
		<div class="panel panel-default">
   <div class="panel-heading">
    <p> <?php echo $info['userName'] ?> Post</p>
   </div>
   <div class="panel-body post">
                       
          <div class="row">
          <?php 
                      
          if( $count > 0)  echo '<img src="upload/avatar/'. $img['avatarName']. '"class="img-responsive pic col-lg-2 col-md-2">' ;
                    else echo '<img src="upload/avatar/default.jpeg" class="img-responsive ">' ; ?>
                       

                       
                       <h3 class="col-lg-8 col-md-8 name"> <span class="user"> <?php echo $info['userName'] ?> </span>
                         

                         <?php 
                          if      ($post['postType'] == '1' )echo '<span>Update his profile picture </span>' ;
                          else if ($post['postType'] == '2' )echo '<span>Add a new photo </span>' ;
                          else if ($post['postType'] == '3' )echo '<span>Add a new post </span>' ;
                           else if ($post['postType'] == '4' ) {
                                 if($userID == $post['userShare']){
                                      echo '<span> Share his post </span>' ;
                                 }

                                 else {
                                  $sql = $con->prepare("SELECT * FROM users WHERE userID = ?");
                                  $userID4 = $post['userShare'] ;
                                  $sql->execute(array($userID4));
                                  $shareName = $sql->fetch();
                                  echo '<span> Share ' .$shareName['userName'] . ' post </span>' ;
                                 }
                            }
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
                                                   echo $newString ; ?>
                                          </h3>
                                  </div>

                                 </div>

                          <?php   }

                          else if ($post['postType'] == '4' ) { ?>
                                    
                                    <div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2 sharePost">
                                      <?php 
                                        $postID2 = $post['postContain'] ;
                                        $sql = $con->prepare('SELECT * FROM posts WHERE postID = ?');
                                        $sql->execute(array($postID2));
                                        $post2 = $sql->fetch();
                                        $userID7 = $post['userShare'];
                                        $sql = $con->prepare('SELECT * FROM users WHERE userID = ?');
                                        $sql->execute(array($userID7));
                                        $info5 = $sql->fetch();
                                        $sql = $con->prepare('SELECT * FROM avatars WHERE userID = ? ORDER BY avatarID DESC LIMIT 1');
                                        $sql->execute(array($userID7));
                                        $img5 = $sql->fetch();
                                        $count5 = $sql->rowCount();
                                      ?>

                                       <div class="row">
                            <?php 
                                        
                            if( $count5 > 0)  echo '<img src="upload/avatar/'. $img5['avatarName']. '"class="img-responsive pic col-lg-2 col-md-2">' ;
                                      else echo '<img src="upload/avatar/default.jpeg" class="img-responsive pic col-lg-2 col-md-2 ">' ; ?>
                                         

                                         
                                         <h3 class="col-lg-8 col-md-8 name"> <span class="user"> <?php echo $info5['userName'] ?> </span>
                                           

                                           <?php 
                                            if      ($post2['postType'] == '1' )echo '<span>Update his profile picture </span>' ;
                                            else if ($post2['postType'] == '2' )echo '<span>Add a new photo </span>' ;
                                            else if ($post2['postType'] == '3' )echo '<span>Add a new post </span>' ;
                                            ?>

                                            
                                            <h5 class="date"> <?php echo $post2['postDate'] ?></h5> </h3>

                      
                                        </div>

                                        <?php 

                                      if($post2['postType'] == '1' ){ ?>
                                      <div class="row">


                                        <div class="col-xs-12 col-sm-12 col-lg-8 col-md-8 col-md-offset-3 col-lg-offset-3 postPic" >
                                        <?php 
                                        
                                            echo '<img src="upload/avatar/'. $post2['postContain']. '"class="img-responsive img-thumbnail ">' ;
                                        ?>
                                          </div>
                                      </div>  
                                     <?php }  

                                      else if ($post2['postType'] == '2' ){ ?>
                                                 <div class="row">


                                        <div class="col-xs-12 col-sm-12 col-lg-8 col-md-8 col-md-offset-3 col-lg-offset-3 postPic" >
                                        <?php 
                                        
                                       echo '<img src="upload/avatar/'. $post2['postContain']. '"class="img-responsive img-thumbnail ">' ;
                                          ?>
                                          </div>
                                      </div>  
                                      <?php   } 


                                      else if ($post2['postType'] == '3' ) { ?>

                                             <div class="row">
                                              <div class="col-xs-12 col-sm-12 col-lg-10 col-md-10 col-md-offset-1 col-lg-offset-1" >
                                                      <h3>
                                                        <?php 
                                                           
                                                           echo $post2['postContain'] ;

                                                        ?>
                                                      </h3>
                                              </div>

                                             </div>

                                      <?php   } ?>



                                    </div>

                         <?php } ?>

   </div>

   <div class="panel-footer">
      <div class="container-fluid">

        <form class="row"  action="comment.php?postID=<?php echo $post['postID'] ?>" method="post" >

          <div class="col-lg-10 col-md-10 col-xs-10 col-sm-10">

            <textarea class="form-control" name="commentContain" placeholder="Write a comment" style="resize: none;"></textarea>
            
          </div>

          <div class="col-lg-2 col-md-2 col-xs-2 col-sm-2">
              <button type='submit'class="btn btn-success" style="margin-top: 9px;">Comment</button>
          </div>
          
        </form> <hr style="border-top: 1px solid #1f1414">

           <?php 

            $sql = $con->prepare("SELECT * FROM comments WHERE postID = ?");
            $sql->execute(array($postID));
            $comment = $sql->fetchAll();

            foreach ($comment as $comment ) { ?>

           <div class="row">
             <div class="col-lg-1 col-md-1 col-xs-4 col-sm-4">
               <?php
                  $userID = $comment['userID'];
                  $sql = $con->prepare('SELECT * FROM users WHERE userID = ?');
                  $sql->execute(array($userID));
                  $info = $sql->fetch();
                  $sql = $con->prepare('SELECT * FROM avatars WHERE userID = ? ORDER BY avatarID DESC LIMIT 1');
                  $sql->execute(array($userID));
                  $img = $sql->fetch();
                  $count = $sql->rowCount();

               if($count > 0)  echo  '<img src="upload/avatar/'. $img['avatarName']. '"class="img-responsive pic ">' ;
               else     echo  '<img src="upload/avatar/default.jpeg"class="img-responsive pic ">' ;
              

               ?>

             </div>

             <div class="col-lg-10 col-md-10 col-xs-8 col-sm-8">
                    <div class="panel panel-default comment">
                        <div class="panel-heading">
                            <P style="float: left;">By <?php echo $info['userName'] ?></P>
                            <p style="float: right;"><?php echo $comment['commentDate'] ?> </p>
                        </div>

                        <div class="panel-body">
                           <h4> 
                            <?php 
                           $text = $comment['commentContain'] ;
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
                         </h4>
                        </div>
                    </div>
             </div>




        </div>
              
           <?php }

           ?>



        
      </div>
   </div>
</div>
	</div>

</div>




<?php

 include $tmbl .'footer.php';

?> 
