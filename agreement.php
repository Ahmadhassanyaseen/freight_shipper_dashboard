  

  <?php include 'config/config.php'; ?>
 
 <?php include 'components/layout/header.php'; ?>
 <!-- Add these in the head section if not already present -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature-pad.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
<style>
    .signature-pad {
    width: 100%;
    height: 150px;
    border: 1px solid #e2e8f0;
    border-radius: 0.375rem;
    margin-bottom: 10px;
    background-color: white;
    touch-action: none; /* Add this for better touch support */
    }
    .signature-actions {
        display: flex;
        gap: 8px;
        margin-top: 8px;
    }
    .signature-pad-wrapper {
        position: relative;
    }
    .signature-clear {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(255,255,255,0.8);
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        padding: 2px 8px;
        cursor: pointer;
        font-size: 12px;
        z-index: 10;
    }
    #shipper-signature-error,#shipper-name-error{
        display:none;
    }
</style>
   <?php include 'components/layout/sidebar.php'; ?>
   <?php
if (isset($_COOKIE['user'])) {
    $userData = json_decode($_COOKIE['user'], true);
} else {
    $userData = [];
}
?>
        
    <?php
    $shipment = fetchShipmentById(['id' => $_GET['id']]);
    // print_r($shipment);
    $addOns = explode(',', $shipment['addons']);
    ?>
    
     <div class="flex flex-col flex-1 w-full">
      <?php include 'components/layout/topbar.php'; ?>
       <main class="h-full overflow-y-auto">
         <div class=" px-6 pb-10 mx-auto grid">
          
         <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">FREIGHT SHIPPING AGREEMENT</h1>
        <p class="text-gray-600">Agreement #<?= $shipment['opertunity_id'] ?></p>
    </div>

    <!-- Parties Information -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div class="border p-4 rounded-lg">
            <h2 class="text-lg font-semibold mb-3 border-b pb-2">Shipper Information</h2>
            <p class="font-medium"><?= htmlspecialchars($shipment['shipper_name']) ?></p>
            <p class="text-gray-600"><?= htmlspecialchars($shipment['shipper_address']) ?></p>
            <p class="text-gray-600"><?= htmlspecialchars($shipment['shipper_phone']) ?></p>
            <p class="text-gray-600"><?= htmlspecialchars($shipment['shipper_email']) ?></p>
        </div>
        <div class="border p-4 rounded-lg">
            <h2 class="text-lg font-semibold mb-3 border-b pb-2">Shipment Details</h2>
            <p><span class="font-medium">Freight Type:</span> <?= ucfirst(str_replace('_', ' ', $shipment['freight_type'])) ?></p>
            <p><span class="font-medium">Description:</span> <?= htmlspecialchars($shipment['description']) ?></p>
            <p><span class="font-medium">Vehicle Type:</span> <?= ucfirst($shipment['carrier_vehicle_type']) ?></p>
            <p><span class="font-medium">Status:</span> <?= $shipment['status'] ?></p>
        </div>
    </div>

    <!-- Shipment Details -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Shipment Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="border p-4 rounded-lg">
                <h3 class="font-medium text-lg mb-2">Pickup Details</h3>
                <p class="text-gray-800"><?= htmlspecialchars($shipment['pickup_address']) ?></p>
                <p class="text-gray-600"><?= date('F j, Y', strtotime($shipment['pickup_date'])) ?> at <?= date('g:i A', strtotime($shipment['pickup_time'])) ?></p>
            </div>
            <div class="border p-4 rounded-lg">
                <h3 class="font-medium text-lg mb-2">Delivery Details</h3>
                <p class="text-gray-800"><?= htmlspecialchars($shipment['dropoff_address']) ?></p>
                <p class="text-gray-600"><?= date('F j, Y', strtotime($shipment['dropoff_date'])) ?> at <?= date('g:i A', strtotime($shipment['dropoff_time'])) ?></p>
            </div>
        </div>
    </div>

    <!-- Freight Details -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Freight Specifications</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="border p-3 rounded-lg text-center">
                <p class="text-sm text-gray-500">Weight</p>
                <p class="font-medium"><?= number_format($shipment['freight_weight']) ?> lbs</p>
            </div>
            <div class="border p-3 rounded-lg text-center">
                <p class="text-sm text-gray-500">Dimensions</p>
                <p class="font-medium"><?= $shipment['freight_length'] ?>L x <?= $shipment['freight_width'] ?>W x <?= $shipment['freight_height'] ?>H (in)</p>
            </div>
            <div class="border p-3 rounded-lg text-center">
                <p class="text-sm text-gray-500">Pallets</p>
                <p class="font-medium"><?= $shipment['freight_pallet_count'] ?></p>
            </div>
            <div class="border p-3 rounded-lg text-center">
                <p class="text-sm text-gray-500">Boxes</p>
                <p class="font-medium"><?= $shipment['freight_box_count'] ?></p>
            </div>
        </div>
    </div>

    <!-- Pricing -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Pricing Summary</h2>
        <div class="border rounded-lg overflow-hidden">
            <table class="min-w-full">
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-3">Base Rate</td>
                        <td class="px-4 py-3 text-right">$<?php echo number_format(floatval(str_replace(',', '', $shipment['total_price'])) - floatval(str_replace(',', '', $shipment['addons_total'])), 2) ?></td>
                    </tr>
                    <?php if (!empty($shipment['addons_total'])): ?>
                    <tr>
                        <td class="px-4 py-3">Additional Services</td>
                        <td class="px-4 py-3 text-right">$<?= number_format(floatval(str_replace(',', '', $shipment['addons_total'])), 2) ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr class="bg-gray-50 font-semibold">
                        <td class="px-4 py-3">Total Amount</td>
                        <td class="px-4 py-3 text-right">$<?= number_format(floatval(str_replace(',', '', $shipment['total_price'])), 2) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Terms and Conditions -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Terms and Conditions</h2>
        <div class="prose max-w-none">
            <ol class="list-decimal pl-5 space-y-3 text-sm text-gray-700">
                <li><strong>Liability:</strong> The carrier's liability for loss or damage to cargo is limited to $0.50 per pound, unless a higher value is declared and additional charges are paid.</li>
                <li><strong>Payment Terms:</strong> Payment is due in full within 15 days of invoice date. Late payments may be subject to a 1.5% monthly finance charge.</li>
                <li><strong>Pickup/Delivery:</strong> Shipper is responsible for loading and consignee is responsible for unloading the shipment, unless otherwise arranged.</li>
                <li><strong>Claims:</strong> All claims for loss or damage must be submitted in writing within 60 days of delivery.</li>
                <li><strong>Accessorial Charges:</strong> Additional charges may apply for services including but not limited to: liftgate service, inside delivery, residential pickup/delivery, and storage.</li>
                <li><strong>Hazardous Materials:</strong> Shipment of hazardous materials must be declared in writing prior to pickup and must comply with all applicable regulations.</li>
                <li><strong>Force Majeure:</strong> Neither party shall be liable for any failure or delay in performance due to causes beyond their reasonable control.</li>
                <li><strong>Governing Law:</strong> This agreement shall be governed by and construed in accordance with the laws of the state where the carrier's principal place of business is located.</li>
            </ol>
        </div>
    </div>

  <!-- Signatures -->
<div class="mt-12">
    <form id="signatureForm">
        <div class="flex gap-8">
            <!-- Shipper's Signature -->
            <div class="">
                <p class="font-medium mb-3">Shipper's Signature</p>
                <div class="signature-pad-wrapper">
                <canvas id="shipper-signature" class="signature-pad"></canvas>
                    <button type="button" class="signature-clear" onclick="clearSignature('shipper')">Clear</button>
                    <span id="shipper-signature-error" class="text-red-500">Please provide a signature</span>
                </div>
                <div class="mt-2">
                    <input type="text" id="shipper-name" class="w-full p-2 border rounded" placeholder="Full Name" required>
                    <span id="shipper-name-error" class="text-red-500">Please provide a name</span>
                </div>
                <p class="text-sm text-gray-500 mt-2">Date: <span id="shipper-date"><?= date('m/d/Y') ?></span></p>
                <input type="hidden" id="shipper-signature-data" name="shipper_signature">
            </div>

           
        </div>

        <!-- Submit Button -->
        <div class="mt-8 text-center space-x-4">
            <button type="button" id="submitAgreement" class="bg-primary-color hover:bg-green-700 text-white font-medium py-2 px-6 rounded-md">
              Submit Agreement
            </button>
            <!-- <button type="button" id="testPdfGeneration" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md">
              Test PDF Generation
            </button> -->
        </div>
    </form>
</div>

<!-- Add this script before the closing body tag -->

</div>

<!-- Add some print-specific styles -->
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #agreement-container, #agreement-container * {
            visibility: visible;
        }
        #agreement-container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none !important;
        }
    }
</style>
        
           
          

         

          
         </div>
       </main>
     </div>
   </div>


   <script>
    // Global variable for the signature pad
    let shipperSignaturePad;

    // Initialize signature pads
    function initSignaturePads() {
        const shipperCanvas = document.getElementById('shipper-signature');
        
        // Set canvas size
        function resizeCanvas(canvas) {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            const width = canvas.offsetWidth;
            const height = canvas.offsetHeight;
            
            if (width && height) {
                canvas.width = width * ratio;
                canvas.height = height * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
            }
            return canvas;
        }

        // Initialize signature pad
        shipperSignaturePad = new SignaturePad(shipperCanvas, {
            backgroundColor: 'rgb(255, 255, 255)',
            penColor: 'rgb(0, 0, 0)'
        });

        // Initial resize
        resizeCanvas(shipperCanvas);

        // Handle window resize
        function onResize() {
            const shipperData = shipperSignaturePad.toData();
            resizeCanvas(shipperCanvas);
            shipperSignaturePad.clear();
            if (shipperData && shipperData.length > 0) {
                shipperSignaturePad.fromData(shipperData);
            }
        }

        // Clear signature function
        window.clearSignature = function(type) {
            if (type === 'shipper' && shipperSignaturePad) {
                shipperSignaturePad.clear();
            }
        };

       

        window.addEventListener('resize', onResize);
    }

    // Initialize when the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Wait a small amount of time to ensure all elements are rendered
        setTimeout(initSignaturePads, 100);
        
        // Add click handler for test PDF generation
        // document.getElementById('testPdfGeneration').addEventListener('click', testPdfGeneration);
    });
    
    // Function to test PDF generation with current form data
    // async function testPdfGeneration() {
    //     const shipperName = document.getElementById('shipper-name').value;
    //     const signatureData = shipperSignaturePad ? shipperSignaturePad.toDataURL('image/png') : '';
        
    //     if (!shipperName) {
    //         alert('Please enter your name');
    //         document.getElementById('shipper-name').focus();
    //         return;
    //     }
        
    //     if (!signatureData) {
    //         alert('Please provide a signature');
    //         return;
    //     }
        
    //     const testButton = document.getElementById('testPdfGeneration');
    //     const originalText = testButton.innerHTML;
    //     testButton.disabled = true;
    //     testButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Testing PDF Generation...';
        
    //     try {
    //         console.log('Starting test PDF generation...');
            
    //         // Create test data based on the current shipment
    //         const testData = {
    //             shipmentData: <?php echo json_encode($shipment); ?>,
    //             signature: signatureData,
    //             shipper_name: shipperName,
    //             test: true
    //         };
            
    //         console.log('Sending test data:', testData);
            
    //         console.log('Sending request to pdf.php...');
    //         const response = await fetch('pdf.php', {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json',
    //             },
    //             body: JSON.stringify(testData)
    //         });
            
    //         // First get the response as text to handle potential errors
    //         const responseText = await response.text();
    //         console.log('Raw response:', responseText);
            
    //         let data;
    //         try {
    //             data = JSON.parse(responseText);
    //             console.log('Parsed response:', data);
    //         } catch (e) {
    //             console.error('Failed to parse JSON response:', e);
    //             // Check if this is an HTML error page
    //             if (responseText.includes('<b>Fatal error</b>') || 
    //                 responseText.includes('<b>Parse error</b>') ||
    //                 responseText.includes('<b>Warning</b>') ||
    //                 responseText.includes('PHP Error')) {
                    
    //                 // Extract error message from HTML if possible
    //                 const errorMatch = responseText.match(/<b>(.*?)<\/b>/);
    //                 const errorMessage = errorMatch ? errorMatch[1] : 'Server returned an HTML error page';
                    
    //                 throw new Error(`Server Error: ${errorMessage}. Check server logs for details.`);
    //             } else {
    //                 throw new Error(`Invalid response from server: ${responseText.substring(0, 200)}...`);
    //             }
    //         }
            
    //         if (data && data.success) {
    //             console.log('PDF generated successfully:', data);
    //             alert('PDF generated successfully!\nPath: ' + data.pdfPath + '\nURL: ' + data.pdfUrl);
    //             // Open the PDF in a new tab
    //             if (data.pdfUrl) {
    //                 window.open(data.pdfUrl, '_blank');
    //             }
    //         } else {
    //             const errorMsg = data && data.error 
    //                 ? `Failed to generate PDF: ${data.error}`
    //                 : 'Failed to generate PDF. Unknown error occurred.';
    //             throw new Error(errorMsg);
    //         }
    //     } catch (error) {
    //         console.error('Error generating test PDF:', error);
    //         alert('Error: ' + (error.message || 'Failed to generate test PDF. Check console for details.'));
    //     } finally {
    //         testButton.disabled = false;
    //         testButton.innerHTML = originalText;
    //     }
    // }

    document.getElementById('submitAgreement').addEventListener('click', function() {
        // Get signature data
        const signatureData = shipperSignaturePad.toDataURL('image/png');
        const signatureError = document.getElementById('shipper-signature-error');
        const shipperName = document.getElementById('shipper-name').value;
        const shipperNameError = document.getElementById('shipper-name-error');

        if(shipperSignaturePad.isEmpty()){
            
            signatureError.style.display = 'block';
            return;
        }
        if(shipperName.length == 0){

            shipperNameError.style.display = 'block';
            return;
        }
        signatureError.style.display = 'none';
        shipperNameError.style.display = 'none';
        // Set hidden field
        document.getElementById('shipper-signature-data').value = signatureData;
        
        // Here you would typically send this data to your server
        console.log('Signature saved:', {
            signature: signatureData.substring(0, 50) + '...' // Just log a preview
        });
        
        // alert('Signature saved successfully!');
        
        // Show payment modal after signature is saved
        showPaymentModal();
    });

    // Payment Modal Functions
    function showPaymentModal() {
        const modal = document.getElementById('paymentModal');
        modal.classList.remove('hidden');
        
        // Load saved cards (you'll need to implement this with your backend)
        // loadSavedCards();
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
    }

    // function switchTab(tabName) {
    //     // Hide all tab contents
    //     document.querySelectorAll('.tab-content').forEach(tab => {
    //         tab.classList.add('hidden');
    //     });
        
    //     // Show selected tab content
    //     document.getElementById(tabName).classList.remove('hidden');
        
    //     // Update active tab styling
    //     document.querySelectorAll('.tab-button').forEach(button => {
    //         button.classList.remove('border-b-2', 'border-primary-color', 'text-primary-color');
    //         button.classList.add('text-gray-500');
    //     });
        
    //     event.target.classList.remove('text-gray-500');
    //     event.target.classList.add('border-b-2', 'border-primary-color', 'text-primary-color');
    // }

    // Handle saved card selection
    function selectCard(cardId) {
        const shipperName = document.getElementById('shipper-name').value;
        const signatureData = document.getElementById('shipper-signature-data').value;
        
        if (!shipperName) {
            alert('Please sign the agreement first');
            return;
        }
        
        const paymentData = {
            method: 'agreementPayment',
            card_id: cardId,
            agreement_id: '<?= $shipment['id'] ?>',
            shipper_name: shipperName,
            signature: signatureData,
            amount: '<?= $shipment['total_price'] ?>',
            user_id: '<?= $userData['id'] ?>',
            shipmentData: <?php echo json_encode($shipment); ?>
        };

        submitPayment(paymentData);
    }

    // Handle new card form submission
    const newCardForm = document.getElementById('newCardForm');
    if (newCardForm) {
        newCardForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const shipperName = document.getElementById('shipper-name').value;
        const signatureData = document.getElementById('shipper-signature-data').value;
        
        if (!shipperName) {
            alert('Please sign the agreement first');
            return;
        }

        const paymentData = {
            method: 'agreementPayment',
            card_number: formData.get('card_number'),
            card_exp: formData.get('card_exp'),
            card_cvv: formData.get('card_cvv'),
            card_name: formData.get('card_name'),
            save_card: document.getElementById('save-card').checked,
            agreement_id: '<?= $shipment['id'] ?>',
            shipper_name: shipperName,
            signature: signatureData,
            amount: '<?= $shipment['total_price'] ?>',
            user_id: '<?= $userData['id'] ?>',
            shipmentData: <?php echo json_encode($shipment); ?>
        };

            submitPayment(paymentData);
        });
    }

    // Submit payment to API
    function submitPayment(paymentData) {
        console.log('Starting payment process...', paymentData);
        Swal.fire({
            title: 'Processing Payment',
            text: 'Please wait while we process your payment...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Show loading state
        const submitButtons = document.querySelectorAll('button[type="submit"]');
        submitButtons.forEach(btn => {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        });

        // First, generate the PDF
        console.log('Generating PDF with data:', {
            shipmentData: paymentData.shipmentData,
            signature: paymentData.signature ? 'signature-present' : 'signature-missing',
            card_id: paymentData.card_id || 'no-card-id'
        });
        
        // Create the request payload
        const pdfRequestData = {
            shipmentData: paymentData.shipmentData,
            signature: paymentData.signature,
            card_id: paymentData.card_id,
            amount: paymentData.amount
        };
        
        console.log('Sending PDF generation request with data:', JSON.stringify(pdfRequestData, null, 2));
        
        return fetch('pdf.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(pdfRequestData)
        })
        .then(response => {
            if (!response.ok) {
                console.error('PDF generation failed with status:', response.status);
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to generate agreement PDF',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }); 
                return response.text().then(text => {
                    console.error('Error response:', text);
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        throw new Error(`Failed to generate PDF. Status: ${response.status}, Response: ${text}`);
                    }
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('PDF generation response:', data);
            if (!data || !data.success) {
                const errorMsg = data && data.error 
                    ? `Failed to generate agreement PDF: ${data.error}`
                    : 'Unknown error generating PDF';
                if (data && data.error_details) {
                    console.error('Error details:', data.error_details);
                }
                throw new Error(errorMsg);
            }
            
            console.log('PDF generated successfully:', data.pdfUrl);
            
            // Add PDF URL to payment data
            paymentData.agreement_pdf = data.pdfUrl;

            const formData = new FormData();
            formData.append('method', 'agreementPayment');
            formData.append('agreement_pdf', data.pdfUrl);
            formData.append('agreement_id', paymentData.agreement_id);
            formData.append('shipper_name', paymentData.shipper_name);
            formData.append('amount', paymentData.amount);
            formData.append('user_id', paymentData.user_id);
            formData.append('shipmentData', JSON.stringify(paymentData.shipmentData));
            formData.append('card_id', paymentData.card_id);
            formData.append('quote_id', <?php echo $_GET['quote_id']; ?>);
            
            
            // Now process the payment with the PDF URL included
            console.log('Processing payment with PDF...');
            return fetch('https://stretchxlfreight.com/logistx/index.php?entryPoint=VendorSystem', {
                method: 'POST',
                body: formData
            });
        })
        .then(response => response.json())
        .then(paymentResponse => {
            if (paymentResponse.status == 'success') {
                // Handle successful payment
                console.log('Payment processed successfully:', paymentResponse);
                Swal.fire({
                    title: 'Success',
                    text: 'Payment processed successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                    
                });
                setTimeout(() => {
                    window.location.href = paymentResponse.payment_pdf;
                }, 2000);
            } else {
                // Handle error
                throw new Error(paymentResponse.message || 'Payment processing failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Payment processing failed',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            // Reset buttons
            submitButtons.forEach(btn => {
                btn.disabled = false;
                btn.innerHTML = 'Pay Now';
            });
        });
    }
</script>

<!-- Payment Modal -->
<div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg w-full max-w-2xl mx-4">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold">Payment Method</h3>
                <button onclick="closePaymentModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Tabs -->
            <div class="border-b border-gray-200">
                <div class="flex space-x-4">
                    <button onclick="switchTab('saved-cards-tab')" class="tab-button px-4 py-2 font-medium border-b-2 border-primary-color text-primary-color">
                        Saved Cards
                    </button>
                    <!-- <button onclick="switchTab('new-card-tab')" class="tab-button px-4 py-2 font-medium text-gray-500">
                        Add New Card
                    </button> -->
                </div>
            </div>
            
            <!-- Tab Content -->
            <div class="mt-6">
                <!-- Saved Cards Tab -->
                <div id="saved-cards-tab" class="tab-content">
                    <div id="saved-cards-list" class="space-y-4">
                        <!-- Cards will be loaded here dynamically -->
                        <?php
                        $data['id'] = $userData['id'];
                        $data['type'] = 'shipper';
                        $response = fetchAllUserCards($data);
                        $cards = $response['cards'] ?? [];
                        
                        if (!empty($cards)) {
                            foreach ($cards as $card) {
                                $lastFour = substr($card['card_number'], -4);
                                $cardType = strtolower($card['card_type']);
                                $cardBgColor = '';
                                $cardTextColor = 'text-gray-700';
                                
                                // Set card background and text colors based on card type
                                switch($cardType) {
                                    case 'visa':
                                        $cardBgColor = 'bg-gradient-to-r from-blue-600 to-blue-800';
                                        $cardTextColor = 'text-white';
                                        break;
                                    case 'mastercard':
                                        $cardBgColor = 'bg-gradient-to-r from-red-600 to-yellow-400';
                                        $cardTextColor = 'text-white';
                                        break;
                                    case 'amex':
                                        $cardBgColor = 'bg-gradient-to-r from-blue-500 to-blue-700';
                                        $cardTextColor = 'text-white';
                                        break;
                                    case 'discover':
                                        $cardBgColor = 'bg-gradient-to-r from-orange-500 to-orange-700';
                                        $cardTextColor = 'text-white';
                                        break;
                                    default:
                                        $cardBgColor = 'bg-gray-200';
                                        $cardTextColor = 'text-gray-700';
                                }
                                ?>
                                <div class="flex items-center justify-between p-4 border rounded-lg mb-3">
                                    <div class="flex items-center">
                                        <div class="p-2 <?= $cardBgColor ?> rounded-md mr-3 flex items-center justify-center">
                                            <span class="text-xs font-bold <?= $cardTextColor ?> uppercase"><?= $cardType ?></span>
                                        </div>
                                        <div>
                                            <p class="font-medium"><?= $cardType ?> ending in <?= $lastFour ?></p>
                                            <p class="text-sm text-gray-500">Expires <?= $card['card_exp'] ?></p>
                                            <p class="text-xs text-gray-400"><?= $card['name'] ?></p>
                                        </div>
                                    </div>
                                    <button onclick="selectCard('<?= $card['id'] ?>')" class="bg-primary-color hover:bg-primary-color-dark text-white px-4 py-2 rounded-md text-sm">
                                        Use this card
                                    </button>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<div class="text-center py-4 text-gray-500">No saved cards found. Please add a new card.</div>';
                        }
                        ?>
                        <!-- Add more saved cards as needed -->
                    </div>
                    
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-500 mb-4">Or</p>
                        <button onclick="switchTab('new-card-tab')" class="text-primary-color hover:text-primary-color-dark font-medium">
                            Add a new payment method
                        </button>
                    </div>
                </div>
                
                <!-- New Card Tab -->
                <!-- <div id="new-card-tab" class="tab-content hidden">
                    <form id="newCardForm" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                            <input type="text" class="w-full p-2 border rounded-md" placeholder="1234 5678 9012 3456" required>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                                <input type="text" class="w-full p-2 border rounded-md" placeholder="MM/YY" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">CVC</label>
                                <input type="text" class="w-full p-2 border rounded-md" placeholder="123" required>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name on Card</label>
                            <input type="text" class="w-full p-2 border rounded-md" placeholder="John Doe" required>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="save-card" class="rounded text-primary-color focus:ring-primary-color">
                            <label for="save-card" class="ml-2 text-sm text-gray-700">Save card for future payments</label>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="w-full bg-primary-color text-white py-2 px-4 rounded-md hover:bg-primary-color-dark">
                                Pay Now
                            </button>
                        </div>
                    </form>
                </div> -->
            </div>
        </div>
    </div>
</div>

<style>
    .tab-content {
        transition: all 0.3s ease;
    }
    
    #paymentModal {
        backdrop-filter: blur(5px);
    }
</style>
</div>
</body>
</html>
