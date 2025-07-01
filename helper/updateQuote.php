<?php
include '../config/config.php';
$data['id'] = $_POST['id'];
$data['status'] = $_POST['status'];

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


