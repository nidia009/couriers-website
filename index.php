<?php 
include '../connection.inc.php';
include 'header.php';
?>

<?php
session_start();

$date = date("Y-m-d H:i:s" , time());
if(isset($_POST['submit'])){

$uemail = filter_var($_POST['email'], FILTER_SANITIZE_STRING);

$upassword = $_POST['password'];

$decode = md5($upassword);

   $sql = "SELECT * FROM tracking_admin WHERE email = '$uemail' and password = '$upassword' LIMIT 1";
  
$result = mysqli_query($con, $sql);



   if(mysqli_num_rows($result) > 0){
    
        $_SESSION['ADMIN_LOGIN'] = $uemail;
       // header('location: dashboard.php');
        echo "<script> 
       window.location.href= 'dashboard.php';
       </script>";

   }else{
        echo "
       <script> alert('Invalid credientials!');
       window.location.href=window.location.href;
       </script>
       ";
   }

}

?>

<br/>
<br/>
<br/>
<br/>

 <div style="padding: 60px 25px 30px 5px;">
 <div class="container">
   <div class="row">   
<form method="post">
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="inputEmail4">Username:</label>
      <input type="text" class="form-control" name="email" required>
    </div>
    <div class="form-group col-md-12">
      <label for="inputPassword4">Password</label>
      <input type="password" class="form-control" name="password" required>
    </div>
  
  
  </div>
  <br>
  <button type="submit" name="submit" class="btn btn-primary">Login</button>
</form>

</div>
</div>
</div>









<?php 
include 'footer.php';
?>


