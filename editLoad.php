<?php include 'helper/globalHelper.php'; ?>
<?php include 'config/config.php'; ?>
<?php include 'components/layout/header.php'; ?>
    <?php include 'components/layout/sidebar.php'; ?>

    <?php
    $shipment = fetchShipmentById(['id' => $_GET['id']]);
    // print_r($shipment);
    $addOns = explode(',', $shipment['addons']);
    ?>

    
     
      <div class="flex flex-col flex-1 w-full">
       <?php include 'components/layout/topbar.php'; ?>
        <main class="h-full overflow-y-auto pb-10">
          <div class="container px-6 pb-10 mx-auto grid">
          <h1 class="text-3xl font-bold my-6 tracking-tight neon-red-header">
              Edit Load
            </h1>
           
            
            <form id="loadForm" class="space-y-6">
                <input type="hidden" name="id" value="<?= $shipment['id'] ?>">
        <!-- Freight Information Section -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md text-white">
            <h3 class="text-lg font-medium  mb-4 text-gray-700 dark:text-white">Freight Information</h3>
            
          
        <div class=" ">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="pickup_address" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Pickup Address *</label>
                    <div class="relative">
                        <input type="text" id="pickup_address" name="pickup_address" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm text-gray-700 dark:text-white" required="" autocomplete="off" placeholder="Pickup Address" value="<?= htmlspecialchars($shipment['pickup_address']) ?>" disabled>
                       
                    </div>
                </div>
                <div>
                    <label for="drop_address" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Drop-off Address *</label>
                    <div class="relative">
                        <input type="text" id="drop_address" name="drop_address" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm text-gray-700 dark:text-white" required="" autocomplete="off" placeholder="Drop-off Address" value="<?= htmlspecialchars($shipment['dropoff_address']) ?>" disabled>
                      
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="pickup_time" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Pickup Time *</label>
                    <input type="time" id="pickup_time" name="pickup_time" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm text-gray-700 dark:text-white" required="" autocomplete="off" value="<?= htmlspecialchars($shipment['pickup_time']) ?>">
                </div>
                <div>
                    <label for="pickup_date" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Pickup Date *</label>
                    <input type="date" id="pickup_date" name="pickup_date" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm text-gray-700 dark:text-white" required="" autocomplete="off" value="<?= date('Y-m-d', strtotime($shipment['pickup_date'])) ?>">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="dropoff_time" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Dropoff Time *</label>
                    <input type="time" id="dropoff_time" name="dropoff_time" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm text-gray-700 dark:text-white" required="" autocomplete="off" value="<?= htmlspecialchars($shipment['dropoff_time']) ?>">
                </div>
                <div>
                    <label for="dropoff_date" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Dropoff Date *</label>
                    <input type="date" id="dropoff_date" name="dropoff_date" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm text-gray-700 dark:text-white" required="" autocomplete="off" value="<?= date('Y-m-d', strtotime($shipment['dropoff_date'])) ?>">
                </div>
            </div>
        </div>
        <div class=" ">
            <div class="mb-4">
                <label for="vehicle_type" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Vehicle Type *</label>
                <select id="vehicle_type" name="vehicle_type" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm text-gray-700 dark:text-white" required="">
                    <option value="" class="text-gray-700">Select Vehicle Type</option>
                    <option value="stepdeck" class="text-gray-700" <?php if($shipment['carrier_vehicle_type'] == 'stepdeck') echo 'selected'; ?>>Step Deck</option>
                    <option value="power only" class="text-gray-700" <?php if($shipment['carrier_vehicle_type'] == 'power only') echo 'selected'; ?>>Power Only</option>
                    <option value="b-train" class="text-gray-700" <?php if($shipment['carrier_vehicle_type'] == 'b-train') echo 'selected'; ?>>B-Train</option>
                    <option value="auto carrier" class="text-gray-700" <?php if($shipment['carrier_vehicle_type'] == 'auto carrier') echo 'selected'; ?>>Auto Carrier</option>
                    <option value="reefer" class="text-gray-700" <?php if($shipment['carrier_vehicle_type'] == 'reefer') echo 'selected'; ?>>Reefer</option>
                    <option value="flatbed" class="text-gray-700" <?php if($shipment['carrier_vehicle_type'] == 'flatbed') echo 'selected'; ?>>Flatbed</option>
                    <option value="van" class="text-gray-700" <?php if($shipment['carrier_vehicle_type'] == 'van') echo 'selected'; ?>>Van</option>
                </select>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="freight_weight" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Weight (lbs) *</label>
                    <input type="number" id="freight_weight" name="freight_weight" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm text-gray-700 dark:text-white" min="1" required="" value="<?= htmlspecialchars($shipment['freight_weight']) ?>">
                </div>
                <div>
                    <label for="freight_type" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Freight Type *</label>
                    <select id="freight_type" name="freight_type" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm text-gray-700 dark:text-white" required="">
                        <option value="" class="text-gray-700">Select Freight Type</option>
                        <option value="general" class="text-gray-700" <?php if($shipment['freight_type'] == 'general') echo 'selected'; ?>>General Cargo</option>
                        <option value="perishables" class="text-gray-700" <?php if($shipment['freight_type'] == 'perishables') echo 'selected'; ?>>Perishables</option>
                        <option value="non_hazardous" class="text-gray-700" <?php if($shipment['freight_type'] == 'non_hazardous') echo 'selected'; ?>>Non-Hazardous</option>
                        <option value="bulk" class="text-gray-700" <?php if($shipment['freight_type'] == 'bulk') echo 'selected'; ?>>Bulk</option>
                        <option value="heavy" class="text-gray-700" <?php if($shipment['freight_type'] == 'heavy') echo 'selected'; ?>>Heavy / Oversized</option>
                        <option value="vehicles" class="text-gray-700" <?php if($shipment['freight_type'] == 'vehicles') echo 'selected'; ?>>Vehicles</option>
                        <option value="high_value" class="text-gray-700" <?php if($shipment['freight_type'] == 'high_value') echo 'selected'; ?>>High-Value</option>
                        <option value="specialized" class="text-gray-700" <?php if($shipment['freight_type'] == 'specialized') echo 'selected'; ?>>Specialized</option>
                        <option value="misc" class="text-gray-700" <?php if($shipment['freight_type'] == 'misc') echo 'selected'; ?>>Miscellaneous</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label for="freight_length" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Length (in) *</label>
                    <input type="number" id="freight_length" name="freight_length" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm text-gray-700 dark:text-white" min="1" required="" value="<?= htmlspecialchars($shipment['freight_length']) ?>">
                </div>
                <div>
                    <label for="freight_width" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Width (in) *</label>
                    <input type="number" id="freight_width" name="freight_width" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm text-gray-700 dark:text-white" min="1" required="" value="<?= htmlspecialchars($shipment['freight_width']) ?>">
                </div>
                <div>
                    <label for="freight_height" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Height (in) *</label>
                    <input type="number" id="freight_height" name="freight_height" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm text-gray-700 dark:text-white" min="1" required="" value="<?= htmlspecialchars($shipment['freight_height']) ?>">
                </div>
            </div>

        </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="freight_pallet_count" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Number of Pallets</label>
                    <input type="number" id="freight_pallet_count" name="freight_pallet_count" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm text-gray-700 dark:text-white" min="1" max="10000" value="<?= htmlspecialchars($shipment['freight_pallet_count']) ?>" required="">
                </div>
                <div>
                    <label for="freight_box_count" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Number of Boxes</label>
                    <input type="number" id="freight_box_count" name="freight_box_count" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm text-gray-700 dark:text-white" min="1" max="10000" value="<?= htmlspecialchars($shipment['freight_box_count']) ?>" required="">
                </div>
            </div>
            <div class="mb-4">
                <label for="freight_description" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Freight Details</label>
                <textarea id="freight_description" name="freight_description" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm text-gray-700 dark:text-white" rows="3" required=""><?= htmlspecialchars($shipment['description']) ?></textarea>
            </div>
            
                
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md mt-6 dark:bg-gray-800">
            <h3 class="text-lg font-medium text-gray-700 dark:text-white mb-2">Additional Services</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Select any additional services you may need for your shipment.</p>
            
            <div class="bg-blue-500 p-4 rounded-lg mb-6 dark:bg-gray-700">
                <div class="flex justify-between items-center">
                    <div class="font-medium text-gray-700 dark:text-white">Selected Add-ons Total:</div>
                    <div class="text-xl font-bold text-gray-700 dark:text-white">$<span id="addons_total"><?php echo $shipment['addons_total']; ?></span></div>
                    <input type="hidden" name="addons_total" class="addons_total_value" value="<?php echo $shipment['addons_total']; ?>">
                </div>
            </div>
                <div class="space-y-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="space-y-4">
                        <h4 class="text-xl font-medium text-gray-700 border-b pb-2 dark:text-white">Delivery &amp; Handling</h4>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="liftgate_service-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Liftgate Service</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$50</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">For locations without docks</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="inside_delivery-75" data-cost="75" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Inside Delivery</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$75</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Delivered inside building</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="appointment_delivery-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Appointment Delivery</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$100</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Scheduled delivery window</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="residential_delivery-150" data-cost="150" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Residential Delivery</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$150</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Includes liftgate &amp; appointment</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-xl font-medium text-gray-700 border-b pb-2">Time Services</h4>
                        <div class="grid grid-cols-1  gap-4">
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="detention-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Detention (Wait Time)</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$50/hr</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Wait beyond 2 hrs free</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="layover-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Layover</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$200/day</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Overnight delays</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="team_drivers-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Team Drivers</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$200</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Faster transit</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="expedited_service-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Expedited Service</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$200</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Urgent delivery premium</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-xl font-medium text-gray-700 border-b pb-2">Security &amp; Protection</h4>
                        <div class="grid grid-cols-1  gap-4">
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="security-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Security (Extra)</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$200</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Enhanced security</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="armored_transport-500" data-cost="500" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Armored Transport</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$500</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">For valuable items</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="gps_tracking-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">GPS Tracking</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$50</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Real-time tracking</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="insurance-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Insurance (Extra)</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$100</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Additional cargo insurance</span>
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="space-y-4">
                        <h4 class="text-xl font-medium text-gray-700 border-b pb-2">Equipment &amp; Handling</h4>
                        <div class="grid grid-cols-1  gap-4">
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="tarping-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Tarping</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$100</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Covers cargo</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="securement-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Securement (Extra)</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$50</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Chains, straps, etc.</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="palletizing-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Palletizing</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$50</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Easier cargo handling</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="crating-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Crating</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$100</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Custom crates</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="chassis_rental-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Chassis Rental</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$50</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Container movement</span>
                                </label>
                            </div>
                           
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="pre_cooling-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Pre-Cooling</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$50</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Pre-load trailer cooling</span>
                                </label>
                            </div>
                           
                        </div>

                    </div>

                    <div class="space-y-4">
                        <h4 class="text-xl font-medium text-gray-700 border-b pb-2">Regulatory</h4>
                        <div class="grid grid-cols-1  gap-4">
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="hazmat_compliance-500" data-cost="500" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Hazmat Compliance</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$500</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1 dark:text-white">Certifications &amp; labeling</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="oversized_permits-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Oversized Permits</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$100</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1 dark:text-white">Required for big loads</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="escorts-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Escorts</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$200</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1 dark:text-white">Escort vehicles</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="route_survey-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Route Survey</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$200</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1 dark:text-white">Route planning for clearance</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="customs_clearance-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Customs Clearance</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$100</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1 dark:text-white">International paperwork</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="port_fees-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Port Fees</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$200</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1 dark:text-white">Port handling charges</span>
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="space-y-4">
                        <h4 class="text-xl font-medium text-gray-700 border-b pb-2">Special Services</h4>
                        <div class="grid grid-cols-1  gap-4">
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="white_glove_service-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">White Glove Service</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$100</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1 dark:text-white">Setup, unpack, cleanup</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                    <input type="checkbox" name="addons[]" value="installation-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                    <span class="ml-2 font-medium text-gray-700 dark:text-white">Installation</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$100</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1 dark:text-white">On-site setup</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                    <input type="checkbox" name="addons[]" value="debris_removal-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                    <span class="ml-2 font-medium text-gray-700 dark:text-white">Debris Removal</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$50</span>
                                </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Post-delivery trash cleanup</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                    <input type="checkbox" name="addons[]" value="heavy_lift-500" data-cost="500" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                    <span class="ml-2 font-medium text-gray-700 dark:text-white">Heavy Lift</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$500</span>
                                </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Crane/heavy lift tools</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="cleaning-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Cleaning (Equipment)</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$100</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Post-unload cleaning</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                    <input type="checkbox" name="addons[]" value="storage-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:text-white">
                                    <span class="ml-2 font-medium text-gray-700 dark:text-white">Storage</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$50</span>
                                </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Temporary warehousing</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
         </div>
            <div class="bg-white p-6 rounded-lg shadow-md mt-6 dark:bg-gray-800">
            <h3 class="text-lg font-medium text-gray-700 mb-4 dark:text-white">Shipper Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="shipper_email" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Email *</label>
                    <div class="relative">
                        <input type="text" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm cursor-not-allowed dark:border-gray-600 dark:text-white" required="" disabled autocomplete="off" placeholder="Email" value="<?php 
                        if(isset($_COOKIE['user'])){
                            echo json_decode($_COOKIE['user'])->email;
                        }
                        ?>">
                        <input type="hidden" name="shipper_email" value="<?php 
                        if(isset($_COOKIE['user'])){
                            echo json_decode($_COOKIE['user'])->email;
                        }
                        ?>">
                    </div>
                </div>
                <div>
                    <label for="shipper_phone" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Phone *</label>
                    <div class="relative">
                        <input type="text" id="shipper_phone" name="shipper_phone" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" required="" autocomplete="off" placeholder="Phone"
                        value="<?= htmlspecialchars($shipment['shipper_phone']) ?>">
                    </div>
                </div>
                <div>
                    <label for="shipper_first_name" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">First Name *</label>
                    <div class="relative">
                        <input type="text" id="shipper_first_name" name="shipper_first_name" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" required="" autocomplete="off" placeholder="First Name"
                        value="<?= htmlspecialchars(explode(" ", $shipment['shipper_name'])[0]) ?>">
                    </div>
                </div>
                <div>
                    <label for="shipper_last_name" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Last Name *</label>
                    <div class="relative">
                        <input type="text" id="shipper_last_name" name="shipper_last_name" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" required="" autocomplete="off" placeholder="Last Name"
                        value="<?= htmlspecialchars(explode(" ", $shipment['shipper_name'])[1]) ?>">
                    </div>
                </div>
                <div class="col-span-2">
                    <label for="shipper_address" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Address *</label>
                    <div class="relative">
                        <textarea id="shipper_address" name="shipper_address" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" required="" autocomplete="off" placeholder="Address">
                        <?= htmlspecialchars($shipment['shipper_address']) ?>
                        </textarea>
                    </div>
                </div>
            </div>

            </div>
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded cursor-pointer">Submit Load</button>
            </div>
            
        </form>
            
            
            

           
          </div>
        </main>
      </div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-XmAtSvNj2CjcYT7VRfnIk58aGsdeh7k&libraries=places&callback=Function.prototype"></script>

    <script>
    //    $(document).ready(function() {
    //        $('#loadForm').submit(function(e) {
    //            e.preventDefault();
    //            var formData = new FormData(this);
    //            Swal.fire(
    //             {
    //                 title: 'Are you sure?',
    //                 text: "You won't be able to revert this!",
    //                 icon: 'warning',
    //                 showCancelButton: true,
    //                 confirmButtonColor: '#3085d6',
    //                 cancelButtonColor: '#d33',
    //                 confirmButtonText: 'Yes, submit it!'
    //             }
    //            ).then((result) => {
    //                if (result.isConfirmed) {
    //                    $.ajax({
    //                        url: './helper/load/add.php',
    //                        type: 'POST',
    //                        data: formData,
    //                         processData: false,
    //                         contentType: false,
    //                         success: function(response) {
    //                             Swal.fire(
    //                                 {
    //                                     title: 'Success!',
    //                                     text: 'Load added successfully!',
    //                                     icon: 'success',
    //                                     confirmButtonText: 'OK'
    //                                 }
    //                             );
    //                         },
    //                         error: function(xhr, status, error) {
    //                             Swal.fire(
    //                                 {
    //                                     title: 'Error!',
    //                                     text: 'Failed to add load!',
    //                                     icon: 'error',
    //                                     confirmButtonText: 'OK'
    //                                 }
    //                             );
    //                         }
    //                     });
    //                             }
    //                         }
    //                     );
    //    });
    // });

    $(document).ready(function() {
    $('#loadForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait while we save your load.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                $.ajax({
                    url: './helper/load/update.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Load added successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Optional: Reset form after successful submission
                            $('#loadForm')[0].reset();
                            window.location.href = './index.php';
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to add load!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });
});

        $(document).ready(function() {
            $('input[type="checkbox"]').on('change', function() {
                console.log('Checkbox changed');
                var total = 0;
                $('input[type="checkbox"]:checked').each(function() {
                    total += parseFloat($(this).data('cost'));
                });
                $('#addons_total').text(total.toFixed(2));
                $('.addons_total_value').val(total.toFixed(2));
            }) 
         function initGooglePlacesAutocomplete() {
                    // Check if Google Maps API is loaded
                    if (typeof google === 'undefined' || !google.maps || !google.maps.places) {
                        console.error('Google Maps API not loaded');
                        // Try to reload the API if not loaded
                        setTimeout(loadGoogleMapsAPI, 1000);
                        return;
                    }

                    try {
                        // Initialize autocomplete for pickup address
                        const pickupInput = document.getElementById('pickup_address');
                        if (pickupInput) {
                            const pickupAutocomplete = new google.maps.places.Autocomplete(pickupInput, {
                                types: ['address'],
                                componentRestrictions: { country: 'us' }
                            });

                            // When a place is selected
                            pickupAutocomplete.addListener('place_changed', function () {
                                const place = pickupAutocomplete.getPlace();
                                if (!place.geometry) {
                                    console.log("No details available for input");
                                    return;
                                }
                                console.log('Place selected:', place);
                            });
                        }
                    

                        // Initialize autocomplete for drop-off address
                        const dropoffInput = document.getElementById('drop_address');
                        
                        if (dropoffInput) {
                            const dropoffAutocomplete = new google.maps.places.Autocomplete(dropoffInput, {
                                types: ['address'],
                                componentRestrictions: { country: 'us' }
                            });

                            dropoffAutocomplete.addListener('place_changed', function () {
                                const place = dropoffAutocomplete.getPlace();
                                if (!place.geometry) {
                                    console.log("No details available for input");
                                    return;
                                }
                                console.log('Place selected:', place);
                            });
                        }
                        
                    } catch (error) {
                        console.error('Error initializing Google Places:', error);
                    }
            }

            // Load Google Maps API
                        function loadGoogleMapsAPI() {
                            // Check if script is already added
                            if (document.querySelector('script[src*="maps.googleapis.com"]')) {
                                // If script exists, initialize directly
                                if (typeof google !== 'undefined' && google.maps && google.maps.places) {
                                    initGooglePlacesAutocomplete();
                                }
                                return;
                            }

                            const script = document.createElement('script');
                            script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyA-XmAtSvNj2CjcYT7VRfnIk58aGsdeh7k&libraries=places&callback=initGooglePlacesAutocomplete';
                            script.async = true;
                            script.defer = true;
                            script.onerror = function () {
                                console.error('Failed to load Google Maps API');
                            };
                            document.head.appendChild(script);
                        }

                        // Call the function to load Google Maps API
                        loadGoogleMapsAPI();  
        })
    </script>

    <script>
        $(document).ready(function() {
          let addons = <?php echo json_encode($addOns); ?>;
          console.log(addons); 
          $("input[type='checkbox']").each(function() {
            if (addons.includes($(this).val())) {
                $(this).prop('checked', true);
            }
        });

          
        })
    </script>
  </body>
</html>
