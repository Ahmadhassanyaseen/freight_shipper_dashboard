<?php include 'helper/globalHelper.php'; ?>
<?php include 'config/config.php'; ?>
<?php include 'components/layout/header.php'; ?>
    <?php include 'components/layout/sidebar.php'; ?>

    
     
      <div class="flex flex-col flex-1 w-full">
       <?php include 'components/layout/topbar.php'; ?>
        <main class="h-full overflow-y-auto pb-10">
          <div class="container px-6 pb-10 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 "
            >
               Add Load
            </h2>
           
            
            <form id="loadForm" class="space-y-6">
        <!-- Freight Information Section -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Freight Information</h3>
            
          

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="pickup_address" class="block text-sm font-medium text-gray-700 mb-1">Pickup Address *</label>
                    <div class="relative">
                        <input type="text" id="pickup_address" name="pickup_address" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm" required="" autocomplete="off" placeholder="Pickup Address">
                    </div>
                </div>
                <div>
                    <label for="drop_address" class="block text-sm font-medium text-gray-700 mb-1">Drop-off Address *</label>
                    <div class="relative">
                        <input type="text" id="drop_address" name="drop_address" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm" required="" autocomplete="off" placeholder="Drop-off Address">
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="pickup_time" class="block text-sm font-medium text-gray-700 mb-1">Pickup Time *</label>
                    <input type="time" id="pickup_time" name="pickup_time" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm" required="" autocomplete="off">
                </div>
                <div>
                    <label for="pickup_date" class="block text-sm font-medium text-gray-700 mb-1">Pickup Date *</label>
                    <input type="date" id="pickup_date" name="pickup_date" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm" required="" autocomplete="off">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="dropoff_time" class="block text-sm font-medium text-gray-700 mb-1">Dropoff Time *</label>
                    <input type="time" id="dropoff_time" name="dropoff_time" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm" required="" autocomplete="off">
                </div>
                <div>
                    <label for="dropoff_date" class="block text-sm font-medium text-gray-700 mb-1">Dropoff Date *</label>
                    <input type="date" id="dropoff_date" name="dropoff_date" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm" required="" autocomplete="off">
                </div>
            </div>
            
            <div class="mb-4">
                <label for="vehicle_type" class="block text-sm font-medium text-gray-700 mb-1">Vehicle Type *</label>
                <select id="vehicle_type" name="vehicle_type" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm" required="">
                    <option value="">Select Vehicle Type</option>
                    <option value="stepdeck">Step Deck</option>
                    <option value="power only">Power Only</option>
                    <option value="b-train">B-Train</option>
                    <option value="auto carrier">Auto Carrier</option>
                    <option value="reefer">Reefer</option>
                    <option value="flatbed">Flatbed</option>
                    <option value="van">Van</option>
                </select>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="freight_weight" class="block text-sm font-medium text-gray-700 mb-1">Weight (lbs) *</label>
                    <input type="number" id="freight_weight" name="freight_weight" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm" min="1" required="">
                </div>
                <div>
                    <label for="freight_type" class="block text-sm font-medium text-gray-700 mb-1">Freight Type *</label>
                    <select id="freight_type" name="freight_type" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm" required="">
                        <option value="">Select Freight Type</option>
                        <option value="general">General Cargo</option>
                        <option value="perishables">Perishables</option>
                        <option value="non_hazardous">Non-Hazardous</option>
                        <option value="bulk">Bulk</option>
                        <option value="heavy">Heavy / Oversized</option>
                        <option value="vehicles">Vehicles</option>
                        <option value="high_value">High-Value</option>
                        <option value="specialized">Specialized</option>
                        <option value="misc">Miscellaneous</option>
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label for="freight_length" class="block text-sm font-medium text-gray-700 mb-1">Length (in) *</label>
                    <input type="number" id="freight_length" name="freight_length" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm" min="1" required="">
                </div>
                <div>
                    <label for="freight_width" class="block text-sm font-medium text-gray-700 mb-1">Width (in) *</label>
                    <input type="number" id="freight_width" name="freight_width" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm" min="1" required="">
                </div>
                <div>
                    <label for="freight_height" class="block text-sm font-medium text-gray-700 mb-1">Height (in) *</label>
                    <input type="number" id="freight_height" name="freight_height" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm" min="1" required="">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="freight_pallet_count" class="block text-sm font-medium text-gray-700 mb-1">Number of Pallets</label>
                    <input type="number" id="freight_pallet_count" name="freight_pallet_count" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm" min="1" max="10000" value="1" required="">
                </div>
                <div>
                    <label for="freight_box_count" class="block text-sm font-medium text-gray-700 mb-1">Number of Boxes</label>
                    <input type="number" id="freight_box_count" name="freight_box_count" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm" min="1" max="10000" value="1" required="">
                </div>
            </div>
            <div class="mb-4">
                <label for="freight_description" class="block text-sm font-medium text-gray-700 mb-1">Freight Details</label>
                <textarea id="freight_description" name="freight_description" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm" rows="3" required=""></textarea>
            </div>
            
                
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Additional Services</h3>
            <p class="text-gray-600 mb-4">Select any additional services you may need for your shipment.</p>
            
            <div class="bg-blue-50 p-4 rounded-lg mb-6">
                <div class="flex justify-between items-center">
                    <div class="font-medium text-gray-700">Selected Add-ons Total:</div>
                    <div class="text-xl font-bold text-blue-700">$<span id="addons_total">0.00</span></div>
                    <input type="hidden" name="addons_total" class="addons_total_value" value="0.00">
                </div>
            </div>
                <div class="space-y-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="space-y-4">
                        <h4 class="text-xl font-medium text-gray-800 border-b pb-2">Delivery &amp; Handling</h4>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="liftgate_service-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Liftgate Service</span>
                                        <span class="ml-auto font-bold text-blue-700">$50</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1">For locations without docks</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="inside_delivery-75" data-cost="75" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Inside Delivery</span>
                                        <span class="ml-auto font-bold text-blue-700">$75</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1">Delivered inside building</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="appointment_delivery-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Appointment Delivery</span>
                                        <span class="ml-auto font-bold text-blue-700">$100</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1">Scheduled delivery window</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="residential_delivery-150" data-cost="150" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Residential Delivery</span>
                                        <span class="ml-auto font-bold text-blue-700">$150</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1">Includes liftgate &amp; appointment</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-xl font-medium text-gray-800 border-b pb-2">Time Services</h4>
                        <div class="grid grid-cols-1  gap-4">
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="detention-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Detention (Wait Time)</span>
                                        <span class="ml-auto font-bold text-blue-700">$50/hr</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1">Wait beyond 2 hrs free</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="layover-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Layover</span>
                                        <span class="ml-auto font-bold text-blue-700">$200/day</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1">Overnight delays</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="team_drivers-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Team Drivers</span>
                                        <span class="ml-auto font-bold text-blue-700">$200</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1">Faster transit</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="expedited_service-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Expedited Service</span>
                                        <span class="ml-auto font-bold text-blue-700">$200</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1">Urgent delivery premium</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-xl font-medium text-gray-800 border-b pb-2">Security &amp; Protection</h4>
                        <div class="grid grid-cols-1  gap-4">
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="security-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Security (Extra)</span>
                                        <span class="ml-auto font-bold text-blue-700">$200</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1">Enhanced security</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="armored_transport-500" data-cost="500" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Armored Transport</span>
                                        <span class="ml-auto font-bold text-blue-700">$500</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1">For valuable items</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="gps_tracking-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">GPS Tracking</span>
                                        <span class="ml-auto font-bold text-blue-700">$50</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1">Real-time tracking</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="insurance-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Insurance (Extra)</span>
                                        <span class="ml-auto font-bold text-blue-700">$100</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1">Additional cargo insurance</span>
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="space-y-4">
                        <h4 class="text-xl font-medium text-gray-800 border-b pb-2">Equipment &amp; Handling</h4>
                        <div class="grid grid-cols-1  gap-4">
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="tarping-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Tarping</span>
                                        <span class="ml-auto font-bold text-blue-700">$100</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1">Covers cargo</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="securement-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Securement (Extra)</span>
                                        <span class="ml-auto font-bold text-blue-700">$50</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1">Chains, straps, etc.</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="palletizing-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Palletizing</span>
                                        <span class="ml-auto font-bold text-blue-700">$50</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1">Easier cargo handling</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="crating-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Crating</span>
                                        <span class="ml-auto font-bold text-blue-700">$100</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1">Custom crates</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="chassis_rental-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Chassis Rental</span>
                                        <span class="ml-auto font-bold text-blue-700">$50</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1">Container movement</span>
                                </label>
                            </div>
                           
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="pre_cooling-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Pre-Cooling</span>
                                        <span class="ml-auto font-bold text-blue-700">$50</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1">Pre-load trailer cooling</span>
                                </label>
                            </div>
                           
                        </div>

                    </div>

                    <div class="space-y-4">
                        <h4 class="text-xl font-medium text-gray-800 border-b pb-2">Regulatory</h4>
                        <div class="grid grid-cols-1  gap-4">
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="hazmat_compliance-500" data-cost="500" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Hazmat Compliance</span>
                                    <span class="ml-auto font-bold text-blue-700">$500</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1">Certifications &amp; labeling</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="oversized_permits-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Oversized Permits</span>
                                    <span class="ml-auto font-bold text-blue-700">$100</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1">Required for big loads</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="escorts-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Escorts</span>
                                    <span class="ml-auto font-bold text-blue-700">$200</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1">Escort vehicles</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="route_survey-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Route Survey</span>
                                    <span class="ml-auto font-bold text-blue-700">$200</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1">Route planning for clearance</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="customs_clearance-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Customs Clearance</span>
                                    <span class="ml-auto font-bold text-blue-700">$100</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1">International paperwork</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="port_fees-200" data-cost="200" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Port Fees</span>
                                    <span class="ml-auto font-bold text-blue-700">$200</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1">Port handling charges</span>
                                </label>
                            </div>
                        </div>

                    </div>

                    <div class="space-y-4">
                        <h4 class="text-xl font-medium text-gray-800 border-b pb-2">Special Services</h4>
                        <div class="grid grid-cols-1  gap-4">
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="white_glove_service-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">White Glove Service</span>
                                    <span class="ml-auto font-bold text-blue-700">$100</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1">Setup, unpack, cleanup</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                    <input type="checkbox" name="addons[]" value="installation-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="ml-2 font-medium text-gray-900">Installation</span>
                                    <span class="ml-auto font-bold text-blue-700">$100</span>
                                </div>
                                <span class="text-sm text-gray-500 mt-1">On-site setup</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                    <input type="checkbox" name="addons[]" value="debris_removal-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="ml-2 font-medium text-gray-900">Debris Removal</span>
                                    <span class="ml-auto font-bold text-blue-700">$50</span>
                                </div>
                                    <span class="text-sm text-gray-500 mt-1">Post-delivery trash cleanup</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                    <input type="checkbox" name="addons[]" value="heavy_lift-500" data-cost="500" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="ml-2 font-medium text-gray-900">Heavy Lift</span>
                                    <span class="ml-auto font-bold text-blue-700">$500</span>
                                </div>
                                    <span class="text-sm text-gray-500 mt-1">Crane/heavy lift tools</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                        <input type="checkbox" name="addons[]" value="cleaning-100" data-cost="100" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        <span class="ml-2 font-medium text-gray-900">Cleaning (Equipment)</span>
                                        <span class="ml-auto font-bold text-blue-700">$100</span>
                                    </div>
                                    <span class="text-sm text-gray-500 mt-1">Post-unload cleaning</span>
                                </label>
                            </div>
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <label class="flex flex-col h-full cursor-pointer">
                                    <div class="flex items-center mb-1">
                                    <input type="checkbox" name="addons[]" value="storage-50" data-cost="50" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    <span class="ml-2 font-medium text-gray-900">Storage</span>
                                    <span class="ml-auto font-bold text-blue-700">$50</span>
                                </div>
                                    <span class="text-sm text-gray-500 mt-1">Temporary warehousing</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
         </div>
            <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Shipper Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="shipper_email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <div class="relative">
                        <input type="text" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm cursor-not-allowed " required="" disabled autocomplete="off" placeholder="Email" value="<?php echo $userData['email']; ?>">
                        <input type="hidden" name="shipper_email" value="<?php echo $userData['email']; ?>">
                    </div>
                </div>
                <div>
                    <label for="shipper_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                    <div class="relative">
                        <input type="text" id="shipper_phone" name="shipper_phone" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm" required="" autocomplete="off" placeholder="Phone">
                    </div>
                </div>
                <div>
                    <label for="shipper_first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                    <div class="relative">
                        <input type="text" id="shipper_first_name" name="shipper_first_name" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm" required="" autocomplete="off" placeholder="First Name">
                    </div>
                </div>
                <div>
                    <label for="shipper_last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                    <div class="relative">
                        <input type="text" id="shipper_last_name" name="shipper_last_name" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm" required="" autocomplete="off" placeholder="Last Name">
                    </div>
                </div>
                <div class="col-span-2">
                    <label for="shipper_address" class="block text-sm font-medium text-gray-700 mb-1">Address *</label>
                    <div class="relative">
                        <textarea id="shipper_address" name="shipper_address" class="px-2 py-3 border border-gray-400 block w-full rounded-md focus:ring-blue-500 sm:text-sm" required="" autocomplete="off" placeholder="Address"></textarea>
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
  </body>
</html>
