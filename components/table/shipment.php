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
                <?php if(empty($shipments)){ ?>
                <tr>
                    <td colspan="10" class="text-center py-4">No shipments found</td>
                </tr>
                <?php } else{ ?>
                <?php foreach ($shipments as $shipment): ?>
                <tr>
                    <td><?= htmlspecialchars($shipment['name']) ?></td>
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
                            'In Transit' => 'text-blue-700 bg-blue-100',
                            'Delivered' => 'text-green-700 bg-green-100',
                            'Pending' => 'text-orange-700 bg-orange-100',
                            'Cancelled' => 'text-red-700 bg-red-100'
                        ];
                        $statusClass = $statusClasses[$shipment['status']] ?? 'bg-gray-100 text-gray-800';
                        ?>
                        <span class="px-2 py-1 text-xs font-semibold leading-tight rounded-full <?= $statusClass ?>">
                            <?= htmlspecialchars($shipment['status'] ) ?>
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
    $('#shipmentsTable').DataTable({
        dom: "<'p-4'<'mb-4't>p>", // Simplified DOM structure
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
            search: "", // Hide search
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
        }
    });
});
</script>