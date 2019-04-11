<div class="panel panel-default">
 	 <div class="panel-heading">
 	 	<p>Search Panel</p>
 	 </div>
 	 <div class="panel-body">
 	 	<div class="container-fluid">
 	 		<form action="searchPanel.php" method="post">
 	 			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
 	 				<label>Form</label>
 	 				<select name="minAge"class="form-control">
 	 					<?php 

 	 					for($i=10;$i<100;$i++){?>
                             <option value="<?php echo $i ?>"><?php echo $i ?></option>
 	 				<?php	} ?>
  	 					
 	 					
 	 				</select> <br>

 	 				<label>To</label>
 	 				<select name="maxAge" class="form-control">
 	 					<?php 

 	 					for($i=10;$i<100;$i++){?>
                             <option value="<?php echo $i ?>"><?php echo $i ?></option>
 	 				<?php	} ?>
 	 				</select>
 	 			</div>

 	 			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
 	 				<label>City</label>
 	 				<select name="city" class="form-control">
 	 					<option value="Alexandria">Alexandria</option>
				       <option value="Beheira">Beheira</option>
				       <option value="Cairo">Cairo</option>
				       <option value="Giza">Giza</option>
				       <option value="Kafr El Sheikh">Kafr El Sheikh</option>
				       <option value="Luxor">Luxor</option>
				       <option value="Monufia">Monufia</option>
				       <option value="Port Said">Port Said</option>
 	 				</select> <br>

 	 				<label>RelationShip</label>
 	 				<select name="relation" class="form-control">
 	 					<option value="single">single </option>
 	 					<option value="married">married </option>
 	 					<option value="friendZone">Friend Zone </option>
 	 					<option value="engaged">married </option>
 	 				</select>
 	 			</div> 

 	 			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
 	 				<br>
 	 				<button type="submit" class="btn btn-success btn-block"> Search  <i class="fa fa-search"></i></button>
 	 			</div>
 	 		</form>
 	 	</div>
 	 </div>
</div>