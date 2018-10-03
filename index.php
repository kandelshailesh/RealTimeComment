<?php 
session_start();
if(isset($_SESSION['username']))
{
	header("location:index1.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<title></title>
</head>
<body>
<div class="panel panel-default">
	<div class="panel-body">
		<button style="margin-left:13px;" data-toggle="modal" data-target="#login"  class="btn btn-success col-md-auto pull-right">Login</button>
		<div class="modal fade" id="login" role="dialog">
    <div style="width:250px;" class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div  style="background-color:red;" class="modal-header">
        	          <h4 class="modal-title">Credentials</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>
        <div style="background-color: lightyellow; height: 230px;" class="modal-body">
         <form onsubmit="return validate()" action="" method="post">
   
      <input class="form-control" type="text" style="padding:5px; margin-left: 3px;" placeholder="Enter Username" name="uname" id="uname" required>
<br><br/>
      <input class="form-control" style="padding:5px; margin-left: 3px;" type="password" placeholder="Enter Password" name="psw" id="psw" required>

<span style="display: none; margin-left: 15px; color:red;" id="error">Invalid Username or Password </span>
        
   <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>

          <button style="margin-left:10px;" class="btn btn-success " name="submit" type="submit">Login</button>
</form>

        </div>
        </div>
      </div>
      
    </div>
  </div>
  
		<button style="margin-left:13px;" data-toggle="modal" data-target="#register" class=" btn btn-warning col-md-auto pull-right">Register</button>
		<div class="modal fade" id="register" role="dialog">
    <div style="width:250px;" class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div  style="background-color:red;" class="modal-header">
        	          <h4 class="modal-title">Credentials</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>
        <div style="background-color: lightyellow; height: 330px;" class="modal-body">
         <form onsubmit="return validate()" action="" method="post">
   <input style="padding:5px; border:1px solid lightblue; " class=" form-control" type="text" id="fname" placeholder="Enter Givenname" name="fname" required>
   <br>
   <input style="padding:5px; border:1px solid lightblue; " class=" form-control" type="text" id="lname" placeholder="Enter Lastname" name="lname" required>
   <br>

      <input class="form-control" type="text" style=" border:1px solid lightblue; padding:5px;" placeholder="Enter Username" name="uname" id="uname" required>
<br>
      <input class="form-control" style=" border:1px solid lightblue;padding:5px;" type="password" placeholder="Enter Password" name="psw" id="psw" required>

<span style="display: none; margin-left: 15px; color:red;" id="error1">Username already exists</span>
<br>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>

     <button style="margin-left:10px;" class="btn btn-success " name="submit1" type="submit">Register</button>
</form>

        </div>
        </div>
      </div>
      
    </div>
  </div>

	</div>
</div>



<?php
if(isset($_POST["submit1"]))
{
$conn = mysqli_connect("localhost", "root", "", "Comment");
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$uname=$_POST['uname'];
$pass=$_POST['psw'];
$queryuser=mysqli_query($conn,"select * from `user` where `Username`='$uname'");
$rowcount=mysqli_num_rows($queryuser);

if($rowcount == 0)
  { 
   $insertuser=mysqli_query($conn,"INSERT INTO `user`( `Firstname`, `Lastname`, `Username`, `Password`) VALUES ('$fname','$lname','$uname','$pass')");
}
  else
  {?> 
    <script>
      $('#register').modal('show');
      $('#error1').show();

    </script>
  <?php }
}?>
<?php 
if(isset($_POST["submit"]))
{
$conn = mysqli_connect("localhost", "root", "", "Comment");
$uname=$_POST['uname'];
$pass=$_POST['psw'];
$queryuser=mysqli_query($conn,"select * from `user` where `Username`='$uname'");
$rowcount=mysqli_num_rows($queryuser);
$queryresult=mysqli_fetch_array($queryuser);
if($rowcount == 1)
  { 
   $_SESSION['username']=$queryresult['Username'];
   $_SESSION['userid']=$queryresult['UserID'];
   $_SESSION['firstname']=$queryresult['Firstname'];
   $_SESSION['lastname']=$queryresult['Lastname'];
      ?>
       <script>
        window.location="index1.php";
      </script> 
}
  else
  {?> 
    <script>
      $('#login').modal('show');
      $('#error').show();

    </script>
  <?php }
}?>

</body>

</html>