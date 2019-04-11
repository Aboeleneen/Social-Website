<?php

include 'header.php';

?>


	  <div class="panel panel-default">
  
  <div class="panel-heading">
    <p>Users</p>
  </div>

  <div class="panel-body" id="users">
    <?php

      $sql = $con->prepare('SELECT * FROM users');
      $sql->execute();
      $info = $sql->fetchAll();

    ?>
    <div class="row">

      <?php foreach ($info as $info) { ?>
        
      
      <div class="col-sm-6 col-md-4">
        <div class="thumbnail">
          <a href="profile.php?id=<?php echo $info['userID'] ?>&visitor=<?php echo $_SESSION['userID'] ?>">
           <?php
                           $userID = $info['userID'];
                           $sql2 = $con->prepare('SELECT * FROM avatars WHERE userID = ? ORDER BY avatarID DESC LIMIT 1 ');
                           $sql2->execute(array($userID));
                           $img = $sql2->fetch();
                           $count = $sql2->rowCount();

                           if($count > 0 ) echo '<img style="height: 140px;"src="upload/avatar/'. $img['avatarName'] . '">' ;
                           else echo '<img src="upload/avatar/'. 'default.jpeg' . '">' ;
                      ?>
          </a>
          <div class="caption">
            <h4 class="text-center"><strong><?php echo $info['userName'] ?></strong></h4>
            <p class="text-center"><?php echo $info['city']."  ".$info['age'] ?></p>
           <i id="<?php echo 'add'.$info['userID'] ?>"> <button   onclick="add(<?php echo $info['userID'] ; ?>)" class="btn btn-primary" ><i class="fa fa-user-plus"> </i></button> </i> <a href="#" class="btn btn-default" role="button"><i class="fa fa-comments"> </i></a>

         
          </div>
        </div>
      </div>

    <?php } ?>
        </div>
  </div>
</div>



<script>
 
  function add(userID){
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
      if(xhr.readyState==4 && xhr.status == 200){
                     if(xhr.readyState==4 && xhr.status == 200){
                document.getElementById("add"+userID).innerHTML= this.responseText;
      
       }
      }
    }

    xhr.open("GET","error.php?req="+"add"+"&userID="+userID+"&friendID="+<?php echo $_SESSION['userID']
      ?>,true);
    xhr.send();
  }
</script>