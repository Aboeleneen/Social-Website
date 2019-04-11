<?php

include 'contact.php';


session_start();

if($_SERVER['REQUEST_METHOD'] == "POST"){
  $userName = $_POST['uname'];
  $firstName = $_POST['fname'];
  $lastName= $_POST['lname'];
  $birthDate = $_POST['birthDate'];
  $relation = $_POST['relation'];
  $gender = $_POST['gender'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $age = $_POST['age'];
  $password = $_POST['pword'];
  $city = $_POST['city'];

  $sql = $con->prepare("INSERT INTO users(userName,firstName,lastName,birthDate,relation,gender,email,phone,age,password,city) VALUES('$userName',' $firstName','$lastName','$birthDate','$relation','$gender','$email','$phone','$age','$password','$city')");
  $sql->execute();
  $sql = $con->prepare("SELECT * FROM users ORDER BY userID DESC");
  $sql->execute();
  $info = $sql->fetch();
  $_SESSION['username']=$userName;
  $_SESSION['userID']=$info['userID'];
 header('Location:index.php?action=login'); 
}

?>



<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
* {
  box-sizing: border-box;
}

body {
  background:url('images/5.jpg');
  background-size: cover;
 
}
.subject {
    color: #000000;
    font-size: 20px;
}
#regForm {
  background-color: #7b2525;
    opacity: .9;
    margin: 100px auto;
    font-family: Raleway;
    padding: 40px;
    width: 50%;
    min-width: 300px;
    position: absolute;
    top: -10px;
    left: 540px;
}

h1 {
  text-align: center;  
  color: #06d8ee;
}

input {
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: Raleway;
  border: 1px solid #aaaaaa;
}

/* Mark input boxes that gets an error on validation: */
input.invalid {
  background-color: #ffdddd;
}

/* Hide all steps by default: */
.tab {
  display: none;
}

button {
  background-color: #4CAF50;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  font-size: 17px;
  font-family: Raleway;
  cursor: pointer;
}

button:hover {
  opacity: 0.8;
}

#prevBtn {
  background-color: #bbbbbb;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;  
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #4CAF50;
}
</style>
<body>

<form id="regForm" action="signup.php" method="post" class="">

  <!-- Circles which indicates the steps of the form: -->
  <div style="text-align:center;margin-top:40px;">
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
  </div>


  <h1>Register</h1>
  <!-- One "tab" for each step in the form: -->
  <div class="tab"> <p class="subject" >Name: </p>
    <p><input class="form-control" placeholder="First name..." oninput="this.className = ''" name="fname"></p>
    <p><input class="form-control" placeholder="Last name..." oninput="this.className = ''" name="lname"></p>
    
  </div>
  <div class="tab"> <p class="subject" >Contact Info: </p>
    <p><input class="form-control"  placeholder="E-mail..." oninput="this.className = ''" name="email" type="email"></p>
    <p><input class="form-control" placeholder="Phone..." oninput="this.className = ''" name="phone"></p>
  </div>
  <div class="tab"> <p class="subject">Personal Info: </p>
    <p><label>City : </label> <select class="form-control" name="city">
       <option value="Alexandria">Alexandria</option>
       <option value="Beheira">Beheira</option>
       <option value="Cairo">Cairo</option>
       <option value="Giza">Giza</option>
       <option value="Kafr El Sheikh">Kafr El Sheikh</option>
       <option value="Luxor">Luxor</option>
       <option value="Monufia">Monufia</option>
       <option value="Port Said">Port Said</option>
    </select></p>
    <p>
    <label>gender:</label>
      <select class="form-control" name="gender">
        <option value="male">Male</option>
        <option value="female">Female</option>
      </select> 
    </p>

    <p>
      <label>Relation:</label>
      <select class="form-control" name="relation">
        <option value="married">Married</option>
        <option value="single">Single</option>
        <option value="friendZone">Friend Zone</option>
        <option value="engaged">engaged</option>
      </select>
    </p>
    
    
      
     
   
  </div>
  <div class="tab"> <p class="subject"> Birthday: </p>
    <p><input class="form-control" placeholder="birthDate" type="date" oninput="this.className = ''" name="birthDate"></p>
    <p><input class="form-control" placeholder="age" oninput="this.className = ''" name="age"></p>
  </div>
  <div class="tab"> <p class="subject" > Login Info: </p>
   <p><input  class="form-control" placeholder="User name..." id="uname" oninput="this.className = ''" onkeyup="myFunction()" name="uname"></p>
    <P id="message"></P>

    <p><input class="form-control"  placeholder="Password..." oninput="this.className = ''" name="pword" type="password"></p>
  </div>
  <div style="overflow:auto;">
    <div style="float:right;">
      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
    </div>
  </div>
  
</form>

<script>
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the crurrent tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}

function myFunction() {
   var xhr = new XMLHttpRequest();
   var userName = document.getElementById('uname').value;

   xhr.onreadystatechange = function() {
      if(xhr.readyState==4 && xhr.status == 200){
                     if(xhr.readyState==4 && xhr.status == 200){
                document.getElementById('message').innerHTML= this.responseText;
       }
      }
    }

    xhr.open("GET","error.php?userName="+userName,true);
    xhr.send();
   
}
</script>

</body>
</html>
