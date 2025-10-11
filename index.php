  <?php
  $hide_dead = false;

  if(isset($_GET['hide_dead']) && $_GET['hide_dead'] == 'true') {
    $hide_dead = true;
  }
  
  ?>

  <?php include 'config/config.php'; ?>
 
  <?php include 'components/layout/header.php'; ?>
    <?php include 'components/layout/sidebar.php'; ?>
     
      <div class="flex flex-col flex-1 w-full">
       <?php include 'components/layout/topbar.php'; ?>
        <main class="h-full overflow-y-auto">
          <div class=" px-6 pb-10 mx-auto grid">
            <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold my-6 tracking-tight neon-red-header">
             Shipper Dashboard
            </h1>
            <a href="addLoad.php"  class="bgBlue text-white py-2 px-4 rounded cursor-pointer" >Add New Load</a>
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
              
             
             $data['id'] = $userData['id'];
             $response = fetchAllShipperLeads($data);

            
            $stats = [
              [
                  'title' => 'Total Shipments',
                  'value' => count($response),
                  'icon' => 'boxes-stacked',
                  'color' => 'orange',
                  'bgClass' => 'modern-btn-2',
              ],
              [
                  'title' => 'In Progress Shipments',
                  'value' => array_reduce($response, function($carry, $item) {
                      return $carry + (in_array(strtolower($item['status_c']), ['assigned', 'in progress', 'in_progress', 'inprocess']) ? 1 : 0);
                  }, 0),
                  'icon' => 'clock',
                  'color' => 'blue',
                  'bgClass' => 'modern-btn-2',
              ],
              [
                  'title' => 'Completed Shipments',
                  'value' => array_reduce($response, function($carry, $item) {
                      return $carry + (strtolower($item['status_c']) === 'converted' ? 1 : 0);
                  }, 0),
                  'icon' => 'check',
                  'color' => 'green',
                  'bgClass' => 'modern-btn',
              ],
              [
                  'title' => 'Cancelled/Dead Shipments',
                  'value' => array_reduce($response, function($carry, $item) {
                      return $carry + (in_array(strtolower($item['status_c']), ['cancelled', 'dead', 'deleted']) ? 1 : 0);
                  }, 0),
                  'icon' => 'xmark',
                  'color' => 'red',
                  'bgClass' => 'modern-btn',
              ]
          ];  



             foreach ($stats as $stat) {
             include 'components/cards/stats.php'; 
             }
              ?>
              
            </div>
            <div class="flex gap-5 mb-5">
            
            <div class="w-1/2">

            <?php include 'components/cards/chart.php'; ?>
            </div>
            <div class="w-1/2">
            <?php include 'components/cards/chartMain.php'; ?>
            </div>
          </div>
            <?php
            
          





foreach($response as $key => $value){
  if($hide_dead && in_array(strtolower($value['status_c']), ['cancelled', 'dead', 'deleted'])) {
    continue;
  }
  $shipments[] = [
    'id' => $value['id'],
    'name' => $value['name'],
    'quantity' =>$value['freight_pallet_count_c'],
    'type' => $value['freight_type_c'],
    'tracking_number' => $value['opertunity_id_c'] ?? 'N/A',
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
    'vendor_name' => $value['vendor_name'] ?? 'N/A',
    'vendor_rating' => $value['vendor_rating'] ?? 'N/A',
    'vendor_dot' => $value['vendor_dot'] ?? 'N/A',
    'vendor_fmcsa' => $value['vendor_fmcsa'] ?? 'N/A',
    'vendor_phone' => $value['vendor_phone'] ?? 'N/A',
    'vendor_email' => $value['vendor_email'] ?? 'N/A',
    'deadhead' => $value['deadhead_price_c'],
    'vendor_quotes' => $value['vendor_quotes'] ?? [],
    'tp_quotes' => $value['tp_quotes'] ?? [],

    
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
