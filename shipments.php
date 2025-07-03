


<?php include 'config/config.php'; ?>
<?php include 'helper/globalHelper.php'; ?>
<?php include 'components/layout/header.php'; ?>
    <?php include 'components/layout/sidebar.php'; ?>
     
      <div class="flex flex-col flex-1 w-full">
       <?php include 'components/layout/topbar.php'; ?>
        <main class="h-full overflow-y-auto pb-10">
          <div class=" px-6 pb-10 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700"
            >
              Shipments
            </h2>
           
            
            
            <?php
       

$data['email'] = $_SESSION['shipper_user']['email'];
$response = fetchAllShipperLeads($data);

foreach($response as $key => $value){
  $shipments[] = [
    'id' => $value['id'],
    'name' => $value['name'],
    'quantity' =>$value['freight_box_count_c'],
    'type' => $value['freight_type_c'],
    'tracking_number' => $value['truckerpath_ref_id_c'] ?? 'N/A',
    'pickup' => $value['pickup_address_c'],
    'dropoff' => $value['dropoff_address_c'],
    'amount' => '$' . $value['total_price_c'] ?? '0.00',
    'status' => $value['status_c'] ?? 'Pending',
    'weight' => $value['freight_weight_c'].'lbs',
    'created_at' => $value['date_entered'],
    'mileage' => $value['mileage_c'],
    'addons' => $value['addons_total_c'],
    'fuel' => $value['fuel_c'],
    'tolls' => $value['toll_c'],
    'vendor_status' => $value['vendor_status_c'],
    'distance' => $value['distance_c'],
    'vendor_name' => $value['vendor_name'],
    'vendor_rating' => $value['vendor_rating'],
    'vendor_dot' => $value['vendor_dot'],
    'vendor_fmcsa' => $value['vendor_fmcsa'],
    'vendor_phone' => $value['vendor_phone'],
    'vendor_email' => $value['vendor_email'],
    'deadhead' => $value['deadhead_price_c'],
    'vendor_quotes' => $value['vendor_quotes'] ?? [],

    
  ];
}
            ?>

           <?php include 'components/table/shipment.php'; ?>

           
          </div>
        </main>
      </div>
    </div>
  </body>
</html>
