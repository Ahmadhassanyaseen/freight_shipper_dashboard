<?php
include '../../config/config.php';
$data['id'] = $_POST['id'];
$result = deleteShipment($data);

if($result['status'] == 'success'){
    echo json_encode($result);
   
    exit;
    

} else{
   echo json_encode($result);
 
   exit;
}


?>