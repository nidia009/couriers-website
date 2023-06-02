<?php include 'connection.inc.php'; ?>
<?php
include('vendor/autoload.php');


    if(isset($_GET['id']) && $_GET['id'] !=''){

        $tracker_num = mysqli_real_escape_string($con,$_GET['id']);
        $sql_update = "SELECT * FROM tracking_details WHERE tracking_number ='$tracker_num'";
$result_update = mysqli_query($con, $sql_update);
    $check =mysqli_num_rows($result_update);
    if($check>0){
        $tracker=mysqli_fetch_assoc($result_update);
        $tracker_number = $tracker['tracking_number'];
$tracker_origin = $tracker['origin'];
$tracker_destination = $tracker['destination'];
$tracker_pieces = $tracker['pieces'];
$tracker_cubic = $tracker['cubic'];
$tracker_weight = $tracker['weight'];
$tracker_transport = $tracker['transport_mode'];
$tracker_delivery_date = $tracker['estimated_delivery'];
$tracker_required_by = $tracker['delivery_required_by'];

    $html= '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
        <style type="text/css" rel="stylesheet" media="all">
        .border-table td{
            border: 1px solid #000;
            padding: 10px 30px;
            color: black;
            font-size: 14px;
        }
        .container-fluid{
            margin-top: 30px;
            margin-left: 9%;
        }
        td{
            border-collapse: collapse;
            width: 300px;
            text-align: center;
            font-weight: bold;
        }
        img{
            margin-left: 41%;
        }

        </style>
    </head>
    <body>
   
    
    <h4 style="text-align: center;"> DETAILS </h4><br/>
    <div class="container-fluid">
    <table class="border-table">
    <tbody>
    <tr>
    <td><b> HBL Number </b></td>
    <td>'.$tracker_number.' </td>
    </tr>
    <tr>
    <td>Origin Port</td>
    <td>'.$tracker_origin.'</td>
    </tr>
    <tr>
    <td>Destination Port</td>
    <td>'.$tracker_destination.'</td>
    </tr>
    <tr>
    <td>Transport Mode</td>
    <td>'.$tracker_transport.'</td>
    </tr>
    <tr>
    <td>Pieces</td>
    <td>'.$tracker_pieces.'</td>
    </tr>
    <tr>
    <td>Weight</td>
    <td>'.$tracker_weight.'</td>
    </tr>
    <tr>
    <td>Cubic</td>
    <td>'.$tracker_cubic.'</td>
    </tr>
    <tr>
    <td>Delivery Required By</td>
    <td>'.date("D d F, Y; g:i A", strtotime($tracker_required_by)).'</td>
    </tr>
    <tr>
    <td>Estimated Delivery Date</td>
    <td>'.date("D d F, Y; g:i A", strtotime($tracker_delivery_date)).'</td>
    </tr>
    </tbody>
    </table>
    </div>
    </body>
    </html>';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$file = 'tracking-'.time().'.pdf';
$mpdf->Output($file,'D');

    }else{
        die();
    }
}else{
        die();
    }
?>