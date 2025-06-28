  

  <?php include 'config/config.php'; ?>
  <?php include 'helper/globalHelper.php'; ?>
  <?php include 'components/layout/header.php'; ?>
    <?php include 'components/layout/sidebar.php'; ?>
     
      <div class="flex flex-col flex-1 w-full">
       <?php include 'components/layout/topbar.php'; ?>
        <main class="h-full overflow-y-auto">
          <div class=" px-6 pb-10 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Dashboard
            </h2>
           
            <!-- Cards -->
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
              <!-- Card -->
             <?php 
             $data['email'] = $userData['email'];
             $response = fetchAllShipperLeads($data);
         

            

             $stats = [[
              'title' => 'Total Shipments',
              'value' => count($response),
              'icon' => 'boxes-stacked',
              'color' => 'orange'
             ],
             [
              'title' => 'In Progress Shipments',
              'value' => '0',
              'icon' => 'clock',
              'color' => 'blue'
             ],
             [
              'title' => 'Completed Shipments',
              'value' => '0',
              'icon' => 'check',
              'color' => 'green'
             ],
             [
              'title' => 'Cancelled Shipments',
              'value' => '0',
              'icon' => 'xmark',
              'color' => 'red'
             ],
            ];
              
             foreach ($stats as $stat) {
             include 'components/cards/stats.php'; 
             } ?>
              
            </div>
            <?php
            
          




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
    'vendor_status' => $value['vendor_status_c']
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
