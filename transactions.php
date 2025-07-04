<?php include 'config/config.php'; ?>
<?php include 'helper/globalHelper.php'; ?>
<?php include 'components/layout/header.php'; ?>
    <?php include 'components/layout/sidebar.php'; ?>
     
      <div class="flex flex-col flex-1 w-full">
       <?php include 'components/layout/topbar.php'; ?>
        <main class="h-full overflow-y-auto pb-10">
          <div class="container px-6 pb-10 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700"
            >
              Transactions
            </h2>
           
            
            
            <?php
            
           // Function to generate random date within last 30 days
function randomDate() {
    $start = strtotime("-30 days");
    $end = time();
    return date('Y-m-d', mt_rand($start, $end));
}

// Function to generate random tracking number
function generateTrackingNumber() {
    return 'TRK' . str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
}

$shipments = [
    [
      'id' => 1,
        'name' => 'John Smith',
        'quantity' => rand(1, 20),
        'type' => 'Boxes',
        'tracking_number' => generateTrackingNumber(),
        'pickup' => 'New York, NY',
        'dropoff' => 'Los Angeles, CA',
        'amount' => '$' . rand(50, 500),
        'status' => 'In Transit',
        'weight' => rand(1, 50) . ' kg',
        'created_at' => randomDate(),
        'vendor_status' => '1'
    ],
    [
      'id' => 2,
        'name' => 'Acme Corp',
        'quantity' => rand(5, 30),
        'type' => 'Pallets',
        'tracking_number' => generateTrackingNumber(),
        'pickup' => 'Chicago, IL',
        'dropoff' => 'Houston, TX',
        'amount' => '$' . rand(200, 800),
        'status' => 'Delivered',
        'weight' => rand(20, 100) . ' kg',
        'created_at' => randomDate(),
        'vendor_status' => '1'
    ],
    [
      'id' => 3,
        'name' => 'Global Imports',
        'quantity' => rand(10, 50),
        'type' => 'Crates',
        'tracking_number' => generateTrackingNumber(),
        'pickup' => 'Miami, FL',
        'dropoff' => 'Atlanta, GA',
        'amount' => '$' . rand(100, 700),
        'status' => 'Pending',
        'weight' => rand(30, 120) . ' kg',
        'created_at' => randomDate(),
        'vendor_status' => '0'
    ],
    [
      'id' => 4,
        'name' => 'Tech Solutions Inc',
        'quantity' => rand(2, 15),
        'type' => 'Parcels',
        'tracking_number' => generateTrackingNumber(),
        'pickup' => 'Seattle, WA',
        'dropoff' => 'Portland, OR',
        'amount' => '$' . rand(80, 400),
        'status' => 'In Transit',
        'weight' => rand(5, 30) . ' kg',
        'created_at' => randomDate(),
        'vendor_status' => '1'
    ],
    [
      'id' => 5,
        'name' => 'Fresh Foods Ltd',
        'quantity' => rand(5, 25),
        'type' => 'Refrigerated',
        'tracking_number' => generateTrackingNumber(),
        'pickup' => 'Denver, CO',
        'dropoff' => 'Salt Lake City, UT',
        'amount' => '$' . rand(300, 1000),
        'status' => 'Cancelled',
        'weight' => rand(50, 200) . ' kg',
        'created_at' => randomDate(),
        'vendor_status' => '-1'
    ],
    [
      'id' => 6,
        'name' => 'Fashion Forward',
        'quantity' => rand(15, 40),
        'type' => 'Garments',
        'tracking_number' => generateTrackingNumber(),
        'pickup' => 'Los Angeles, CA',
        'dropoff' => 'Las Vegas, NV',
        'amount' => '$' . rand(150, 600),
        'status' => 'Delivered',
        'weight' => rand(10, 50) . ' kg',
        'created_at' => randomDate(),
        'vendor_status' => '1'
    ],
    [
      'id' => 7,
        'name' => 'Office Supplies Co',
        'quantity' => rand(8, 35),
        'type' => 'Cartons',
        'tracking_number' => generateTrackingNumber(),
        'pickup' => 'Boston, MA',
        'dropoff' => 'Philadelphia, PA',
        'amount' => '$' . rand(200, 900),
        'status' => 'In Transit',
        'weight' => rand(25, 100) . ' kg',
        'created_at' => randomDate(),
        'vendor_status' => '-1'
    ],
    [
      'id' => 8,
        'name' => 'Auto Parts Express',
        'quantity' => rand(1, 10),
        'type' => 'Heavy Machinery',
        'tracking_number' => generateTrackingNumber(),
        'pickup' => 'Detroit, MI',
        'dropoff' => 'Cleveland, OH',
        'amount' => '$' . rand(400, 1200),
        'status' => 'Pending',
        'weight' => rand(100, 500) . ' kg',
        'created_at' => randomDate(),
        'vendor_status' => '0'
    ]
];
            ?>

           <?php include 'components/table/shipment.php'; ?>

           
          </div>
        </main>
      </div>
    </div>
  </body>
</html>
