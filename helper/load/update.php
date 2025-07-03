<?php
include '../../config/config.php';

$data['id'] = $_POST['id'];
$data['pickup_address'] = $_POST['pickup_address'];
$data['dropoff_address'] = $_POST['drop_address'];
$data['pickup_time'] = $_POST['pickup_time'];
$data['pickup_date'] = $_POST['pickup_date'];
$data['dropoff_time'] = $_POST['dropoff_time'];
$data['dropoff_date'] = $_POST['dropoff_date'];
$data['vehicle_type'] = $_POST['vehicle_type'];
$data['freight_weight'] = $_POST['freight_weight'];
$data['freight_type'] = $_POST['freight_type'];
$data['freight_length'] = $_POST['freight_length'];
$data['freight_width'] = $_POST['freight_width'];
$data['freight_height'] = $_POST['freight_height'];
$data['freight_pallet_count'] = $_POST['freight_pallet_count'];
$data['freight_box_count'] = $_POST['freight_box_count'];
$data['freight_description'] = $_POST['freight_description'];
$data['addons_total'] = $_POST['addons_total'];
$data['addons'] = $_POST['addons'];
$data['shipper_email'] = $_POST['shipper_email'];
$data['shipper_phone'] = $_POST['shipper_phone'];
$data['shipper_first_name'] = $_POST['shipper_first_name'];
$data['shipper_last_name'] = $_POST['shipper_last_name'];
$data['shipper_name'] = $_POST['shipper_first_name'] . ' ' . $_POST['shipper_last_name'];
$data['name'] = $_POST['shipper_first_name'] . ' ' . $_POST['shipper_last_name'];
$data['shipper_address'] = $_POST['shipper_address'];

$response = updateLoad($data);
// print_r($response);
if($response['status'] == 'success'){
    echo json_encode(['status' => 'success']);
    exit;
}else{
    echo json_encode(['status' => 'error']);
    exit;
}
