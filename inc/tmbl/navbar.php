<?php
    

    include 'contact.php';
  
    $userID = $_SESSION['userID'];
    $sql = $con->prepare('SELECT * FROM avatars WHERE userID = ? ORDER BY avatarID DESC LIMIT 1 ');
    $sql->execute(array($userID));
    $img = $sql->fetch();
    $count = $sql->rowCount();

         
?>

<meta charset="utf-8">
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Brand</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
      <form class="navbar-form navbar-left" action="searchName.php" method="post">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search" name="searchName">
        </div>
        <button type="submit" class="btn btn-success">Search <i class="fa fa-search"></i></button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Chat <i class="fa fa-comments"></i> </a>  </li> 
        <li><a href="index.php">Home <i class="fa fa-home"></i> </a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">

          
            <?php 
              if( $count > 0) {
               echo $_SESSION['username']."  ". '<img style="height: 35px ; width: 35px ; border-radius: 50%; display:inline" src="upload/avatar/'. $img['avatarName'] . '">' ; 
              } 
              else {
                  echo $_SESSION['username']."  ". '<img style="height: 35px ; width: 35px ; border-radius: 50%; display:inline" src="upload/avatar/'. 'default.jpeg' . '">' ; 
            }

            ?>


            <span class="caret"></span></a>
          <ul class="dropdown-menu">
              <li><a href="profile.php?id=<?php echo $userID;  ?>"> <i class="fa fa-user"></i> Profile</a></li> 
            <li><a href="edit.php?id=<?php echo $userID;  ?>""><i class="fa fa-edit"></i> Edit Profile </a></li>
          
            <li role="separator" class="divider"></li>
            <li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>