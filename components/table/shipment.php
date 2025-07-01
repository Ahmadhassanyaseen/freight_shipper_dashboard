<!-- New Table with DataTables -->

<div class="w-full overflow-hidden rounded-lg shadow-xs">
    <div class="w-full overflow-x-auto">
        <table id="shipmentsTable" class="w-full display">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Tracking #</th>
                    <th>Pickup</th>
                    <th>Dropoff</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Weight</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Vendor Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($shipments)) { ?>
                <tr>
                    <td colspan="10" class="text-center py-4">No shipments found</td>
                </tr>
                <?php } else { ?>
                <?php foreach ($shipments as $shipment): ?>
                <tr data-details='<?= htmlspecialchars(json_encode($shipment), ENT_QUOTES, 'UTF-8') ?>' class="cursor-pointer hover:bg-gray-50">
                    <td class="flex items-center">
                        <svg class="toggle-details mr-2" width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        <?= htmlspecialchars($shipment['name']) ?>
                    </td>
                    <td>#<?= htmlspecialchars($shipment['tracking_number']) ?></td>
                    <td><?= htmlspecialchars($shipment['pickup']) ?></td>
                    <td><?= htmlspecialchars($shipment['dropoff']) ?></td>
                    <td><?= htmlspecialchars($shipment['type']) ?></td>
                    <td><?= htmlspecialchars($shipment['quantity']) ?></td>
                    <td><?= htmlspecialchars($shipment['weight']) ?></td>
                    <td><?= htmlspecialchars($shipment['amount']) ?></td>
                    <td>
                        <?php
                        $statusClasses = [
                            'Quoted' => 'text-blue-700 bg-blue-100',
                            'Converted' => 'text-green-700 bg-green-100',
                            'Pending' => 'text-orange-700 bg-orange-100',
                            'Dead' => 'text-red-700 bg-red-100'
                        ];
                        $statusClass = $statusClasses[$shipment['status']] ?? 'bg-gray-100 text-gray-800';
                        ?>
                        <span class="px-2 py-1 text-xs font-semibold leading-tight rounded-full <?= $statusClass ?>">
                            <?= htmlspecialchars($shipment['status']) ?>
                        </span>
                    </td>
                    <td>
                        <?php
                        $statusClasses = [
                            '1' => 'text-green-700 bg-green-100',
                            '0' => 'text-orange-700 bg-orange-100',
                            '-1' => 'text-red-700 bg-red-100'
                        ];
                        $statusClass = $statusClasses[$shipment['vendor_status']] ?? 'bg-gray-100 text-gray-800';
                        ?>
                        <span class="px-2 py-1 text-xs font-semibold leading-tight rounded-full <?= $statusClass ?>">
                            <?= htmlspecialchars($shipment['vendor_status'] == '1' ? 'Accepted' : ($shipment['vendor_status'] == '0' ? 'Pending' : 'Rejected')) ?>
                        </span>
                    </td>
                    <td><?= date('M d, Y', strtotime($shipment['created_at'])) ?></td>
                </tr>
                <tr class="details-row hidden">
                    <td colspan="11" class="px-6 py-4 bg-gray-50 border-b">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="bg-white p-4 rounded-lg shadow">
                                <h4 class="font-semibold text-xl text-gray-700 mb-2">Shipment Information</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="mapouter">
                                            <?php

                                            $first_city = $shipment['pickup'];
                                            $second_city = $shipment['dropoff'];
                                            // echo $first_city;
                                            // Split the string by comma and space
                                            $words = explode(', ', $first_city);
                                            $words2 = explode(', ', $second_city);

                                            // Extract the first word
                                            $first_word = $words[0] . ',' . $words[1] . ',' . $words[2];
                                            $second_word = $words2[0] . ',' . $words2[1] . ',' . $words2[2];
                                            $distanceVal = explode(' ', $shipment['distance']);

                                            $zoomLevel = 10;
                                            if (intval($distanceVal[0]) < 500) {
                                                $zoomLevel = 5;
                                            } elseif (intval($distanceVal[0]) < 1000) {
                                                $zoomLevel = 4;
                                            } elseif (intval($distanceVal[0]) < 1500) {
                                                $zoomLevel = 3;
                                            }

                                            // echo $first_word;

                                            ?>


                                        <div class="gmap_canvas"><iframe width="100%" height="340" id="gmap_canvas" src="<?php echo 'https://maps.google.com/maps?q=' . $first_word . 'to=' . $second_word . '&t=&z=' . $zoomLevel . '&ie=UTF8&iwloc=&output=embed'; ?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.analarmclock.com/"></a><br><a href="https://www.onclock.net/"></a><br>
                                            <style>
                                                .mapouter {
                                                    position: relative;
                                                    text-align: right;
                                                    height: 90%;
                                                    width: 100%;
                                                    border-radius: 10px;
                                                    max-height: 400px;
                                                }
                                            </style>

                                            <style>
                                                .gmap_canvas {
                                                    overflow: hidden;
                                                    background: none !important;
                                                    height: 100%;
                                                    width: 100%;
                                                    border-radius: 10px;
                                                }
                                            </style>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow">
                                <h4 class="font-semibold text-2xl text-gray-700 mb-2">Shipment Information</h4>
                                <div class="space-y-2 text-lg">
                                    <p class="grid grid-cols-2"><span class="font-medium">Distance:</span> <span><?= htmlspecialchars($shipment['distance'] ?? '0') ?> miles</span></p>
                                    <p class="grid grid-cols-2"><span class="font-medium">Mileage:</span> <span> $<?= htmlspecialchars($shipment['mileage'] ?? '0.00') ?></span></p>
                                    <p class="grid grid-cols-2"><span class="font-medium">Fuel:</span> <span> $<?= htmlspecialchars($shipment['fuel'] ?? '0.00') ?></span></p>
                                    <p class="grid grid-cols-2"><span class="font-medium">Addons:</span> <span> $<?= htmlspecialchars($shipment['addons'] ?? '0.00') ?></span></p>
                                    <p class="grid grid-cols-2"><span class="font-medium">Tolls:</span> <span> $<?= htmlspecialchars($shipment['tolls'] ?? '0.00') ?></span></p>
                                    <p class="grid grid-cols-2"><span class="font-medium">Deadhead:</span> <span> $<?= htmlspecialchars($shipment['deadhead'] ?? '0.00') ?></span></p>
                                    <p class="grid grid-cols-2"><span class="font-medium">Total Price:</span> <span> <?= htmlspecialchars($shipment['amount'] ?? '0.00')?></span></p>
                                   
                                </div>
                                <h4 class="font-semibold text-2xl text-gray-700 mb-2 mt-8">Selected Carrier Information</h4>
                                <div class="space-y-2 text-lg">
                                    <p class="grid grid-cols-3"><span class="font-medium">Name:</span> <span class="col-span-2"><?= htmlspecialchars($shipment['vendor_name'] ?? 'N/A') ?></span></p>
                                    <p class="grid grid-cols-3"><span class="font-medium">Email:</span> <span class="col-span-2"><?= htmlspecialchars($shipment['vendor_email'] ?? 'N/A') ?></span></p>
                                    <p class="grid grid-cols-3"><span class="font-medium">Phone:</span> <span class="col-span-2"><?= htmlspecialchars($shipment['vendor_phone'] ?? 'N/A') ?></span></p>
                                    <p class="grid grid-cols-3"><span class="font-medium">Rating:</span> <span class="col-span-2 capitalize"><?= htmlspecialchars(($shipment['vendor_rating'] ? str_replace('_', ' ', $shipment['vendor_rating']) : 'N/A')) ?></span></p>
                                    <p class="grid grid-cols-3"><span class="font-medium">FMCSA:</span> <span class="col-span-2 text-blue-500 cursor-pointer">
                                       
                                        <?php
                                        if($shipment['vendor_fmcsa'] != 'N/A'){
                                            echo '<a href="'.htmlspecialchars($shipment['vendor_fmcsa']).'">'.htmlspecialchars($shipment['vendor_dot']).'</a>';
                                        }else{
                                            echo 'N/A';
                                        }
                                        ?>
                                    </span>
                                    </p>
                                      
                                   
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow">
                                
                                <h4 class="font-semibold text-xl text-gray-700 mb-2">Vendor Quotes</h4>
                                <div class="space-y-2 text-sm">
                                    <?php
                                    // Check if any quote is accepted
                                    $hasAcceptedQuote = false;
                                    foreach($shipment['vendor_quotes'] as $quote) {
                                        if (isset($quote['status']) && $quote['status'] === 'accepted') {
                                            $hasAcceptedQuote = true;
                                            break;
                                        }
                                    }
                                    
                                    foreach($shipment['vendor_quotes'] as $quote){
                                    ?>
                                    <div class="space-y-2 text-sm shadow border border-gray-200 p-2 rounded-lg <?= $quote['status'] == 'accepted' ? 'bg-green-100' : ($quote['status'] == 'rejected' ? 'bg-red-100' : '') ?>">
                                    <p class="grid grid-cols-3 text-sm"><span class="font-medium">Name:</span> <span class="col-span-2"><?= htmlspecialchars($quote['name'] ?? 'N/A') ?></span></p>
                                    <p class="grid grid-cols-3 text-sm"><span class="font-medium">Email:</span> <span class="col-span-2"><?= htmlspecialchars($quote['email'] ?? 'N/A') ?></span></p>
                                    <p class="grid grid-cols-3 text-sm"><span class="font-medium">Phone:</span> <span class="col-span-2"><?= htmlspecialchars($quote['phone'] ?? 'N/A') ?></span></p>
                                    <p class="grid grid-cols-3 text-sm"><span class="font-medium">Quoted Price: </span><span class="col-span-2">$<?= htmlspecialchars($quote['price'] ?? 'N/A') ?></span></p>
                                    <p class="grid grid-cols-3 text-sm"><span class="font-medium">Status:</span><span class="col-span-2"><?= htmlspecialchars($quote['status'] ?? 'N/A') ?></span></p>
                                    <?php if (!$hasAcceptedQuote): ?>
                                    <p class="grid grid-cols-3 text-sm"><span class="font-medium">Action:</span><span class="col-span-2">
                                        <button onclick="acceptQuote('<?= $quote['id'] ?>')" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 rounded cursor-pointer"><i class="fa fa-check"></i></button>
                                        <button onclick="rejectQuote('<?= $quote['id'] ?>')" class="bg-red-500 hover:bg-red-600 text-white py-1 px-2 rounded cursor-pointer"><i class="fa fa-times"></i></button>
                                    </span></p>
                                    <?php endif; ?>
                                    </div>
                        
                                 
                                   <?php
                                   }
                                   ?>
                                   
                                </div>
                            </div>
                            
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add these lines before the closing </body> tag in your layout file -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css"> -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css"> -->


<!-- <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script> -->

<script>
// $(document).ready(function() {
//     $('#shipmentsTable').DataTable({
//         dom: 'Bfrtip',
//         buttons: [
//             'copy', 'csv', 'excel', 'pdf', 'print'
//         ],
//         responsive: true,
//         pageLength: 25,
//         order: [[9, 'desc']], // Sort by date column by default
//         columnDefs: [
//             { orderable: true, targets: '_all' },
//             { className: 'dt-center', targets: [4,5,6,7,8] }
//         ],
//         language: {
//             search: "_INPUT_",
//             searchPlaceholder: "Search shipments...",
//             paginate: {
//                 next: '>',
//                 previous: '<'
//             }
//         }
//     });
// });
$(document).ready(function() {
    // Toggle details row
    $(document).on('click', 'tr[data-details]', function() {
        const $detailsRow = $(this).next('tr.details-row');
        const $icon = $(this).find('.toggle-details');
        
        $detailsRow.slideToggle(200);
        $icon.toggleClass('transform rotate-90');
        
        // Close other open details rows
        $('tr.details-row').not($detailsRow).slideUp(200);
        $('.toggle-details').not($icon).removeClass('transform rotate-90');
    });

    // Initialize DataTable
    const table = $('#shipmentsTable').DataTable({
        dom: "<p-4'<'mb-4't>p>",
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        order: [[10, 'desc']],
        columnDefs: [
            { 
                orderable: true, 
                targets: '_all' 
            },
            { 
                className: 'text-center', 
                targets: [4,5,6,7,8] 
            }
        ],
        language: {
            search: "",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "No entries to show",
            infoFiltered: "",
            paginate: {
                first: '<i class="fas fa-angle-double-left"></i>',
                last: '<i class="fas fa-angle-double-right"></i>',
                next: '<i class="fas fa-chevron-right"></i>',
                previous: '<i class="fas fa-chevron-left"></i>'
            }
        },
        drawCallback: function() {
            // Close all details rows when table is redrawn (sorting, pagination, etc.)
            $('tr.details-row').hide();
            $('.toggle-details').removeClass('transform rotate-90');
        }
    });

    // Prevent row click when clicking on sortable headers
    $('th').on('click', function(e) {
        e.stopPropagation();
    });
});

// Add some custom styles for the details row
const style = document.createElement('style');
style.textContent = `
    .details-row {
        transition: all 0.3s ease;
    }
    .toggle-details {
        transition: transform 0.2s ease;
    }
    .rotate-90 {
        transform: rotate(90deg);
    }
`;
document.head.appendChild(style);

function acceptQuote(id){
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, accept it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: './helper/updateQuote.php',
                type: 'POST',
                data: {id: id, status: 'accepted'},
                success: function(response) {
                    Swal.fire(
                        'Accepted!',
                        'Your quote h   as been accepted.',
                        'success'
                    );
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            });
        }
    });
    

}
function rejectQuote(id){
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, reject it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: './helper/updateQuote.php',
                type: 'POST',
                data: {id: id, status: 'rejected'},
                success: function(response) {
                    Swal.fire(
                        'Rejected!',
                        'Your quote has been rejected.',
                        'success'
                    );
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            });
        }
    });

}
</script>