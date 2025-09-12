
<?php
if (isset($_COOKIE["user"])) {
    $userData = json_decode($_COOKIE["user"], true);
} else {
    $userData = [];
}
?>
<?php include 'config/config.php'; ?>
<?php include 'components/layout/header.php'; ?>
<?php include 'components/layout/sidebar.php'; ?>

<div class="flex flex-col flex-1 w-full">
    <?php include 'components/layout/topbar.php'; ?>
    <main class="h-full overflow-y-auto">
        <div class="px-6 pb-10 mx-auto">
            <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold my-6 tracking-tight neon-red-header">
                    Lane Rate
                </h1>
            </div>

            <!-- Rate Check Form -->
            <div class="bgRed rounded-lg shadow p-6 mb-6">
                <form id="rateCheckForm" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 hover-lift glassmorphism-card bgBlue">
                        <div class="">
                            <label for="pickup" class="block text-sm font-medium text-white mb-1">Pickup Location</label>
                            <input type="text" id="pickup" name="pickup" 
                                   class="w-full px-4 modern-input bg-white py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="Enter pickup location" required>
                        </div>
                        <div>
                            <label for="destination" class="block text-sm font-medium text-white mb-1">Delivery Location</label>
                            <input type="text" id="destination" name="destination" 
                                   class="w-full modern-input px-4 bg-white py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="Enter delivery location" required>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="px-4 py-2 bgBlue text-white rounded-md hover-lift focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Check Rates
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <div id="rateResults" class="hidden bgRed rounded-lg shadow p-6">
                <div class="animate-pulse">
                    <div class="h-6 bg-gray-200 dark:bg-gray-700 rounded w-1/3 mb-4"></div>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="h-24 bg-gray-200 dark:bg-gray-700 rounded"></div>
                            <div class="h-24 bg-gray-200 dark:bg-gray-700 rounded"></div>
                            <div class="h-24 bg-gray-200 dark:bg-gray-700 rounded"></div>
                        </div>
                        <div class="h-32 bg-gray-200 dark:bg-gray-700 rounded"></div>
                    </div>
                </div>
                
                <!-- Actual results will be populated here -->
                <div id="rateData" class="hidden">
                    <!-- Rate data will be populated here by JavaScript -->
                </div>
            </div>
        </div>
    </main>
</div>

<script>
// Initialize Google Maps Places API
document.addEventListener('DOMContentLoaded', function() {
    // Load Google Maps Places API
    const script = document.createElement('script');
    script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyA-XmAtSvNj2CjcYT7VRfnIk58aGsdeh7k&libraries=places&callback=initAutocomplete';
    script.async = true;
    script.defer = true;
    document.head.appendChild(script);
});

// Global function for Google Maps callback
window.initAutocomplete = function() {
    const pickupInput = document.getElementById('pickup');
    const destinationInput = document.getElementById('destination');
    
    const options = {
        componentRestrictions: { country: 'us' },
        fields: ['formatted_address', 'geometry', 'name'],
        types: ['(cities)']
    };
    
    const pickupAutocomplete = new google.maps.places.Autocomplete(pickupInput, options);
    const destinationAutocomplete = new google.maps.places.Autocomplete(destinationInput, options);
};

// Function to format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(amount);
}

// Function to format number with commas
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

// Function to display rate data
function displayRateData(data) {
    // Validate data structure
    if (!data || !data.data || typeof data.data !== 'object') {
        console.error('Invalid data format received:', data);
        throw new Error('Invalid data format received from server');
    }
    
    // Ensure required fields exist
    const requiredFields = [
        'averageRateForMileage', 'rateMileage', 'avgRatePerMile',
        'linehaulRevenue', 'fuelCost', 'mpg', 'tollCosts', 'finalLevel',
        'rateIncludesFuelSurcharge'
    ];
    
    const missingFields = requiredFields.filter(field => data.data[field] === undefined);
    if (missingFields.length > 0) {
        console.error('Missing required fields in response:', missingFields);
        throw new Error(`Missing required data: ${missingFields.join(', ')}`);
    }
    const rateDataDiv = document.getElementById('rateData');
    const skeleton = document.querySelector('#rateResults .animate-pulse');
    
    // Hide skeleton and show actual data
    skeleton.classList.add('hidden');
    rateDataDiv.classList.remove('hidden');
    
    // Format the data for display
    rateDataDiv.innerHTML = `
        <div class="mb-6 bgRed">
            <h3 class="text-lg font-semibold text-white mb-4">
                Rate Details for ${data.pickup_location} to ${data.dropoff_location}
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class=" p-4 rounded-lg">
                    <h4 class="text-sm font-medium text-white mb-1">Estimated Rate</h4>
                    <p class="text-2xl font-bold text-white">${formatCurrency(data.data.averageRateForMileage)}</p>
                    <p class="text-xs text-white mt-1">Based on market rates</p>
                </div>
                
                <div class=" p-4 rounded-lg">
                    <h4 class="text-sm font-medium text-white mb-1">Distance</h4>
                    <p class="text-2xl font-bold text-white">${formatNumber(Math.round(data.data.rateMileage))} miles</p>
                    <p class="text-xs text-white mt-1">Approximate distance</p>
                </div>
                
                <div class=" p-4 rounded-lg">
                    <h4 class="text-sm font-medium text-white mb-1">Rate per Mile</h4>
                    <p class="text-2xl font-bold text-white">${data.data.avgRatePerMile.toFixed(2)}/mi</p>
                    <p class="text-xs text-white mt-1">Average rate per mile</p>
                </div>
            </div>
            
            <div class="bgRed border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h4 class="text-base font-medium text-white">Rate Breakdown</h4>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="px-6 py-4">
                            <p class="text-sm text-white">Linehaul Revenue</p>
                            <p class="font-medium text-white">${formatCurrency(data.data.linehaulRevenue)}</p>
                        </div>
                        <div class="px-6 py-4">
                            <p class="text-sm text-white">Fuel Cost (${data.data.mpg} MPG)</p>
                            <p class="font-medium text-white">${formatCurrency(data.data.fuelCost)}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="px-6 py-4">
                            <p class="text-sm text-white">Toll Costs</p>
                            <p class="font-medium text-white">${formatCurrency(data.data.tollCosts)}</p>
                        </div>
                        <div class="px-6 py-4">
                            <p class="text-sm text-white">Rate Level</p>
                            <p class="font-medium text-white">${data.data.finalLevel}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 text-xs text-white">
                <p>Note: These rates are estimates based on current market conditions and may vary. Fuel surcharge ${data.data.rateIncludesFuelSurcharge ? 'is' : 'is not'} included.</p>
                <p class="mt-1">Last updated: ${new Date(data.timestamp).toLocaleString()}</p>
            </div>
        </div>
    `;
}

// Handle form submission
document.getElementById('rateCheckForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const pickup = document.getElementById('pickup').value;
    const destination = document.getElementById('destination').value;
    
    if (!pickup || !destination) {
        alert('Please enter both pickup and delivery locations');
        return;
    }
    
    // Show loading skeleton
    const resultsDiv = document.getElementById('rateResults');
    const rateDataDiv = document.getElementById('rateData');
    const skeleton = document.querySelector('#rateResults .animate-pulse');
    
    resultsDiv.classList.remove('hidden');
    skeleton.classList.remove('hidden');
    rateDataDiv.classList.add('hidden');
    
    try {
        // Encode the locations for the URL
        // const encodedPickup = encodeURIComponent(pickup);
        // const encodedDestination = encodeURIComponent(destination);
        // const apiUrl = `https://stretchxlfreight.com/xion/rate.php?pickup=${encodedPickup}&dropoff=${encodedDestination}`;
        
        // Show loading state
        const submitButton = this.querySelector('button[type="submit"]');
        const originalButtonText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Fetching rates...
        `;
        
        // Make the API request
        const formData = new FormData();
        formData.append('pickup_address', pickup);
        formData.append('dropoff_address', destination);
        
        const response = await fetch('https://stretchxlfreight.com/xion/lane-rate.php', {
            method: 'POST',
            body: formData
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        // Add the locations to the response data for display
        data.pickup_location = pickup;
        data.dropoff_location = destination;
        
        // Display the rate data
        displayRateData(data);
        
    } catch (error) {
        console.error('Error fetching rate data:', error);
        
        // Show error message
        const skeleton = document.querySelector('#rateResults .animate-pulse');
        skeleton.classList.add('hidden');
        
        const rateDataDiv = document.getElementById('rateData');
        rateDataDiv.classList.remove('hidden');
        rateDataDiv.innerHTML = `
            <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Error fetching rates</h3>
                        <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                            <p>We couldn't fetch the rate information. Please try again later.</p>
                            ${error.message ? `<p class="mt-1 text-xs">${error.message}</p>` : ''}
                        </div>
                    </div>
                </div>
            </div>
        `;
    } finally {
        // Reset button state
        const submitButton = document.querySelector('#rateCheckForm button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.innerHTML = 'Check Rates';
        }
    }
});
</script>

</body>
</html>
