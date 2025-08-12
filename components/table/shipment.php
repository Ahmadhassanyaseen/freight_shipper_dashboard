
<style>
    .mapouter {
        position: relative;
        text-align: right;
        height: 90%;
        width: 100%;
        border-radius: 10px;
        max-height: 400px;
    }
    .gmap_canvas {
        overflow: hidden;
        background: none !important;
        height: 100%;
        width: 100%;
        border-radius: 10px;
    }
    .toggle-details {
        cursor: pointer;
        transition: transform 0.2s;
    }
    .toggle-details.rotate-45 {
        transform: rotate(45deg);
    }
    table.dataTable thead>tr>th.sorting:before,table.dataTable thead>tr>th.sorting:after{
        display: none;
    }
</style>

<table id="shipmentsTable" class="w-full display dataTable no-footer bg-white text-gray-700 dark:bg-gray-800 dark:text-white">
    <thead>
        <tr>
            <th></th> 
            <th>Created</th>
            <th>Customer</th>
            <th class="truncate">Tracking #</th>
            <th>Pickup</th>
            <th>Dropoff</th>
            <th class="truncate-x">Type</th>
            <th>Quantity</th>
            <th>Weight</th>
            <th>Amount</th>
            <th>Status</th>
            <th class="truncate-x">Vendor Status</th>
            <th class="truncate-x">Pickup Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($shipments as $shipment): ?>
        <tr data-details='<?php echo htmlspecialchars(json_encode($shipment), ENT_QUOTES, 'UTF-8'); ?>' class="cursor-pointer hover:bg-gray-50 dark:bg-gray-700 bg-white">
            <td class="flex items-center toggle-details ">
                <svg class=" mr-2" width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4  Maui 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </td>
            <td class="toggle-details truncate"><?= htmlspecialchars(date('m-d-Y', strtotime($shipment['created_at']))) ?></td>
            <td class="toggle-details truncate"><?= htmlspecialchars(htmlspecialchars_decode($shipment['name'])) ?></td>
            <td class="toggle-details"><?= htmlspecialchars($shipment['tracking_number']) ?></td>
            <td class="toggle-details truncate"><?= htmlspecialchars($shipment['pickup']) ?></td>
            <td class="toggle-details truncate"><?= htmlspecialchars($shipment['dropoff']) ?></td>
            <td class="toggle-details truncate-x"><?= htmlspecialchars($shipment['type']) ?></td>
            <td class="toggle-details"><?= htmlspecialchars($shipment['quantity']) ?></td>
            <td class="toggle-details"><?= htmlspecialchars($shipment['weight']) ?></td>
            <td class="toggle-details"><?= htmlspecialchars($shipment['amount']) ?></td>
            
            <td class="toggle-details">
                <span class="px-2 py-1 text-xs font-semibold leading-tight rounded-full <?php
                if($shipment['status'] == 'Quoted'){
                    echo 'bg-blue-100 text-blue-800';
                }else if($shipment['status'] == 'Converted'){
                    echo 'bg-green-100 text-green-800';
                }else if($shipment['status'] == 'Pending'){
                    echo 'bg-orange-100 text-orange-800';
                }else if($shipment['status'] == 'Dead' || $shipment['status'] == 'Deleted'){
                    echo 'bg-red-100 text-red-800';
                }else if($shipment['status'] == 'Assigned'){
                    echo 'bg-gray-100 text-gray-800';
                }
                ?>"><?= htmlspecialchars($shipment['status']) ?><span class="ml-1 font-semibold leading-tight"><?php 
               if(isset($shipment['vendor_quotes']) && isset($shipment['tp_quotes'])) {
                   echo count($shipment['vendor_quotes']) + count($shipment['tp_quotes']);
               }else if(isset($shipment['vendor_quotes'])) {
                   echo count($shipment['vendor_quotes']);
               ;
               } ?></span></span></td>
            <td class="toggle-details">
                <span class="px-2 py-1 text-xs font-semibold leading-tight rounded-full <?php
                if($shipment['vendor_status'] == '1'){
                    echo 'bg-green-100 text-green-800';
                }else if($shipment['vendor_status'] == '0'){
                    echo 'bg-orange-100 text-orange-800';
                }else if($shipment['vendor_status'] == '-1'){
                    echo 'bg-red-100 text-red-800';
                }
                ?>"><?php
                if($shipment['vendor_status'] == '1'){
                    echo 'Accepted';
                }else if($shipment['vendor_status'] == '0'){
                    echo 'Pending';
                }else if($shipment['vendor_status'] == '-1'){
                    echo 'Rejected';
                }  ?></span></td>
            <td class="toggle-details truncate-x"><?= htmlspecialchars(date('m-d-Y', strtotime($shipment['pickup_date']))) ?></td>
            <td class="toggle-details">
                <button class=" text-white py-1 px-2 rounded 
                <?php if($shipment['status'] == 'Deleted' || $shipment['status'] == 'Dead') {echo 'bg-gray-500 cursor-not-allowed';} else {echo 'bg-blue-500 hover:bg-blue-600 cursor-pointer';} ?>
                " onclick="editShipment('<?= htmlspecialchars($shipment['id']) ?>')" 
                
                <?php if($shipment['status'] == 'Deleted' || $shipment['status'] == 'Dead') {echo 'disabled';} ?>
                >
                    <i class="fa fa-edit"></i>
                </button>
                <button class=" text-white py-1 px-2 rounded
                <?php if($shipment['status'] == 'Deleted' || $shipment['status'] == 'Dead') {echo 'bg-gray-500 cursor-not-allowed';} else {echo 'bg-red-500 hover:bg-red-600 cursor-pointer';} ?>
                " onclick="deleteShipment('<?= htmlspecialchars($shipment['id']) ?>')"
                <?php if($shipment['status'] == 'Deleted' || $shipment['status'] == 'Dead') {echo 'disabled';} ?>
                >
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<script>

$(document).ready(function() {
    const table = $('#shipmentsTable').DataTable({
        searching: false,
        lengthChange: false,
        columns: [
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <svg class="toggle-details mr-2" width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>`;
                }
            },
            { data: 'created_at' },
            { data: 'name' },
            { data: 'tracking_number' },
            { data: 'pickup' },
            { data: 'dropoff' },
            { data: 'type' },
            { data: 'quantity' },
            { data: 'weight' },
            { data: 'amount' },
            { data: 'status' },
            { data: 'vendor_status' },
            { data: 'pickup_date' },
            { data: 'action' }
        ],
        order: [[1, 'desc']], // Sort by Date column
        createdRow: function(row, data, dataIndex) {
            // Store the data-details JSON for the row
            const details = $(row).data('details');
            $(row).data('details-json', details);
        }

    });

    // Toggle click handler for details
    $('#shipmentsTable tbody').on('click', 'td.toggle-details', function() {
        const tr = $(this).closest('tr');
        const row = table.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            // $(this).removeClass('rotate-45');
        } else {
            const details = tr.data('details-json');
            row.child(formatDetails(details)).show();
            // $(this).addClass('rotate-45');
        }
    });
});

// Function to format the details row content
function formatDetails(data) {
    const details = typeof data === 'string' ? JSON.parse(data) : data;
    // Store the details in a global variable for later use
    window.currentShipmentDetails = details;
    
    // Generate map URL
    const pickup = details.pickup.split(', ').slice(0, 3).join(',');
    const dropoff = details.dropoff.split(', ').slice(0, 3).join(',');
    const distance = parseFloat(details.distance);
    const zoomLevel = distance < 500 ? 5 : distance < 1000 ? 4 : distance < 1500 ? 3 : 2;
    const mapUrl = `https://maps.google.com/maps?q=${pickup}to=${dropoff}&t=&z=${zoomLevel}&ie=UTF8&iwloc=&output=embed`;

    // Generate vendor quotes HTML
    // let quotesHtml = details.tp_quotes.length || details.vendor_quotes.length ? '' : '<p>No quotes available</p>';
    let quotesHtml = '';
    const hasAcceptedQuote = details.vendor_quotes?.some(quote => quote.status === 'accepted');
    details.vendor_quotes?.forEach(quote => {
        const statusClass = quote.status === 'accepted' ? 'bg-green-100 text-gray-700' : quote.status === 'rejected' ? 'bg-red-100 text-gray-700' : '';
        const showActions = quote.status == 'rejected' || quote.status == 'accepted' || details.status == 'Converted' || details.status == 'Dead' || details.status == 'Deleted' ? false : true;
        quotesHtml += `
            <div class="quote-card space-y-2 text-sm shadow border border-gray-200 p-2 rounded-lg ${statusClass}">
                <p class="grid grid-cols-3 text-sm"><span class="font-medium">Source:</span> <span class="col-span-2">XL</span></p>
                <p class="grid grid-cols-3 text-sm"><span class="font-medium">Name:</span> <span class="col-span-2">${quote.name || 'N/A'}</span></p>
                <p class="grid grid-cols-3 text-sm"><span class="font-medium">Email:</span> <span class="col-span-2">${quote.email || 'N/A'}</span></p>
                <p class="grid grid-cols-3 text-sm"><span class="font-medium">Phone:</span> <span class="col-span-2">${quote.phone || 'N/A'}</span></p>
                <p class="grid grid-cols-3 text-sm"><span class="font-medium">Quoted Price:</span> <span class="col-span-2">$${quote.price || 'N/A'}</span></p>
                <p class="grid grid-cols-3 text-sm"><span class="font-medium">Status:</span> <span class="col-span-2">${quote.status || 'N/A'}</span></p>
                ${showActions && !hasAcceptedQuote ? `
                <p class="grid grid-cols-3 text-sm"><span class="font-medium">Action:</span><span class="col-span-2">
                    <button onclick="acceptQuote('${details.id}', '${quote.id}' , '${encodeURIComponent(JSON.stringify(quote))}')" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 rounded cursor-pointer"><i class="fa fa-check"></i></button>
                    <button onclick="rejectQuote('${quote.id}')" class="bg-red-500 hover:bg-red-600 text-white py-1 px-2 rounded cursor-pointer"><i class="fa fa-times"></i></button>
                     <button onclick="viewVendor(event, '${quote.id}', 'xl')" class="bg-green-500 hover:bg-green-600 text-white py-1 px-2 rounded cursor-pointer"><i class="fa fa-eye"></i></button>
                </span></p>` : ''}
            </div>`;
    });
    // let tpQuotesHtml = details.tp_quotes.length || details.vendor_quotes.length > 0 ? '' : '<p>No TruckersPath quotes available</p>';
    let tpQuotesHtml = '';
    const hasAcceptedQuoteTP = details.tp_quotes?.some(quote => quote.status === 'accepted');
    details.tp_quotes?.forEach(quote => {
        const statusClass = quote.status === 'accepted' ? 'bg-green-100 text-gray-700' : quote.status === 'rejected' ? 'bg-red-100 text-gray-700' : '';
        const showActions = quote.status == 'rejected' || quote.status == 'accepted' || details.status == 'Converted' || details.status == 'Dead' || details.status == 'Deleted' ? false : true;
        tpQuotesHtml += `
            <div class="quote-card space-y-2 text-sm shadow border border-gray-200 p-2 rounded-lg ${statusClass}">
                <p class="grid grid-cols-3 text-sm"><span class="font-medium">Name:</span> <span class="col-span-2">${quote.contact.name || 'N/A'}</span></p>
                 <p class="grid grid-cols-3 text-sm"><span class="font-medium">Source:</span> <span class="col-span-2">TP</span></p>
                <p class="grid grid-cols-3 text-sm"><span class="font-medium">Email:</span> <span class="col-span-2">${quote.contact.email || 'N/A'}</span></p>
                <p class="grid grid-cols-3 text-sm"><span class="font-medium">Phone:</span> <span class="col-span-2">${quote.contact.phone || 'N/A'}</span></p>
                <p class="grid grid-cols-3 text-sm"><span class="font-medium">Quoted Price:</span> <span class="col-span-2">$${quote.priceCents || 'N/A'}</span></p>
                <p class="grid grid-cols-3 text-sm"><span class="font-medium">Status:</span> <span class="col-span-2">${quote.status || 'N/A'}</span></p>
                ${showActions && !hasAcceptedQuoteTP ? `
                <p class="grid grid-cols-3 text-sm"><span class="font-medium">Action:</span><span class="col-span-2">
                    <button onclick="acceptQuote('${details.id}', '${quote.id}' , '${encodeURIComponent(JSON.stringify(quote))}')" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 rounded cursor-pointer"><i class="fa fa-check"></i></button>
                    <button onclick="rejectQuote('${quote.id}')" class="bg-red-500 hover:bg-red-600 text-white py-1 px-2 rounded cursor-pointer"><i class="fa fa-times"></i></button>
                    <button onclick="viewVendor(event, '${quote.id}', 'tp')" class="bg-green-500 hover:bg-green-600 text-white py-1 px-2 rounded cursor-pointer"><i class="fa fa-eye"></i></button>
                </span></p>` : ''}
            </div>`;
    });

    // let finalQuotesHtml = quotesHtml + tpQuotesHtml;
    finalQuotesHtml = quotesHtml + tpQuotesHtml;
    if(quotesHtml == '' && tpQuotesHtml == ''){
      finalQuotesHtml = '<p>No quotes available</p>';
    }
    
    let selectedCarrierHtml = '';
    if(details.vendor_quotes && details.vendor_quotes.length > 0){
      selectedCarrierHtml = `
                <h4 class="font-semibold text-xl text-gray-700 dark:text-white mb-2 mt-8">Selected Carrier Information</h4>
                <div class="selected-carrier-section space-y-2 text-md">
                    <p class="grid grid-cols-3"><span class="font-medium" >Name:</span> <span class="col-span-2" id="vendor_name_${details.vendor_quotes[0].id}">${details.vendor_name}</span></p>
                    <p class="grid grid-cols-3"><span class="font-medium" >Email:</span> <span class="col-span-2" id="vendor_email_${details.vendor_quotes[0].id}">${details.vendor_email}</span></p>
                    <p class="grid grid-cols-3"><span class="font-medium" >Phone:</span> <span class="col-span-2" id="vendor_phone_${details.vendor_quotes[0].id}">${details.vendor_phone}</span></p>
                    <p class="grid grid-cols-3"><span class="font-medium" >Rating:</span> <span class="col-span-2 capitalize" id="vendor_rating_${details.vendor_quotes[0].id}">${details.vendor_rating ? details.vendor_rating.replace('_', ' ') : ''}</span></p>
                    <p class="grid grid-cols-3"><span class="font-medium" >FMCSA:</span> <span class="col-span-2 text-blue-500 cursor-pointer" id="vendor_fmcsa_${details.vendor_quotes[0].id}">
                        ${details.vendor_fmcsa && details.vendor_fmcsa !== 'http://' ? `<a href="${details.vendor_fmcsa}" target="_blank">${details.vendor_dot || ''}</a>` : (details.vendor_dot || '')}
                    </span></p>
                </div>
                `;
    }
    if(details.tp_quotes && details.tp_quotes.length > 0){
      selectedCarrierHtml = `
                <h4 class="font-semibold text-xl text-gray-700 dark:text-white mb-2 mt-8">Selected Carrier Information</h4>
                <div class="selected-carrier-section space-y-2 text-md">
                    <p class="grid grid-cols-3"><span class="font-medium" >Name:</span> <span class="col-span-2" id="tp_name_${details.tp_quotes[0].id}">${details.tp_quotes[0].contact.name}</span></p>
                    <p class="grid grid-cols-3"><span class="font-medium" >Email:</span> <span class="col-span-2" id="tp_email_${details.tp_quotes[0].id}">${details.tp_quotes[0].contact.email}</span></p>
                    <p class="grid grid-cols-3"><span class="font-medium" >Phone:</span> <span class="col-span-2" id="tp_phone_${details.tp_quotes[0].id}">${details.tp_quotes[0].contact.phone}</span></p>
                    <p class="grid grid-cols-3"><span class="font-medium" >Rating:</span> <span class="col-span-2 capitalize" id="tp_rating_${details.tp_quotes[0].id}">${details.tp_quotes[0].company.safetyRating}</span></p>
                    <p class="grid grid-cols-3"><span class="font-medium" >FMCSA:</span> <span class="col-span-2 text-blue-500 cursor-pointer" id="tp_fmcsa_${details.tp_quotes[0].id}">
                        ${details.tp_quotes[0].company.dot && details.tp_quotes[0].company.dot !== 'http://' ? `<a href="${details.tp_quotes[0].company.dot}" target="_blank">${details.tp_quotes[0].company.dot || ''}</a>` : (details.tp_quotes[0].company.dot || '')}
                    </span></p>
                </div>
                `;
    }
    

    return `
        <div class="flex gap-4">
            <div class="bg-white text-gray-700 p-4 rounded-lg shadow dark:bg-gray-700 dark:text-white w-full">
                <h4 class="font-semibold text-xl text-gray-700 dark:text-white mb-2">Route Information</h4>
                <div class="space-y-2 text-sm">
                    <div class="mapouter">
                        <div class="gmap_canvas">
                            <iframe width="100%" height="340" src="${mapUrl}" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white text-gray-700 p-4 rounded-lg shadow dark:bg-gray-700 dark:text-white w-full">
                <h4 class="font-semibold text-xl text-gray-700 dark:text-white mb-2">Shipment Information</h4>
                <div class="space-y-2 text-md">
                    <p class="grid grid-cols-2"><span class="font-medium">Distance:</span> <span>${details.distance} miles</span></p>
                    <p class="grid grid-cols-2"><span class="font-medium">Mileage:</span> <span>$${details.mileage}</span></p>
                    <p class="grid grid-cols-2"><span class="font-medium">Fuel:</span> <span>$${details.fuel}</span></p>
                    <p class="grid grid-cols-2"><span class="font-medium">Addons:</span> <span>$${details.addons}</span></p>
                    <p class="grid grid-cols-2"><span class="font-medium">Tolls:</span> <span>$${details.tolls}</span></p>
                    <p class="grid grid-cols-2"><span class="font-medium">Deadhead:</span> <span>$${details.deadhead}</span></p>
                    <p class="grid grid-cols-2"><span class="font-medium">Total Price:</span> <span>${details.amount}</span></p>
                </div>
                ${selectedCarrierHtml}
            </div>
            <div class="bg-white text-gray-700 p-4 rounded-lg shadow dark:bg-gray-700 dark:text-white w-full">
                <h4 class="font-semibold text-xl text-gray-700 dark:text-white mb-2">Carrier Quotes</h4>
                <div class="space-y-2 text-sm">${finalQuotesHtml}</div>
            </div>
           
        </div>
    `;
}

// Placeholder for accept/reject quote functions (define these based on your backend)
function acceptQuote(id, quoteId , quote){
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
            console.log('Accepting quote...');
            // window.location.href = 'agreement.php?id=' + id + '&quote_id=' + quoteId + '&quote=' + quote;
            // Redirect to agreement.php with parameters
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'agreement.php';
            
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'id';
            idInput.value = id;
            
            const quoteIdInput = document.createElement('input');
            quoteIdInput.type = 'hidden';
            quoteIdInput.name = 'quote_id';
            quoteIdInput.value = quoteId;
            
            const quoteInput = document.createElement('input');
            quoteInput.type = 'hidden';
            quoteInput.name = 'quote';
            quoteInput.value = decodeURIComponent(quote);
            
            form.appendChild(idInput);
            form.appendChild(quoteIdInput);
            form.appendChild(quoteInput);
            
            document.body.appendChild(form);
            form.submit();
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
function deleteShipment(id){
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: './helper/load/delete.php',
                type: 'POST',
                data: {id: id},
                success: function(response) {
                    console.log(response);
                    Swal.fire(
                        'Deleted!',
                        'Your shipment has been deleted.',
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

function editShipment(id){
    window.location.href = './editLoad.php?id=' + id;
}

function viewVendor(event, id, type) {
    event.preventDefault();
    event.stopPropagation();
    
    console.log('View vendor clicked:', { id, type });
    
    // Get the details from the global variable set in formatDetails
    const details = window.currentShipmentDetails || {};
    console.log('Current shipment details:', details);
    
    // Ensure we have the necessary arrays
    if (!details.tp_quotes) details.tp_quotes = [];
    if (!details.vendor_quotes) details.vendor_quotes = [];
    
    let quote, carrierInfo = '';
    
    // Find the quote based on type
    if (type === 'tp') {
        quote = details.tp_quotes.find(q => q.id == id || q.id === String(id));
        console.log('TP Quote found:', quote);
        
        if (quote) {
            const safetyRating = quote.company?.safetyRating || '';
            const ratingClass = safetyRating.toLowerCase() === 'satisfactory' ? 'text-green-500' : 'text-red-500';
            
            carrierInfo = `
                <div class="selected-carrier-section">
                   
                    <div class="space-y-2 text-md bg-white p-4 rounded-lg shadow">
                        <p class="grid grid-cols-3"><span class="font-medium">Name:</span> <span class="col-span-2">${quote.contact?.name || 'N/A'}</span></p>
                        <p class="grid grid-cols-3"><span class="font-medium">Email:</span> <span class="col-span-2">${quote.contact?.email || 'N/A'}</span></p>
                        <p class="grid grid-cols-3"><span class="font-medium">Phone:</span> <span class="col-span-2">${quote.contact?.phone || 'N/A'}</span></p>
                        <p class="grid grid-cols-3"><span class="font-medium">Company:</span> <span class="col-span-2">${quote.company?.name || 'N/A'}</span></p>
                        <p class="grid grid-cols-3"><span class="font-medium">DOT:</span> <span class="col-span-2">${quote.company?.dot || 'N/A'}</span></p>
                        <p class="grid grid-cols-3">
                            <span class="font-medium">Safety Rating:</span> 
                            <span class="col-span-2 ${ratingClass}">
                                ${safetyRating || 'N/A'}
                            </span>
                        </p>
                        <p class="grid grid-cols-3">
                            <span class="font-medium">Quote Amount:</span> 
                            <span class="col-span-2">$${(quote.priceCents / 100).toFixed(2) || '0.00'}</span>
                        </p>
                    </div>
                </div>
            `;
        }
    } else if (type === 'xl') {
        quote = details.vendor_quotes.find(q => q.id == id || q.id === String(id));
        console.log('XL Quote found:', quote);
        
        if (quote) {
            carrierInfo = `
                <div class="selected-carrier-section">
                    
                    <div class="space-y-2 text-md bg-white p-4 rounded-lg shadow">
                        <p class="grid grid-cols-3"><span class="font-medium">Name:</span> <span class="col-span-2">${quote.name || 'N/A'}</span></p>
                        <p class="grid grid-cols-3"><span class="font-medium">Email:</span> <span class="col-span-2">${quote.email || 'N/A'}</span></p>
                        <p class="grid grid-cols-3"><span class="font-medium">Phone:</span> <span class="col-span-2">${quote.phone || 'N/A'}</span></p>
                        <p class="grid grid-cols-3"><span class="font-medium">Company:</span> <span class="col-span-2">${quote.company || 'N/A'}</span></p>
                        <p class="grid grid-cols-3"><span class="font-medium">Quote Amount:</span> <span class="col-span-2">$${quote.amount || '0.00'}</span></p>
                        <p class="grid grid-cols-3"><span class="font-medium">Status:</span> <span class="col-span-2 capitalize">${quote.status || 'Pending'}</span></p>
                    </div>
                </div>
            `;
        }
    }
    
    if (carrierInfo) {
        // Find the parent container that holds the carrier information
        const parentContainer = event.target.closest('.flex.gap-4');
        if (parentContainer) {
            // The carrier info section is inside the second child of the flex container
            const rightColumn = parentContainer.children[1];
            if (rightColumn) {
                // Find the selected-carrier-section within the right column
                const existingCarrierSection = rightColumn.querySelector('.selected-carrier-section');
                
                // Create a new carrier section
                const newCarrierSection = document.createElement('div');
                newCarrierSection.className = 'selected-carrier-section';
                newCarrierSection.innerHTML = carrierInfo;
                
                // Replace the existing carrier section or append if it doesn't exist
                if (existingCarrierSection) {
                    existingCarrierSection.replaceWith(newCarrierSection);
                } else {
                    // Insert after the shipment information
                    const shipmentInfo = rightColumn.querySelector('h4:first-of-type').parentNode;
                    rightColumn.insertBefore(newCarrierSection, shipmentInfo.nextSibling);
                }
                
                // Scroll to the carrier info section
                // setTimeout(() => {
                //     newCarrierSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                // }, 100);
                
                // Highlight the selected quote
                const quoteCards = document.querySelectorAll('.quote-card');
                quoteCards.forEach(card => {
                    card.classList.remove('ring-2', 'ring-blue-500');
                });
                
                const quoteCard = event.target.closest('.quote-card');
                if (quoteCard) {
                    quoteCard.classList.add('ring-2', 'ring-blue-500');
                }
            } else {
                console.error('Right column not found in the parent container');
            }
        } else {
            console.error('Parent container not found');
        }
    } else {
        console.error('Could not update carrier info:', {
            selectedCarrierSection: !!selectedCarrierSection,
            carrierInfo: !!carrierInfo,
            quoteFound: !!quote,
            type,
            id
        });
    }
}

// function fetchQuotesFromTP(id) {
//     console.log('Fetching quotes for shipment ID:', id);
    
//     // Create a regular object for the data
//     const requestData = {
//         method: 'fetchQuotesFromTP',
//         shipment_id: id
//     };
    
//     $.ajax({
//         url: 'https://stretchxlfreight.com/logistx/index.php?entryPoint=VendorSystem',
//         type: 'POST',
//         data: requestData,
//         dataType: 'json',
//         processData: true, // Don't process the data
//         contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
//         success: function(response) {
//             console.log('API Response:', response);
//             // Handle the response here
//         },
//         error: function(xhr, status, error) {
//             console.error('Error fetching quotes:', {
//                 status: status,
//                 error: error,
//                 responseText: xhr.responseText
//             });
//         }
//     });
// }

// // Uncomment this line to test the function
// fetchQuotesFromTP("285226517");
// fetchQuotesFromTP("285574879");

</script>

