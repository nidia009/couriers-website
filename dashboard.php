<?php include '../connection.inc.php'; ?>

<?php
session_start();

include 'header.php';

if (!isset($_SESSION['ADMIN_LOGIN'])){
      	header('location: index.php');

  	}
$date = date("Y-m-d H:i:s" , time());


// for deleting tracker
if(isset($_GET['tracker']) && $_GET['tracker'] != '')
{
$tracker_id=filter_var($_GET['tracker'], FILTER_SANITIZE_STRING);
$msg=mysqli_query($con,"DELETE from tracking_details where tracking_number='$tracker_id' LIMIT 1");
if($msg)
{
echo "<script>alert('Tracker deleted successfully');
window.location.href='dashboard.php';
</script>";
}
}


if(isset($_POST['submit'])){

$tnumber = filter_var($_POST['number'], FILTER_SANITIZE_STRING);

$origin = filter_var($_POST['origin'], FILTER_SANITIZE_STRING);
$destination = filter_var($_POST['destination'], FILTER_SANITIZE_STRING);

$transport = filter_var($_POST['transport'], FILTER_SANITIZE_STRING);
$pieces = filter_var($_POST['pieces'], FILTER_SANITIZE_STRING);

$weight = filter_var($_POST['weight'], FILTER_SANITIZE_STRING);
$cubic = filter_var($_POST['cubic'], FILTER_SANITIZE_STRING);
$message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
$status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);

$required_date = $_POST['required_date'];
$required_time = $_POST['required_time'];
$delivery_date = $_POST['delivery_date'];
$delivery_time = $_POST['delivery_time'];
$tdate = $_POST['udate'];
$ttime = $_POST['utime'];

$query = "INSERT INTO `tracking_details` (tracking_number, origin, destination, transport_mode, pieces, weight, cubic, delivery_required_by, estimated_delivery)  VALUES ('$tnumber', '$origin', '$destination', '$transport', '$pieces', '$weight', '$cubic', '$required_date $required_time', '$delivery_date $delivery_time')";
     
   $sql = mysqli_query($con, $query);

   if($sql){
    $que = "INSERT INTO `tracking_update` (tracking_number, message, status, created_at)  VALUES ('$tnumber', '$message', '$status', '$tdate $ttime')";
     
    $sqli = mysqli_query($con, $que);
       @header('location: tracker_info.php?tracker='.$tnumber);

   }else{
       echo "not submitted";
   }

}
?>
<br/>
<br/>
 <div style="padding: 60px 25px 30px 5px;">
 <div class="container d-flex justify-content-center">
   <div class="row">   
<form method="post">
  <div class="form-row">
    <div class="form-group col-md-12 col-xl-12">
      <label for="inputEmail4">Tracker Number</label>
      <input type="text" required="" class="form-control" name="number">
    </div><br>
    <div class="form-group col-md-12 col-xl-12">
      <label for="inputPassword4">Origin Port</label>
      <input type="text"required  class="form-control" name="origin" >
    </div><br>
  
  <div class="form-group col-md-12 col-xl-12">
    <label for="inputAddress">Destination Port</label>
    <input type="text" required class="form-control" name="destination">
  </div><br>
  <div class="form-group col-md-12 col-xl-12">
    <label for="inputAddress2">Transport Mode</label>
    <input type="text" required class="form-control" name="transport">
  </div><br>
  <div class="form-group col-md-12 col-xl-12">
    <label for="inputAddress2">Pieces</label>
    <input type="text" required class="form-control" name="pieces">
  </div><br>
  <div class="form-group col-md-12 col-xl-12">
    <label for="inputAddress2">Weight</label>
    <input type="text" required class="form-control" name="weight">
  </div><br>
  <div class="form-group col-md-12 col-xl-12">
    <label for="inputAddress2">Cubic</label>
    <input type="text" required class="form-control" name="cubic">
  </div><br>
  <div class="form-group col-md-12 col-xl-12">
    <label for="inputAddress2">Delivery Required By - Date</label>
    <input type="date" required class="form-control" name="required_date">
  </div><br>
  <div class="form-group col-md-12 col-xl-12">
    <label for="inputAddress2">Delivery Required By - Time</label>
    <input type="time" required class="form-control" name="required_time">
  </div><br>
  <div class="form-group col-md-12 col-xl-12">
    <label for="inputAddress2">Estimated Delivery - Date</label>
    <input type="date" required class="form-control" name="delivery_date">
  </div><br><br>
  <div class="form-group col-md-12 col-xl-12">
    <label for="inputAddress2">Estimated Delivery - Time</label>
    <input type="time" required class="form-control" name="delivery_time">
  </div><br>
  <div class="form-group col-md-12 col-xl-12">
    <label for="inputAddress2">Message</label>
    <input type="text" required class="form-control" name="message">
  </div><br>
  <div class="form-group col-md-12 col-xl-12">
    <label for="inputAddress2">Status</label>
    <select id="inputState" required="" name="status" class="form-control">
        <option selected>Select Status</option>
        <option value="RECEIVED">Picked Up To Destination</option>
        <option value="IN TRANSIT">Arrived At Destination</option>
        <option value="DELIVERED">DELIVERED</option>
      </select>
  </div><br>
  <div class="form-group col-md-12 col-xl-12>
    <label for="inputAddress2>Time Created</label>
    <input type="time" required class="form-control" name="utime">
  </div><br>
  <div class="form-group col-md-12 col-xl-12">
    <label for="inputAddress2">Date Created</label>
    <input type="date" required class="form-control" name="udate">
  </div><br>
  
  </div>
  <br>

  <button type="submit" name="submit" class="btn btn-primary">Add Tracker</button>
</form>


<br/><br/>
<div class="table-responsive" style="margin-top: 30px;">
   <table class="table table-striped">
  <thead class="thead-light">
    <tr>
      <th scope="col">Trackers</th>
      <th scope="col">Status</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
      <?php
       $sql_fetch = "SELECT tracking_number FROM tracking_details ORDER BY id DESC";
                 $result_fetch = mysqli_query($con, $sql_fetch);
                 while($user = mysqli_fetch_array($result_fetch)) { 
                     $tdi = $user['tracking_number'];
                 $sql_fetch1 = "SELECT status FROM tracking_update WHERE tracking_number = '$tdi' ORDER BY id DESC";
                 $result_fetch2 = mysqli_query($con, $sql_fetch1);
                 $result_fetch1 = mysqli_fetch_assoc($result_fetch2)
                 ?>
    <tr>
      <td style="color: #000;"><?php echo $tdi;?></td>
      <td style="color: #000;">
          <?php 
          if($result_fetch1['status'] == 'RECEIVED'){
          echo "PICKED";
          }
          if($result_fetch1['status'] == 'IN TRANSIT'){
          echo "ARRIVED ";
          }
          if($result_fetch1['status'] == 'DELIVERED'){
          echo "DELIVERED";
          }
          ?> 
      <td style="color: #000;"><a href="update_tracker.php?tracker=<?php echo $tdi;?>"><span class='badge badge-me' style="padding: 8px 10px;background: blue; color: white; cursor: pointer;">UPDATE</span></a> | <a href="dashboard.php?tracker=<?php echo $tdi;?>" onClick="return confirm('Do you really want to delete');"><span class='badge badge-me' style="padding: 8px 10px;background: #a51212; color: white; cursor: pointer;">DELETE</span></a></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
</table>

</div>
</div>
</div>
</div>
<?php include 'footer.php'; ?>