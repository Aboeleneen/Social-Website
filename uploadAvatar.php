
<?php
   
    session_start();
    if(isset($_SESSION['username'])){
    include 'init.php';
    include 'contact.php'; 
   
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

      $name =  $_FILES['avatar']['name'];
      $type =  $_FILES['avatar']['type'];
      $tmp_name =  $_FILES['avatar']['tmp_name'];
      $size =  $_FILES['avatar']['size'];
      $allowed = array("jpg","jpeg","png","gif");
      $explode = explode(".", $name);
      $fileType = strtolower(end($explode));
      $userID = $_SESSION['userID'];

      if(in_array($fileType, $allowed)){


          $neName = rand(0,1000) . '_' .$name ;
          move_uploaded_file($tmp_name, 'upload/avatar//' .$neName );

          if(isset($_POST['postType'])){
             $stmt = $con->prepare("INSERT INTO posts (userID, postType,postContain) VALUES ('$userID','2','$neName')");
             $stmt->execute();
             header('Location:profile.php?id='.$userID);
          }
          else {
          $stmt = $con->prepare("INSERT INTO avatars (userID, avatarName) VALUES ('$userID', '$neName')");
          $stmt->execute();


          $stmt2 = $con->prepare("INSERT INTO posts (userID, postContain,postType) VALUES ('$userID', '$neName','1')");
          $stmt2->execute();}


          echo '<script type="text/javascript">';
          echo 'setTimeout(function () { swal("KokoBook","upload img is done","success");';
          echo '}, 10);</script>'; 

      }

      else {
          echo '<script type="text/javascript">';
          echo 'setTimeout(function () { swal("KokoBook","this file is not suppoorted","warning");';
          echo '}, 10);</script>'; 
      }   
    
    }
    $sql = $con->prepare('SELECT * FROM avatars WHERE userID = ? ORDER BY avatarID DESC LIMIT 1 ');
    $sql->execute(array($userID));
    $img = $sql->fetch();
    $count = $sql->rowCount();

   ?>

   <style>
   .avatar .img-thumbnail{
     height: 365px;
    width: 417px;
  }
   </style>


<div class="container-fluid avatar">
  
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " >
        <div class="col-md-offset-4 col-sm-4">
          <?php 

          if( $count > 0)  echo '<img src="upload/avatar/'. $img['avatarName']. '"class="img-responsive img-thumbnail">' ;
          else echo '<img src="upload/avatar/default.jpeg" class="img-responsive img-thumbnail">' ;
            
          ?>
          <form action="uploadAvatar.php" method="post" enctype="multipart/form-data">
            <input type="file"  class="form-control" name="avatar">
            <button type="submit" class="btn btn-success btn-block">
             
              <?php 
              if(isset($_GET['action'])) {
                echo 'Post' ; ?>

                <input type="hidden" name="postType">

                <?php

              }
              else echo 'Save';
              ?>
             
           </button>
          </form>
        </div>
      </div>
    </div>

</div>

<?php 

}
  else {
  	header('Location:login.php');
  
  }


?>







<?php

 include $tmbl .'footer.php';

?> 