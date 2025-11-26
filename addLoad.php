
<?php include 'config/config.php'; ?>
<?php include 'components/layout/header.php'; ?>
<link rel="stylesheet" href="assets/css/rate_breakdown_modal.css">
    <?php include 'components/layout/sidebar.php'; ?>

    
     
      <div class="flex flex-col flex-1 w-full">
       <?php include 'components/layout/topbar.php'; ?>
        <style>
            .tab-button {
                transition: all 0.3s ease;
            }
            .tab-button:hover {
                border-color: #93c5fd;
            }
            .tab-content {
                animation: fadeIn 0.3s ease-in;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
        <main class="h-full overflow-y-auto pb-10">
          <div class="container px-6 pb-10 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-white "
            >
               Add Load
            </h2>
           
            <!-- Tab Navigation -->
            <div class="mb-6">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button type="button" onclick="switchTab('domestic')" id="domestic-tab" class="tab-button active border-b-2 border-blue-500 py-4 px-1 text-center text-sm font-medium text-blue-600 dark:text-blue-400">
                            <i class="fas fa-truck mr-2"></i>Domestic
                        </button>
                        <button type="button" onclick="switchTab('overseas')" id="overseas-tab" class="tab-button border-b-2 border-transparent py-4 px-1 text-center text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                            <i class="fas fa-ship mr-2"></i>Overseas
                        </button>
                    </nav>
                </div>
            </div>
            
            <form id="loadForm" class="space-y-6">
            <!-- Hidden field to track shipment type -->
            <input type="hidden" id="shipment_type" name="shipment_type" value="domestic">
            
        <!-- DOMESTIC TAB CONTENT -->
        <div id="domestic-content" class="tab-content">
        <!-- Freight Information Section -->
        <div class="bg-white p-6 rounded-lg shadow-md dark:bg-gray-800">
            <h3 class="text-lg font-medium text-gray-700 mb-4 dark:text-white">Freight Information</h3>
            
          

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="pickup_address" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Pickup Address *</label>
                    <div class="relative">
                        <input type="text" id="pickup_address" name="pickup_address" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" required="" autocomplete="off" placeholder="Pickup Address">
                    </div>
                </div>
                <div>
                    <label for="drop_address" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Drop-off Address *</label>
                    <div class="relative">
                        <input type="text" id="drop_address" name="drop_address" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" required="" autocomplete="off" placeholder="Drop-off Address">
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="pickup_time" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Pickup Time *</label>
                    <input type="time" id="pickup_time" name="pickup_time" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" required="" autocomplete="off">
                </div>
                <div>
                    <label for="pickup_date" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Pickup Date *</label>
                    <input type="date" id="pickup_date" name="pickup_date" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" required="" autocomplete="off" min="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="dropoff_time" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Dropoff Time *</label>
                    <input type="time" id="dropoff_time" name="dropoff_time" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" required="" autocomplete="off">
                </div>
                <div>
                    <label for="dropoff_date" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Dropoff Date *</label>
                    <input type="date" id="dropoff_date" name="dropoff_date" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" required="" autocomplete="off" min="<?php echo date('Y-m-d'); ?>" >
                </div>
            </div>
            
            <div class="mb-4">
                <label for="vehicle_type" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Vehicle Type *</label>
                <select id="vehicle_type" name="vehicle_type" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" required="">
                    <option value="" class="text-gray-700">Select Vehicle Type</option>
                    <option value="stepdeck" class="text-gray-700">Step Deck</option>
                    <option value="power only" class="text-gray-700">Power Only</option>
                    <option value="b-train" class="text-gray-700">B-Train</option>
                    <option value="auto carrier" class="text-gray-700">Auto Carrier</option>
                    <option value="reefer" class="text-gray-700">Reefer</option>
                    <option value="flatbed" class="text-gray-700">Flatbed</option>
                    <option value="van" class="text-gray-700">Van</option>
                </select>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="freight_weight" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Weight (lbs) *</label>
                    <input type="number" id="freight_weight" name="freight_weight" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" min="1" required="">
                </div>
                <div>
                    <label for="freight_type" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Freight Type *</label>
                    <select id="freight_type" name="freight_type" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" required="">
                        <option value="" class="text-gray-700">Select Freight Type</option>
                        <option value="general" class="text-gray-700">General Cargo</option>
                        <option value="perishables" class="text-gray-700">Perishables</option>
                        <option value="non_hazardous" class="text-gray-700">Non-Hazardous</option>
                        <option value="bulk" class="text-gray-700">Bulk</option>
                        <option value="heavy" class="text-gray-700">Heavy / Oversized</option>
                        <option value="vehicles" class="text-gray-700">Vehicles</option>
                        <option value="high_value" class="text-gray-700">High-Value</option>
                        <option value="specialized" class="text-gray-700">Specialized</option>
                        <option value="misc" class="text-gray-700">Miscellaneous</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label for="freight_length" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Length (in) *</label>
                    <input type="number" id="freight_length" name="freight_length" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" min="1" required="">
                </div>
                <div>
                    <label for="freight_width" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Width (in) *</label>
                    <input type="number" id="freight_width" name="freight_width" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" min="1" required="">
                </div>
                <div>
                    <label for="freight_height" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Height (in) *</label>
                    <input type="number" id="freight_height" name="freight_height" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" min="1" required="">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="freight_pallet_count" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Number of Pallets</label>
                    <input type="number" id="freight_pallet_count" name="freight_pallet_count" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" min="1" max="10000" value="1" required="">
                </div>
                <div>
                    <label for="freight_box_count" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Number of Boxes</label>
                    <input type="number" id="freight_box_count" name="freight_box_count" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" min="1" max="10000" value="1" required="">
                </div>
            </div>
            <div class="mb-4">
                <label for="freight_description" class="block text-sm font-medium text-gray-700 dark:text-white mb-1">Freight Details</label>
                <textarea id="freight_description" name="freight_description" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" rows="3" required=""></textarea>
            </div>
            
                
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md mt-6 dark:bg-gray-800">
            <h3 class="text-lg font-medium text-gray-700 mb-2 dark:text-white">Additional Services</h3>
            <p class="text-gray-600 mb-4 dark:text-gray-400">Select any additional services you may need for your shipment.</p>
            
            <div class="bg-blue-500 p-4 rounded-lg mb-6 dark:bg-gray-700">
                <div class="flex justify-between items-center">
                    <div class="font-medium text-white">Selected Add-ons Total:</div>
                    <div class="text-xl font-bold text-white">$<span id="addons_total">0.00</span></div>
                    <input type="hidden" name="addons_total" class="addons_total_value" value="0.00">
                </div>
            </div>
                <div class="space-y-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="space-y-4">
                        <h4 class="text-xl font-medium text-gray-800 border-b pb-2 dark:text-white">Delivery &amp; Handling</h4>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="liftgate_service-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Liftgate Service</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$50</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">For locations without docks</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="inside_delivery-75" data-cost="75" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Inside Delivery</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$75</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Delivered inside building</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="appointment_delivery-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Appointment Delivery</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$100</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Scheduled delivery window</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="residential_delivery-150" data-cost="150" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Residential Delivery</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$150</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Includes liftgate &amp; appointment</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-xl font-medium text-gray-800 border-b pb-2 dark:text-white">Time Services</h4>
                        <div class="grid grid-cols-1  gap-4">
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="detention-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Detention (Wait Time)</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$50/hr</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Wait beyond 2 hrs free</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="layover-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Layover</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$200/day</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Overnight delays</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="team_drivers-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Team Drivers</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$200</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Faster transit</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="expedited_service-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Expedited Service</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$200</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Urgent delivery premium</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-xl font-medium text-gray-800 border-b pb-2 dark:text-white">Security &amp; Protection</h4>
                        <div class="grid grid-cols-1  gap-4">
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="security-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Security (Extra)</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$200</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Enhanced security</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="armored_transport-500" data-cost="500" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Armored Transport</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$500</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">For valuable items</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="gps_tracking-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">GPS Tracking</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$50</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Real-time tracking</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="insurance-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Insurance (Extra)</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$100</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Additional cargo insurance</span>
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="space-y-4">
                        <h4 class="text-xl font-medium text-gray-800 border-b pb-2 dark:text-white">Equipment &amp; Handling</h4>
                        <div class="grid grid-cols-1  gap-4">
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="tarping-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Tarping</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$100</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Covers cargo</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="securement-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Securement (Extra)</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$50</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Chains, straps, etc.</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="palletizing-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Palletizing</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$50</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Easier cargo handling</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="crating-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Crating</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$100</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Custom crates</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="chassis_rental-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Chassis Rental</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$50</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Container movement</span>
                                </label>
                            </div>
                           
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="pre_cooling-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Pre-Cooling</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$50</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Pre-load trailer cooling</span>
                                </label>
                            </div>
                           
                        </div>

                    </div>

                    <div class="space-y-4">
                        <h4 class="text-xl font-medium text-gray-800 border-b pb-2 dark:text-white">Regulatory</h4>
                        <div class="grid grid-cols-1  gap-4">
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="hazmat_compliance-500" data-cost="500" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Hazmat Compliance</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$500</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1 dark:text-white">Certifications &amp; labeling</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="oversized_permits-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Oversized Permits</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$100</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1 dark:text-white">Required for big loads</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="escorts-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Escorts</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$200</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1 dark:text-white">Escort vehicles</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="route_survey-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Route Survey</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$200</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1 dark:text-white">Route planning for clearance</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="customs_clearance-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Customs Clearance</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$100</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1 dark:text-white">International paperwork</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="port_fees-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Port Fees</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$200</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1 dark:text-white">Port handling charges</span>
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="space-y-4">
                        <h4 class="text-xl font-medium text-gray-800 border-b pb-2 dark:text-white">Special Services</h4>
                        <div class="grid grid-cols-1  gap-4">
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="white_glove_service-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">White Glove Service</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$100</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1 dark:text-white">Setup, unpack, cleanup</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                    <input type="checkbox" name="addons[]" value="installation-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                    <span class="ml-2 font-medium text-gray-700 dark:text-white">Installation</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$100</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1 dark:text-white">On-site setup</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                    <input type="checkbox" name="addons[]" value="debris_removal-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                    <span class="ml-2 font-medium text-gray-700 dark:text-white">Debris Removal</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$50</span>
                                </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Post-delivery trash cleanup</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                    <input type="checkbox" name="addons[]" value="heavy_lift-500" data-cost="500" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                    <span class="ml-2 font-medium text-gray-700 dark:text-white">Heavy Lift</span>
                                    <span class="ml-auto font-bold text-blue-700 dark:text-white">$500</span>
                                </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Crane/heavy lift tools</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="cleaning-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
                                        <span class="ml-2 font-medium text-gray-700 dark:text-white">Cleaning (Equipment)</span>
                                        <span class="ml-auto font-bold text-blue-700 dark:text-white">$100</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1 dark:text-white">Post-unload cleaning</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow dark:border-gray-600">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                    <input type="checkbox" name="addons[]" value="storage-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 dark:border-gray-600">
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
                        <input type="text" id="shipper_phone" name="shipper_phone" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" required="" autocomplete="off" placeholder="Phone">
                    </div>
                </div>
                <div>
                    <label for="shipper_first_name" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">First Name *</label>
                    <div class="relative">
                        <input type="text" id="shipper_first_name" name="shipper_first_name" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" required="" autocomplete="off" placeholder="First Name">
                    </div>
                </div>
                <div>
                    <label for="shipper_last_name" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Last Name *</label>
                    <div class="relative">
                        <input type="text" id="shipper_last_name" name="shipper_last_name" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" required="" autocomplete="off" placeholder="Last Name">
                    </div>
                </div>
                <div class="col-span-2">
                    <label for="shipper_address" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Address *</label>
                    <div class="relative">
                        <textarea id="shipper_address" name="shipper_address" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" required="" autocomplete="off" placeholder="Address"></textarea>
                    </div>
                </div>
            </div>

            </div>
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded cursor-pointer">Submit Load</button>
            </div>
        </div>
        <!-- END DOMESTIC TAB CONTENT -->
        
        <!-- OVERSEAS TAB CONTENT -->
        <div id="overseas-content" class="tab-content" style="display: none;">
            <!-- Container Specifications Section -->
            <div class="bg-white p-6 rounded-lg shadow-md dark:bg-gray-800">
                <h3 class="text-lg font-medium text-gray-700 mb-4 dark:text-white">Ocean Container Specifications</h3>
                
                <div class="mb-4">
                    <label for="container_type" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Container Type *</label>
                    <select id="container_type" name="container_type" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" onchange="updateContainerSpecs()">
                        <option value="">Select Container Type</option>
                        <option value="20_dry">20' Dry Container</option>
                        <option value="40_dry">40' Dry Container</option>
                        <option value="40_high_cube">40' High Cube Container</option>
                    </select>
                </div>

                <!-- Container Specifications Display -->
                <div id="container-specs" class="mb-4 p-4 bg-white dark:bg-gray-700 rounded-lg" style="display: none;">
                    <h4 class="font-medium text-gray-700 dark:text-white mb-3">Container Details</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Exterior Length:</span>
                            <p class="font-semibold text-gray-600 dark:text-white" id="spec-ext-length">-</p>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Exterior Width:</span>
                            <p class="font-semibold text-gray-600 dark:text-white" id="spec-ext-width">-</p>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Exterior Height:</span>
                            <p class="font-semibold text-gray-600 dark:text-white" id="spec-ext-height">-</p>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Max Payload:</span>
                            <p class="font-semibold text-gray-600 dark:text-white" id="spec-payload">-</p>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Internal Length:</span>
                            <p class="font-semibold text-gray-600 dark:text-white" id="spec-int-length">-</p>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Internal Width:</span>
                            <p class="font-semibold text-gray-600 dark:text-white" id="spec-int-width">-</p>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Internal Height:</span>
                            <p class="font-semibold text-gray-600 dark:text-white" id="spec-int-height">-</p>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Cubic Capacity:</span>
                            <p class="font-semibold text-gray-600 dark:text-white" id="spec-capacity">-</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="overseas_pickup_port" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Origin Port *</label>
                        <input type="text" id="overseas_pickup_port" name="overseas_pickup_port" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" placeholder="e.g., Shanghai, China">
                    </div>
                    <div>
                        <label for="overseas_destination_port" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Destination Port *</label>
                        <input type="text" id="overseas_destination_port" name="overseas_destination_port" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" placeholder="e.g., Los Angeles, USA">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="overseas_pickup_date" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Estimated Pickup Date *</label>
                        <input type="date" id="overseas_pickup_date" name="overseas_pickup_date" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div>
                        <label for="overseas_delivery_date" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Estimated Delivery Date *</label>
                        <input type="date" id="overseas_delivery_date" name="overseas_delivery_date" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" min="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="commodity_type" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Type of Commodity *</label>
                        <select id="commodity_type" name="commodity_type" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white">
                            <option value="">Select Commodity Type</option>
                            <option value="household_goods">Household Goods (International Move with or without Cars)</option>
                            <option value="commercial">Commercial Items</option>
                            <option value="cars_only">Cars Only</option>
                        </select>
                    </div>
                    <div>
                        <label for="cargo_weight" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Estimated Weight (lbs) *</label>
                        <input type="number" id="cargo_weight" name="cargo_weight" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" min="1">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-white">Is the Cargo Hazardous Material? *</label>
                    <div class="flex gap-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="is_hazardous" value="yes" class="form-radio text-blue-600">
                            <span class="ml-2 dark:text-white">Yes</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="is_hazardous" value="no" class="form-radio text-blue-600" checked>
                            <span class="ml-2 dark:text-white">No</span>
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="cargo_description" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Cargo Description *</label>
                    <textarea id="cargo_description" name="cargo_description" rows="3" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" placeholder="Please provide a full description of the nature of your cargo"></textarea>
                </div>
            </div>

            <!-- Additional Services for Overseas -->
            <div class="bg-white p-6 rounded-lg shadow-md mt-6 dark:bg-gray-800">
                <h3 class="text-lg font-medium text-gray-700 mb-4 dark:text-white">Additional Services</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="border rounded-lg p-4 dark:border-gray-600">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="overseas_customs" value="yes" class="h-4 w-4 text-blue-600 rounded">
                            <span class="ml-2 font-medium text-gray-700 dark:text-white">Customs Clearance Required</span>
                        </label>
                    </div>
                    <div class="border rounded-lg p-4 dark:border-gray-600">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="overseas_insurance" value="yes" class="h-4 w-4 text-blue-600 rounded">
                            <span class="ml-2 font-medium text-gray-700 dark:text-white">Insurance Required</span>
                        </label>
                    </div>
                    <div class="border rounded-lg p-4 dark:border-gray-600">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="overseas_delivery" value="yes" class="h-4 w-4 text-blue-600 rounded">
                            <span class="ml-2 font-medium text-gray-700 dark:text-white">Door-to-Door Delivery</span>
                        </label>
                    </div>
                    <div class="border rounded-lg p-4 dark:border-gray-600">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="overseas_broker" value="yes" class="h-4 w-4 text-blue-600 rounded">
                            <span class="ml-2 font-medium text-gray-700 dark:text-white">Customs Broker Needed</span>
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="insurance_value" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Declared Value of Cargo (US $)</label>
                    <input type="number" id="insurance_value" name="insurance_value" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" placeholder="Enter amount (no commas)">
                </div>
            </div>

            <!-- Shipper Information for Overseas -->
            <div class="bg-white p-6 rounded-lg shadow-md mt-6 dark:bg-gray-800">
                <h3 class="text-lg font-medium text-gray-700 mb-4 dark:text-white">Shipper Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="overseas_shipper_email" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Email *</label>
                        <div class="relative">
                            <input type="text" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm cursor-not-allowed dark:border-gray-600 dark:text-white" disabled autocomplete="off" placeholder="Email" value="<?php 
                            if(isset($_COOKIE['user'])){
                                echo json_decode($_COOKIE['user'])->email;
                            }
                            ?>">
                            <input type="hidden" name="overseas_shipper_email" value="<?php 
                            if(isset($_COOKIE['user'])){
                                echo json_decode($_COOKIE['user'])->email;
                            }
                            ?>">
                        </div>
                    </div>
                    <div>
                        <label for="overseas_shipper_phone" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Phone *</label>
                        <input type="text" id="overseas_shipper_phone" name="overseas_shipper_phone" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" autocomplete="off" placeholder="Phone">
                    </div>
                    <div>
                        <label for="overseas_shipper_first_name" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">First Name *</label>
                        <input type="text" id="overseas_shipper_first_name" name="overseas_shipper_first_name" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" autocomplete="off" placeholder="First Name">
                    </div>
                    <div>
                        <label for="overseas_shipper_last_name" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Last Name *</label>
                        <input type="text" id="overseas_shipper_last_name" name="overseas_shipper_last_name" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" autocomplete="off" placeholder="Last Name">
                    </div>
                    <div class="col-span-2">
                        <label for="overseas_shipper_address" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Organization</label>
                        <input type="text" id="overseas_organization" name="overseas_organization" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" autocomplete="off" placeholder="Organization Name (if applicable)">
                    </div>
                    <div class="col-span-2">
                        <label for="overseas_zip_code" class="block text-sm font-medium text-gray-700 mb-1 dark:text-white">Zip Code *</label>
                        <input type="text" id="overseas_zip_code" name="overseas_zip_code" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm dark:border-gray-600 dark:text-white" autocomplete="off" placeholder="Zip Code">
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded cursor-pointer">Submit Load</button>
            </div>
        </div>
        <!-- END OVERSEAS TAB CONTENT -->
            
        </form>
            
        <!-- Rate Breakdown Modal -->
        <div id="rateBreakdownModal" class="rate-modal-overlay">
            <div class="rate-modal-container">
                <div class="rate-modal-header">
                    RATING DETAILS
                </div>
                <div class="rate-modal-body">
                    <div class="rate-route-info">
                        Ocean Container Rates from <strong id="modal-origin">-</strong> To <strong id="modal-destination">-</strong>
                    </div>
                    <div class="rate-weight-info">
                        Total Volume Weight <span id="modal-weight">-</span> lb or <span id="modal-weight-kg">-</span> kgs.
                    </div>
                    
                    <table class="rate-breakdown-table">
                        <thead>
                            <tr>
                                <th style="width: 35%;">DESCRIPTION</th>
                                <th style="width: 20%;">VALUE</th>
                                <th style="width: 15%;">RATE</th>
                                <th style="width: 10%;">QTY.</th>
                                <th style="width: 20%;">AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody id="modal-breakdown-body">
                            <!-- Breakdown items will be inserted here -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" style="text-align: left;">Total</td>
                                <td id="modal-total">US $0.00</td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="rate-modal-footer">
                        <strong>No deposit required - All bookings must be made in written form.</strong><br>
                        (A Confirmation of Rates and Availability will be sent to you via e-mail within 72 hours)<br><br>
                        All charges are confirmed in by means of a Booking Confirmation and are based on your shipment dates and the origin and destination address you provide to us.
                    </div>
                </div>
                <div class="rate-modal-actions">
                    <button type="button" class="rate-modal-btn rate-modal-btn-confirm" onclick="confirmAndSubmit()">
                        <i class="fas fa-check-circle"></i> Confirm & Submit
                    </button>
                    <button type="button" class="rate-modal-btn rate-modal-btn-cancel" onclick="closeRateModal()">
                        <i class="fas fa-times-circle"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
            
            

           
          </div>
        </main>
      </div>
    </div>
    <script src="js/rate_calculator.js"></script>
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

    // Store form data globally for submission after rate confirmation
    let pendingFormData = null;

    $(document).ready(function() {
    $('#loadForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        const shipmentType = document.getElementById('shipment_type').value;
        
        // If overseas shipment, show rate breakdown first
        if (shipmentType === 'overseas') {
            // Validate required overseas fields
            if (!validateOverseasForm()) {
                return false;
            }
            
            // Calculate and show rate breakdown
            showRateBreakdown(formData);
            return false;
        }
        
        // For domestic shipments, proceed with normal submission
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
                    url: './helper/load/add.php',
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

    // Validate overseas form fields
    function validateOverseasForm() {
        const requiredFields = [
            { id: 'container_type', name: 'Container Type' },
            { id: 'overseas_pickup_port', name: 'Origin Port' },
            { id: 'overseas_destination_port', name: 'Destination Port' },
            { id: 'overseas_pickup_date', name: 'Pickup Date' },
            { id: 'overseas_delivery_date', name: 'Delivery Date' },
            { id: 'commodity_type', name: 'Commodity Type' },
            { id: 'cargo_weight', name: 'Cargo Weight' },
            { id: 'cargo_description', name: 'Cargo Description' },
            { id: 'overseas_shipper_phone', name: 'Phone' },
            { id: 'overseas_shipper_first_name', name: 'First Name' },
            { id: 'overseas_shipper_last_name', name: 'Last Name' },
            { id: 'overseas_zip_code', name: 'Zip Code' }
        ];

        for (const field of requiredFields) {
            const element = document.getElementById(field.id);
            if (!element || !element.value || element.value.trim() === '') {
                Swal.fire({
                    title: 'Missing Information',
                    text: `Please fill in the ${field.name} field.`,
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                element?.focus();
                return false;
            }
        }
        return true;
    }

    // Show rate breakdown modal
    function showRateBreakdown(formData) {
        // Convert FormData to object
        const formObject = {};
        for (const [key, value] of formData.entries()) {
            formObject[key] = value;
        }

        // Store for later submission
        pendingFormData = formData;

        // Calculate rates
        const rateData = window.OceanFreightCalculator.calculateFreight(formObject);

        // Populate modal
        document.getElementById('modal-origin').textContent = rateData.origin || '-';
        document.getElementById('modal-destination').textContent = rateData.destination || '-';
        document.getElementById('modal-weight').textContent = rateData.weight.toLocaleString();
        document.getElementById('modal-weight-kg').textContent = rateData.weightKg;

        // Build breakdown table
        const tbody = document.getElementById('modal-breakdown-body');
        tbody.innerHTML = '';

        rateData.breakdown.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td style="white-space: pre-line;">${item.description}</td>
                <td>${item.value}</td>
                <td>${item.rate ? (typeof item.rate === 'number' ? '$' + item.rate.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) : item.rate) : ''}</td>
                <td>${item.qty}</td>
                <td>$${item.amount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
            `;
            tbody.appendChild(row);
        });

        // Set total
        document.getElementById('modal-total').textContent = 
            'US $' + rateData.total.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});

        // Add total to form data
        formData.append('calculated_total', rateData.total);
        formData.append('rate_breakdown', JSON.stringify(rateData.breakdown));

        // Show modal
        document.getElementById('rateBreakdownModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    // Close rate modal
    function closeRateModal() {
        document.getElementById('rateBreakdownModal').classList.remove('active');
        document.body.style.overflow = 'auto';
        pendingFormData = null;
    }

    // Confirm and submit to backend
    function confirmAndSubmit() {
        if (!pendingFormData) {
            closeRateModal();
            return;
        }

        // Close modal
        closeRateModal();

        // Show loading
        Swal.fire({
            title: 'Processing...',
            text: 'Please wait while we save your shipment.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Submit to backend
        $.ajax({
            url: './helper/load/add.php',
            type: 'POST',
            data: pendingFormData,
            processData: false,
            contentType: false,
            success: function(response) {
                pendingFormData = null;
                Swal.fire({
                    title: 'Success!',
                    text: 'Overseas shipment added successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    $('#loadForm')[0].reset();
                    window.location.href = './index.php';
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to add shipment. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    }


        $(document).ready(function() {
            $('input[type="checkbox"]').on('change', function() {
                console.log('Checkbox changed');
                var total = 0;
                $('input[type="checkbox"]:checked').each(function() {
                    total += parseFloat($(this).data('cost'));
                });
                $('#addons_total').text(total.toFixed(2));
                $('.addons_total_value').val(total.toFixed(2));
            });
        });

        // Tab switching function
        function switchTab(tabName) {
            // Update hidden field
            document.getElementById('shipment_type').value = tabName;
            
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.style.display = 'none';
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
                button.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-content').style.display = 'block';
            
            // Add active class to selected tab
            const activeTab = document.getElementById(tabName + '-tab');
            activeTab.classList.add('active', 'border-blue-500', 'text-blue-600', 'dark:text-blue-400');
            activeTab.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            
            // Handle required attributes based on active tab
            if (tabName === 'domestic') {
                // Enable domestic required fields
                enableRequiredFields('domestic-content');
                // Disable overseas required fields
                disableRequiredFields('overseas-content');
            } else if (tabName === 'overseas') {
                // Enable overseas required fields
                enableRequiredFields('overseas-content');
                // Disable domestic required fields
                disableRequiredFields('domestic-content');
            }
        }

        // Enable required attributes for fields in a container
        function enableRequiredFields(containerId) {
            const container = document.getElementById(containerId);
            if (!container) return;
            
            // Find all inputs, selects, and textareas that should be required
            const fields = container.querySelectorAll('input[data-required="true"], select[data-required="true"], textarea[data-required="true"]');
            fields.forEach(field => {
                field.setAttribute('required', 'required');
            });
        }

        // Disable required attributes for fields in a container
        function disableRequiredFields(containerId) {
            const container = document.getElementById(containerId);
            if (!container) return;
            
            // Find all required fields and mark them for later
            const fields = container.querySelectorAll('input[required], select[required], textarea[required]');
            fields.forEach(field => {
                field.setAttribute('data-required', 'true');
                field.removeAttribute('required');
            });
        }

        // Initialize on page load - disable overseas fields by default
        document.addEventListener('DOMContentLoaded', function() {
            disableRequiredFields('overseas-content');
        });

        // Container specifications data
        const containerSpecs = {
            '20_dry': {
                extLength: "19' 10\"",
                extWidth: "8'",
                extHeight: "8' 6\"",
                intLength: "19' 4\"",
                intWidth: "7' 8\"",
                intHeight: "7' 9\"",
                payload: "38,000 lbs",
                capacity: "32.9 CBM (1,161 CF)"
            },
            '40_dry': {
                extLength: "40'",
                extWidth: "8'",
                extHeight: "8' 6\"",
                intLength: "39' 5\"",
                intWidth: "7' 8\"",
                intHeight: "7' 9\"",
                payload: "43,000 lbs",
                capacity: "67 CBM (2,366 CF)"
            },
            '40_high_cube': {
                extLength: "40'",
                extWidth: "8'",
                extHeight: "9' 6\"",
                intLength: "39' 6\"",
                intWidth: "7' 8\"",
                intHeight: "8' 9\"",
                payload: "43,000 lbs",
                capacity: "75.6 CBM (2,671 CF)"
            }
        };

        // Update container specifications display
        function updateContainerSpecs() {
            const containerType = document.getElementById('container_type').value;
            const specsDiv = document.getElementById('container-specs');
            
            if (containerType && containerSpecs[containerType]) {
                const specs = containerSpecs[containerType];
                
                document.getElementById('spec-ext-length').textContent = specs.extLength;
                document.getElementById('spec-ext-width').textContent = specs.extWidth;
                document.getElementById('spec-ext-height').textContent = specs.extHeight;
                document.getElementById('spec-int-length').textContent = specs.intLength;
                document.getElementById('spec-int-width').textContent = specs.intWidth;
                document.getElementById('spec-int-height').textContent = specs.intHeight;
                document.getElementById('spec-payload').textContent = specs.payload;
                document.getElementById('spec-capacity').textContent = specs.capacity;
                
                specsDiv.style.display = 'block';
            } else {
                specsDiv.style.display = 'none';
            }
        }
 
        //  function initGooglePlacesAutocomplete() {
        //             // Check if Google Maps API is loaded
        //             if (typeof google === 'undefined' || !google.maps || !google.maps.places) {
        //                 console.error('Google Maps API not loaded');
        //                 // Try to reload the API if not loaded
        //                 setTimeout(loadGoogleMapsAPI, 1000);
        //                 return;
        //             }

        //             try {
        //                 // Initialize autocomplete for pickup address
        //                 const pickupInput = document.getElementById('pickup_address');
        //                 if (pickupInput) {
        //                     const pickupAutocomplete = new google.maps.places.Autocomplete(pickupInput, {
        //                         types: ['address'],
        //                         componentRestrictions: { country: 'us' }
        //                     });

        //                     // When a place is selected
        //                     pickupAutocomplete.addListener('place_changed', function () {
        //                         const place = pickupAutocomplete.getPlace();
        //                         if (!place.geometry) {
        //                             console.log("No details available for input");
        //                             return;
        //                         }
        //                         console.log('Place selected:', place);
        //                     });
        //                 }
                    

        //                 // Initialize autocomplete for drop-off address
        //                 const dropoffInput = document.getElementById('drop_address');
                        
        //                 if (dropoffInput) {
        //                     const dropoffAutocomplete = new google.maps.places.Autocomplete(dropoffInput, {
        //                         types: ['address'],
        //                         componentRestrictions: { country: 'us' }
        //                     });

        //                     dropoffAutocomplete.addListener('place_changed', function () {
        //                         const place = dropoffAutocomplete.getPlace();
        //                         if (!place.geometry) {
        //                             console.log("No details available for input");
        //                             return;
        //                         }
        //                         console.log('Place selected:', place);
        //                     });
        //                 }
                        
        //             } catch (error) {
        //                 console.error('Error initializing Google Places:', error);
        //             }
        //     }
        function formatAddress(place) {
    let location = place.name || '';
    let state = '';
    let country = '';

    // Find state and country from address components
    for (const component of place.address_components) {
        const types = component.types;
        if (types.includes('administrative_area_level_1')) {
            state = component.short_name;
        }
        if (types.includes('country')) {
            country = component.short_name;
        }
    }

    // Build the formatted address
    let formattedAddress = location;
    if (state) formattedAddress += `, ${state}`;
    if (country) formattedAddress += `, ${country}`;

    return formattedAddress;
}

// Format address for ports (City, Country format)
function formatPortAddress(place) {
    let city = place.name || '';
    let country = '';

    // Find country from address components
    for (const component of place.address_components) {
        const types = component.types;
        if (types.includes('country')) {
            country = component.long_name; // Use full country name for ports
        }
        // If the place is a locality, use it as city
        if (types.includes('locality')) {
            city = component.long_name;
        }
    }

    // Build the formatted port address (City, Country)
    let formattedAddress = city;
    if (country) formattedAddress += `, ${country}`;

    return formattedAddress;
}

function initGooglePlacesAutocomplete() {
    // Check if Google Maps API is loaded
    if (typeof google === 'undefined' || !google.maps || !google.maps.places) {
        console.error('Google Maps API not loaded');
        setTimeout(loadGoogleMapsAPI, 1000);
        return;
    }

    try {
        // Initialize autocomplete for pickup address (Domestic)
        const pickupInput = document.getElementById('pickup_address');
        if (pickupInput) {
            const pickupAutocomplete = new google.maps.places.Autocomplete(pickupInput, {
                types: ['(cities)'],
                componentRestrictions: { country: 'us' },
                fields: ['name', 'address_components']
            });

            // When a place is selected
            pickupAutocomplete.addListener('place_changed', function() {
                const place = pickupAutocomplete.getPlace();
                if (!place.geometry) {
                    console.log("No details available for input");
                    return;
                }
                // Format the address
                pickupInput.value = formatAddress(place);
            });
        }

        // Initialize autocomplete for drop-off address (Domestic)
        const dropoffInput = document.getElementById('drop_address');
        if (dropoffInput) {
            const dropoffAutocomplete = new google.maps.places.Autocomplete(dropoffInput, {
                types: ['(cities)'],
                componentRestrictions: { country: 'us' },
                fields: ['name', 'address_components']
            });

            dropoffAutocomplete.addListener('place_changed', function() {
                const place = dropoffAutocomplete.getPlace();
                if (!place.geometry) {
                    console.log("No details available for input");
                    return;
                }
                // Format the address
                dropoffInput.value = formatAddress(place);
            });
        }

        // Initialize autocomplete for origin port (Overseas)
        const originPortInput = document.getElementById('overseas_pickup_port');
        if (originPortInput) {
            const originPortAutocomplete = new google.maps.places.Autocomplete(originPortInput, {
                types: ['(cities)'],
                fields: ['name', 'address_components', 'formatted_address']
            });

            originPortAutocomplete.addListener('place_changed', function() {
                const place = originPortAutocomplete.getPlace();
                if (!place.geometry) {
                    console.log("No details available for input");
                    return;
                }
                // Format the address for port (City, Country)
                originPortInput.value = formatPortAddress(place);
            });
        }

        // Initialize autocomplete for destination port (Overseas)
        const destinationPortInput = document.getElementById('overseas_destination_port');
        if (destinationPortInput) {
            const destinationPortAutocomplete = new google.maps.places.Autocomplete(destinationPortInput, {
                types: ['(cities)'],
                fields: ['name', 'address_components', 'formatted_address']
            });

            destinationPortAutocomplete.addListener('place_changed', function() {
                const place = destinationPortAutocomplete.getPlace();
                if (!place.geometry) {
                    console.log("No details available for input");
                    return;
                }
                // Format the address for port (City, Country)
                destinationPortInput.value = formatPortAddress(place);
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
    </script>
  </body>
</html>
