<!-- New Table with DataTables -->
<style>
    .xeno-table tbody tr:nth-child(odd) {
        background-color:#f27474;
        color: #fff;
    }
        
</style>
<div class="w-full overflow-hidden rounded-lg shadow-xs bg-white dark:bg-gray-800 text-gray-700 dark:text-white">
    <div class="w-full overflow-x-auto">
        <table id="shipmentsTable" class="w-full display xeno-table" >
            <thead class="text-white">
                <tr>
                    <th class="bg-blue-500 rounded-tl-xl ">Customer</th>
                    <th class="bg-blue-500 ">Tracking #</th>
                    <th class="bg-blue-500 ">Pickup</th>
                    <th class="bg-blue-500 ">Dropoff</th>
                    <th class="bg-blue-500 ">Type</th>
                    <th class="bg-blue-500 ">Quantity</th>
                    <th class="bg-blue-500 ">Weight</th>
                    <th class="bg-blue-500 ">Amount</th>
                    <th class="truncate bg-blue-500 ">Lead Status</th>
                    <th class="truncate bg-blue-500 ">Vendor Status</th>
                    <th class="bg-blue-500 ">Date</th>
                    <th class="bg-blue-500 rounded-tr-xl ">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($shipments)){ ?>
                <tr>
                    <td colspan="10" class="text-center py-4 text-gray-700 dark:text-white bg-gray-100 dark:bg-gray-700">No shipments found</td>
                </tr>
                <?php } else{ ?>
                <?php foreach ($shipments as $shipment): ?>
                <tr class="bg-white dark:bg-gray-800">
                    <td class="truncate"><?= htmlspecialchars(html_entity_decode($shipment['name']), ENT_QUOTES | ENT_HTML5) ?></td>
                    <td>#<?= htmlspecialchars($shipment['tracking_number']) ?></td>
                    <td class="truncate"><?= htmlspecialchars(html_entity_decode($shipment['pickup']), ENT_QUOTES | ENT_HTML5) ?></td>
                    <td class="truncate"><?= htmlspecialchars(html_entity_decode($shipment['dropoff']), ENT_QUOTES | ENT_HTML5) ?></td>
                    <td><?= htmlspecialchars($shipment['type']) ?></td>
                    <td><?= htmlspecialchars($shipment['quantity']) ?></td>
                    <td><?= htmlspecialchars($shipment['weight']) ?></td>
                    <td><?= htmlspecialchars($shipment['amount']) ?></td>

                    <td>
                        <?php
                        $statusClasses = [
                            
                            'Converted' => 'text-green-700 bg-green-100',
                            'Pending' => 'text-orange-700 bg-orange-100',
                            'Assigned' => 'text-orange-700 bg-orange-100',
                            'Deleted' => 'text-red-700 bg-red-100',
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
                    <td class="truncate"><?= date('m-d-Y', strtotime($shipment['created_at'])) ?></td>
                    <td class="flex">
                        <button class="cursor-pointer  text-white py-2 px-4 rounded mr-2 edit-shipment bg-primary-color" 

                        data-id="<?= $shipment['signed_agreement_link'] ?>"
                        >
                           <i class="fas fa-eye"></i>
                        </button>
                       
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<script>

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

$(document).on('click', '.edit-shipment', function() {
    var shipmentId = $(this).data('id');
    window.location.href = shipmentId;
    console.log(shipmentId);
});



</script>