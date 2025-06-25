<?php
include '../config/config.php';
$data = [
    "email" => $_POST['email'],
    "password" => $_POST['password']
];
function login($data){
    $data["method"] = "shipperLogin";
    $response = curlRequest($data);
    if($response['status'] == "success"){
        $_SESSION['shipper_user'] = $response['data'];
    }
    return $response;
}


print_r(json_encode(login($data)));
