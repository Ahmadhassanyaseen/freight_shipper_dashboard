  

  <?php include 'config/config.php'; ?>
 
  <?php include 'components/layout/header.php'; ?>
    <?php include 'components/layout/sidebar.php'; ?>
     
      <div class="flex flex-col flex-1 w-full">
       <?php include 'components/layout/topbar.php'; ?>
        <main class="h-full overflow-y-auto">
          <div class=" px-6 pb-10 mx-auto grid">
            <div class="flex items-center justify-between mb-6">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-white "
            >
             Shipper Dashboard
            </h2>
            <a href="addLoad.php"  class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded cursor-pointer" >Add New Load</a>
            </div>
           
            <!-- Cards -->
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
              <!-- Card -->
              <?php
if (isset($_COOKIE["user"])) {
    $userData = json_decode($_COOKIE["user"], true);
} else {
    $userData = [];
}
?>

             <?php 
             
             $data['email'] = $userData['email'];
             $response = fetchAllShipperLeads($data);

            //  print_r($response);
         

            

            //  $stats = [[
            //   'title' => 'Total Shipments',
            //   'value' => count($response),
            //   'icon' => 'boxes-stacked',
            //   'color' => 'orange'
            //  ],
            //  [
            //   'title' => 'In Progress Shipments',
            //   'value' => '0',
            //   'icon' => 'clock',
            //   'color' => 'blue'
            //  ],
            //  [
            //   'title' => 'Completed Shipments',
            //   'value' => '0',
            //   'icon' => 'check',
            //   'color' => 'green'
            //  ],
            //  [
            //   'title' => 'Cancelled Shipments',
            //   'value' => '0',
            //   'icon' => 'xmark',
            //   'color' => 'red'
            //  ],
            // ];
            $stats = [
              [
                  'title' => 'Total Shipments',
                  'value' => count($response),
                  'icon' => 'boxes-stacked',
                  'color' => 'orange'
              ],
              [
                  'title' => 'In Progress Shipments',
                  'value' => array_reduce($response, function($carry, $item) {
                      return $carry + (in_array(strtolower($item['status_c']), ['assigned', 'in progress', 'in_progress', 'inprocess']) ? 1 : 0);
                  }, 0),
                  'icon' => 'clock',
                  'color' => 'blue'
              ],
              [
                  'title' => 'Completed Shipments',
                  'value' => array_reduce($response, function($carry, $item) {
                      return $carry + (strtolower($item['status_c']) === 'completed' ? 1 : 0);
                  }, 0),
                  'icon' => 'check',
                  'color' => 'green'
              ],
              [
                  'title' => 'Cancelled/Dead Shipments',
                  'value' => array_reduce($response, function($carry, $item) {
                      return $carry + (in_array(strtolower($item['status_c']), ['cancelled', 'dead', 'deleted']) ? 1 : 0);
                  }, 0),
                  'icon' => 'xmark',
                  'color' => 'red'
              ]
          ];  



             foreach ($stats as $stat) {
             include 'components/cards/stats.php'; 
             } ?>
              
            </div>
            <?php
            
          





foreach($response as $key => $value){
  $shipments[] = [
    'id' => $value['id'],
    'name' => $value['name'],
    'quantity' =>$value['freight_box_count_c'],
    'type' => $value['freight_type_c'],
    'tracking_number' => $value['truckerpath_ref_id_c'] ?? 'N/A',
    'pickup' => $value['pickup_address_c'],
    'pickup_date' => $value['pickup_date_c'],
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
