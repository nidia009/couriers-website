<?php include 'connection.inc.php'; ?>
<?php

if(isset($_GET['tracker']) && $_GET['tracker'] != ''){

$tracker_num = filter_var($_GET['tracker'], FILTER_SANITIZE_STRING);

$sql = "SELECT * FROM tracking_details WHERE tracking_number ='$tracker_num' LIMIT 1";
  
$result = mysqli_query($con, $sql);
  
$tracker = mysqli_fetch_assoc($result);

if(mysqli_num_rows($result) > 0){

$sql_update = "SELECT * FROM tracking_update WHERE tracking_number ='$tracker_num' ORDER BY id DESC";
$result_update = mysqli_query($con, $sql_update);
$tracker_update = mysqli_fetch_assoc($result_update);

$tracker_number = $tracker['tracking_number'];
$tracker_origin = $tracker['origin'];
$tracker_destination = $tracker['destination'];

$tracker_update_time = $tracker_update['created_at'];
$tracker_status = $tracker_update['status'];


}else{
    echo "<script>
     alert('Tracker information invalid!');
     window.location.href='index.php';
      </script>";
}
}else{
echo "<script>
     alert('Tracker information invalid!');
     window.location.href='index.php';
      </script>";

}

?>
<?php  

include 'header.php'; ?>
<br/>
<br>
<br>
<br>
<br>
<div style="padding: 60px 5px 30px 5px;">
 <div class="container">
   <div class="row">
   <div class="table-responsive">
   <table class="table table-striped">
  <thead class="thead-light">
    <tr>
      <th scope="col">Tracking Number</th>
      <th scope="col">Journey</th>
      <th scope="col">Status Updated</th>
      <th scope="col">Status</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="color: #000;"><?php echo $tracker_number;?></td>
      <td style="color: #000;"><?php echo $tracker_origin;?> to <?php echo $tracker_destination;?></td>
      <td style="color: #000;"><?php echo date("D d F, Y; g:i A", strtotime($tracker_update_time));?></td>
      <td style="color: #000;"><?php echo $tracker_status;?></td>
      <td ><a class="btn btn-success" href="tracking_details.php?tracker=<?php echo $tracker_number;?>"> SEE FULL DETAILS </a></td>
    </tr>
    
  </tbody>
</table>
</table>

</div>
</div>
</div>
</div>

<?php include 'footer.php'; ?>