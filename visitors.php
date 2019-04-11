
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




	<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-lg-offset-1 col-md-offset-1 " >
		 <div class="panel panel-default">

       <div class="panel-heading">
           <?php 
            $action = $_GET['action'];
            if($action == 'visit') echo '<p>Visitors</p>' ;
            else if ($action == 'follow') echo '<p>Followers</p>' ;
            else if ($action == 'notify') echo '<p> Notifactions </p>'
            

           ?>
           
       </div> 

       <div class="panel-body">
            <?php
               $userID = $_SESSION['userID'];
               
               if($action == 'visit'){
               $sql = $con->prepare("SELECT * FROM visitors WHERE userID = ? ORDER BY id DESC ");
               $sql->execute(array($userID));
               $user = $sql->fetchAll();
                }

               else if($action == 'follow'){
                $sql = $con->prepare("SELECT * FROM followers WHERE userID = ?");
               $sql->execute(array($userID));
               $user = $sql->fetchAll();
                } ?>

               <div class="row"> <?php 
                if($action == 'visit' || $action == 'follow'){
               foreach ($user as $user) {
                 if($action == 'visit'){  $userID = $user["visitorID"]; }
                else if($action == 'follow'){  $userID = $user["followerID"]; }
                
                 $sql = $con->prepare("SELECT * FROM users WHERE userID = ?");
                 $sql->execute(array($userID));
                 $info = $sql->fetch();  ?>
            
               <div class="col-sm-6 col-md-4">
                  <div class="thumbnail">
                    <a href="profile.php?id=<?php echo $info['userID'] ?>&visitor=<?php echo $_SESSION['userID'] ?>">
                      <?php

                           $sql2 = $con->prepare('SELECT * FROM avatars WHERE userID = ? ORDER BY avatarID DESC LIMIT 1 ');
                           $sql2->execute(array($userID));
                           $img = $sql2->fetch();
                           $count = $sql2->rowCount();

                           if($count > 0 ) echo '<img style="height: 200px;"src="upload/avatar/'. $img['avatarName'] . '">' ;
                           else echo '<img src="upload/avatar/'. 'default.jpeg' . '">' ;
                      ?>
                    
                    </a>
                    <div class="caption">
                      <h4 class="text-center"><strong><?php echo $info['userName'] ?></strong></h4>
                      <p class="text-center"><?php echo $info['city']."  ".$info['age'] ?></p>
                      <p class="text-center"><a href="#" class="btn btn-primary" role="button"><i class="fa fa-user-plus"> </i></a> <a href="#" class="btn btn-default" role="button"><i class="fa fa-comments"> </i></a></p>
                    </div>
                  </div>
                </div>

             <?php  } }
                else if ($action == 'notify'){ ?>
                  
                    <?php 
                    $sql = $con->prepare("SELECT * FROM notifactions WHERE recevier = ? ORDER BY id DESC");
                    $sql->execute(array($_SESSION['userID']));
                    $notifactions = $sql->fetchAll();
                    foreach ($notifactions as $notifaction) {

                           $sql = $con->prepare("SELECT * FROM users WHERE userID = ? ");
                           $sender = $notifaction['sender'];
                           $sql->execute(array($sender));
                           $sender = $sql->fetch();
                           $sql = $con->prepare(" UPDATE users SET notifactions = ? WHERE userID = ?");
                           $sql->execute(array(0,$_SESSION['userID']));
                          /* $sql = $con->prepare(" DELETE FROM notifactions WHERE recevier = ? ");
                           $userID = $_SESSION['userID']; 
                           $sql->execute(array($userID));*/  ?>
                           <?php if($notifaction['type']  == '1'){ ?>
                             <div class="alert alert-danger" role="alert"> <?php  
                          echo '<p class="alert-link" >'.$sender['userName'].' mentioned you in a ' . '<a href="comment.php?postID='.$notifaction['postID'] .'"'.'> Post </a>' .'</p>'?>
                           </div> 
                     <?php    }  
                         else if ($notifaction['type'] == '2'){ ?>
                             <div class="alert alert-success" role="alert"> <?php  
                          echo '<p class="alert-link" >'.$sender['userName'].' Share your ' . '<a href="comment.php?postID='.$notifaction['postID'] .'"'.'> Post </a>' .'</p>'?>
                           </div> 
                     <?php    }
                     else if ($notifaction['type'] == '3'){ ?>
                             <div class="alert alert-info" role="alert"> <?php  
                          echo '<p class="alert-link" >'.$sender['userName'].' mentioned you in a comment in  ' . '<a href="comment.php?postID='.$notifaction['postID'] .'"'.'> Post </a>' .'</p>'?>
                           </div> 
                     <?php    }
                     else if ($notifaction['type'] == '4'){ ?>
                             <div class="alert alert-warning" role="alert"> <?php  
                          echo '<p class="alert-link" >'.'<a href="profile.php?id='.$sender['userID'].'"> '.$sender['userName'] . '</a>' . '  had followed you' . '</p>' ?>
                           </div> 
                     <?php    }
                     else if ($notifaction['type'] == '5'){ ?>
                             <div id="<?php echo $notifaction['id'] ?>" class="alert alert-warning" role="alert"> <?php  
                          echo '<p class="alert-link" >'.'<a href="profile.php?id='.$sender['userID'].'"> '.$sender['userName'] . '</a>' . '  send you a friend request' .'     '.'  <button onclick="accept('.$sender['userID'].','.$_SESSION['userID'].','.$notifaction['id'].')" class="btn btn-primary" > Accept </button>' .'</p>' ?>
                           </div> 
                     <?php    }
                    }

                    ?>
               

             <?php   }



             ?>
               </div>

            
       </div>
       
     </div>
	</div>

	<script>
   

        function accept(sender,recevier,notifaction) {
      var xhr = new XMLHttpRequest();
   
   xhr.onreadystatechange = function() {
      if(xhr.readyState==4 && xhr.status == 200){
                 
                document.getElementById(notifaction).innerHTML= this.responseText;
       
      }
    }

    xhr.open("GET","error.php?accept="+"add"+"&sender="+sender+"&recevier="+recevier,true);
    xhr.send();
   
} 
  </script>






<?php

 include $tmbl .'footer.php';

?> 
