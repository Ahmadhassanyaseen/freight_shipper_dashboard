
<?php include 'config/config.php'; ?>
<?php include 'components/layout/header.php'; ?>
    <?php include 'components/layout/sidebar.php'; ?>
     
      <div class="flex flex-col flex-1 w-full">
       <?php include 'components/layout/topbar.php'; ?>
        <main class="h-full overflow-y-auto pb-10">
          <div class=" px-6 pb-10 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Shipments
            </h2>
           
            
            
            <?php
       

$data['email'] = $_SESSION['shipper_user']['email'];
$response = fetchAllShipperLeads($data);

foreach($response as $key => $value){
  $shipments[] = [
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
