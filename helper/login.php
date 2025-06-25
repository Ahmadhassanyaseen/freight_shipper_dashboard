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
        file_put_contents('store.json', json_encode($response['data']));

        // $_SESSION['shipper_user'] = $response['data'];
    }
    return $response;
}


print_r(json_encode(login($data)));
