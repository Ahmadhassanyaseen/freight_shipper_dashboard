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
        // file_put_contents('store.json', json_encode($response['data']));

        // $_SESSION['shipper_user'] = $response['data'];
        // setcookie("user", json_encode($response['data']), time() + (86400 * 30), "/");
        $cookieData = json_encode($response['data']);
    $cookieSet = setcookie(
        "user", 
        $cookieData, 
        [
            'expires' => time() + (86400),
            'path' => '/',
            'domain' => '', // current domain
            'secure' => false, // set to true if using HTTPS
            'httponly' => true,
            'samesite' => 'Lax'
        ]
    );
    
    }
    return $response;
}


print_r(json_encode(login($data)));
