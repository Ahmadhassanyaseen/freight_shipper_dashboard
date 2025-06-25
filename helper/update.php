<?php
include '../config/config.php';




if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    
    $data = [
        "email" => $_POST['email'],
        "user_name" => $_POST['user_name'],
        "password" => $_POST['new_password'],
       
    ];

    $result = updateShipper($data);
     
    if($result['status'] == 'success'){
        $_SESSION['shipper_user']['name'] = $data['user_name'];
        echo json_encode($result);
        header('Location: ../profile.php?status=success');
        exit;
        

    } else{
       echo json_encode($result);
       header('Location: ../profile.php?status=error');
       exit;
    }

    
}
