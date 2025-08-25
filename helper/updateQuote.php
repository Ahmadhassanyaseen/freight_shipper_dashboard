<?php
include '../config/config.php';
$data['id'] = $_POST['id'];
$data['status'] = $_POST['status'];
$data['vendor_id'] = $_POST['vendor_id'];
$data['freight_id'] = $_POST['freight_id'];


$result = updateQuote($data);

if($result['status'] == 'success'){
    echo json_encode($result);
    header('Location: ../profile.php?status=success');
    exit;
    

} else{
   echo json_encode($result);
   header('Location: ../profile.php?status=error');
   exit;
}


