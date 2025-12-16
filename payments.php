<?php include 'config/config.php'; 

$redirect = false;

if(isset($_GET['redirect']) && $_GET['redirect']){
    $redirect = true;
}



?>
  


<?php include 'components/layout/header.php'; ?>
<!-- Add SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<!-- Add custom CSS for payment form -->
<style>
    .payment-form {
        width: 100%;
        max-width: 500px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .error-message {
        color: #e53e3e;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        text-align: left;
    }
    
    .error {
        border-color: #e53e3e !important;
        box-shadow: 0 0 0 1px #e53e3e !important;
    }
    /* .form-group {
        margin-bottom: 20px;
    } */
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #4a5568;
        text-align: left;
    }
    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 16px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus {
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
        outline: none;
    }
    .form-row {
        display: flex;
        gap: 15px;
    }
    .form-row .form-group {
        flex: 1;
    }
    .btn-submit {
        background-color: #4299e1;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.2s;
    }
    .btn-submit:hover {
        background-color: #3182ce;
    }
    .btn-submit:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    /* Custom Popup Styles */
    .payment-popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1000;
    }
    
    .popup-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(3px);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .popup-content {
        position: relative;
        background: white;
        max-width: 500px;
        margin: 40px auto;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        transform: translateY(-20px);
        opacity: 0;
        transition: all 0.3s ease;
        max-height: 90vh;
        overflow-y: auto;
    }
    
    .payment-popup.active .popup-overlay {
        opacity: 1;
    }
    
    .payment-popup.active .popup-content {
        transform: translateY(0);
        opacity: 1;
    }
    
    .popup-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .popup-header h3 {
        margin: 0;
        font-size: 1.25rem;
        color: #2d3748;
    }
    
    .close-popup {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #718096;
        padding: 0;
        line-height: 1;
    }
    
    .close-popup:hover {
        color: #2d3748;
    }
    
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 25px;
        padding: 20px 25px;
        border-top: 1px solid #e2e8f0;
    }
    
    .btn-cancel {
        background: #e2e8f0;
        color: #4a5568;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        transition: background-color 0.2s;
    }
    
    .btn-cancel:hover {
        background: #cbd5e0;
    }
    
    .btn-submit {
        position: relative;
        overflow: hidden;
        background-color: #4299e1;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .btn-submit:hover {
        background-color: #3182ce;
    }
    
    .btn-submit:disabled {
        background-color: #a0aec0;
        cursor: not-allowed;
    }
    
    .btn-text, .btn-loader {
        transition: opacity 0.3s ease;
    }
    
    .btn-submit.loading .btn-text {
        opacity: 0;
    }
    
    .btn-submit.loading .btn-loader {
        opacity: 1;
    }
    
    .btn-loader {
        position: absolute;
        left: 0;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .error-message {
        color: #e53e3e;
        font-size: 0.75rem;
        margin-top: 4px;
        min-height: 18px;
    }
</style>
  <?php include 'components/layout/sidebar.php'; ?>
   
    <div class="flex flex-col flex-1 w-full">
     <?php include 'components/layout/topbar.php'; ?>
      <main class="h-full overflow-y-auto ">
        <div class=" px-6 pb-10 mx-auto ">
            <div class="flex justify-between items-center">

            <h1 class="text-3xl font-bold my-6 tracking-tight neon-red-header">
                        Payments
                    </h1>
                    <button onclick="showAddCardForm()" class="bgRed hover-lift text-white py-2 px-4 rounded">
                        Add Card
                    </button>
             </div>
         
 
         
        
        <?php

                if (isset($_COOKIE['user'])) {
                $userData = json_decode($_COOKIE['user'], true);
                } else {
                $userData = [];
                }
                // print_r($userData);

                $data['id'] = $userData['id'];
                $data['type'] = 'shipper';

                $response = fetchAllUserCards($data);
                // print_r($response);
                if (!empty($response['cards'])) {
                    echo '<div class="saved-cards">';
                    echo '<h3 class="text-lg font-medium text-gray-700 mb-4 dark:text-white">Saved Payment Methods</h3>';
                    echo '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">';
                    
                    foreach ($response['cards'] as $card) {
                        $lastFour = substr($card['card_number'], -4);
                        $cardType = strtolower($card['card_type']);
                        $cardIcon = '';
                        
                        // Set appropriate icon based on card type
                        switch($cardType) {
                            case 'visa':
                                $cardIcon = 'fab fa-cc-visa';
                                $cardBg = 'bg-gradient-to-r from-blue-500 to-blue-700';
                                break;
                            case 'mastercard':
                                $cardIcon = 'fab fa-cc-mastercard';
                                $cardBg = 'bg-gradient-to-r from-purple-600 to-pink-600';
                                break;
                            case 'amex':
                                $cardIcon = 'fab fa-cc-amex';
                                $cardBg = 'bg-gradient-to-r from-blue-600 to-teal-400';
                                break;
                            case 'discover':
                                $cardIcon = 'fab fa-cc-discover';
                                $cardBg = 'bg-gradient-to-r from-orange-500 to-yellow-400';
                                break;
                            default:
                                $cardIcon = 'far fa-credit-card';
                                $cardBg = 'bg-gradient-to-r from-gray-600 to-gray-800';
                        }
                        
                        echo '<div class="card-item rounded-lg shadow-md overflow-hidden transition-transform hover:scale-105">';
                        echo '  <div class="' . $cardBg . ' text-white p-5">';
                        echo '    <div class="flex justify-between items-start mb-6">';
                        echo '      <i class="' . $cardIcon . ' text-3xl"></i>';
                        echo '      <span class="bg-white bg-opacity-20 text-xs px-2 py-1 rounded-full text-gray-700">' . ucfirst($cardType) . '</span>';
                        echo '    </div>';
                        echo '    <div class="text-xl font-semibold tracking-wider mb-2">•••• •••• •••• ' . $lastFour . '</div>';
                        echo '    <div class="flex justify-between text-sm text-white text-opacity-80">';
                        echo '      <div>' . htmlspecialchars($card['name']) . '</div>';
                        echo '      <div>Exp: ' . htmlspecialchars($card['card_exp']) . '</div>';
                        echo '    </div>';
                        echo '  </div>';
                        echo '  <div class="bg-white p-4 flex justify-end gap-4 space-x-2">';
                        echo '    <button class="text-blue-600 hover:text-blue-800 transition-colors" onclick="editCard(\'' . $card['id'] . '\')">';
                        echo '      <i class="fas fa-edit"></i> Edit';
                        echo '    </button>';
                        echo '    <button class="text-red-600 hover:text-red-800 transition-colors" onclick="deleteCard(\'' . $card['id'] . '\')">';
                        echo '      <i class="fas fa-trash-alt"></i> Delete';
                        echo '    </button>';
                        echo '  </div>';
                        echo '</div>';
                    }
                    
                    echo '</div>'; // Close grid
                    echo '</div>'; // Close saved-cards
                }


        ?>
</div>

        <!-- Custom Payment Popup -->
        <div id="payment-popup" class="payment-popup">
            <div class="popup-overlay"></div>
            <div class="popup-content">
                <div class="popup-header">
                    <h3>Add New Card</h3>
                    <button class="close-popup" onclick="closePaymentPopup()">&times;</button>
                </div>
                <form id="payment-form" class="payment-form" onsubmit="return processPayment(event)">
                    <div class="form-group">
                        <label for="card-holder">Card Holder Name</label>
                        <input type="text" id="card-holder" class="form-control" placeholder="John Doe" required>
                        <div class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label>Card Type</label>
                        <div class="card-type-options" style="display: flex; gap: 15px; margin-top: 8px;">
                            <label class="card-type-option" style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                                <input type="radio" name="card-type" value="visa" style="margin: 0;" checked>
                                <span>Visa</span>
                            </label>
                            <label class="card-type-option" style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                                <input type="radio" name="card-type" value="mastercard" style="margin: 0;">
                                <span>Mastercard</span>
                            </label>
                            <label class="card-type-option" style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                                <input type="radio" name="card-type" value="amex" style="margin: 0;">
                                <span>AMEX</span>
                            </label>
                            <label class="card-type-option" style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                                <input type="radio" name="card-type" value="discover" style="margin: 0;">
                                <span>Discover</span>
                            </label>
                        </div>
                        <div class="error-message" id="card-type-error"></div>
                    </div>
                    <div class="form-group">
                        <label for="card-number">Card Number</label>
                        <input type="text" id="card-number" class="form-control" placeholder="1234 5678 9012 3456" required>
                        <div class="error-message"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="card-expiry">Expiry Date</label>
                            <input type="text" id="card-expiry" class="form-control" placeholder="MM/YY" required>
                            <div class="error-message"></div>
                        </div>
                        <div class="form-group">
                            <label for="card-cvv">CVV</label>
                            <input type="text" id="card-cvv" class="form-control" placeholder="123" required>
                            <div class="error-message"></div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="closePaymentPopup()">Cancel</button>
                        <button type="submit" class="btn-submit" id="submit-btn">
                            <span class="btn-text">Add Card</span>
                            <span class="btn-loader" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i> Processing...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
      </main>
    </div>
  </div>
  
<!-- Add SweetAlert2 JS -->
<!-- Add SweetAlert2 and Font Awesome for icons -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script>
            // Card management functions
            async function deleteCard(cardId) {
                const result = await Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                });

                let formData = new FormData();
                formData.append('method', 'deleteCard');
                formData.append('id', cardId);
                
                if (result.isConfirmed) {
                    try {
                        const response = await fetch('https://stretchxlfreight.com/logistx/index.php?entryPoint=VendorSystem', {
                            method: 'POST',
                           
                            body: formData
                        });
                        
                        const data = await response.json();
                        
                        if (data.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                'Card has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            throw new Error(data.message || 'Failed to delete card');
                        }
                    } catch (error) {
                        Swal.fire(
                            'Error!',
                            error.message || 'Something went wrong while deleting the card.',
                            'error'
                        );
                    }
                }
            }

            let currentEditingCardId = null;

            async function editCard(cardId) {
                try {
                    // Show loading state
                    const loadingSwal = Swal.fire({
                        title: 'Loading card details...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    let formData = new FormData();
                    formData.append('method', 'getCardDetails');
                    formData.append('id', cardId);

                    // Fetch card details
                    const response = await fetch('https://stretchxlfreight.com/logistx/index.php?entryPoint=VendorSystem', {
                        method: 'POST',
                        
                        body: formData
                    });
                    
                    const data = await response.json();
                    
                    // Close loading state
                    await loadingSwal.close();

                    if (data.status === 'success' && data.card) {
                        const card = data.card;
                        currentEditingCardId = card.id;
                        
                        // Populate form fields
                        document.getElementById('card-holder').value = card.name || '';
                        
                        // Format and set card number (show first 6 and last 4, mask the rest)
                        const cardNumber = card.card_number || '';
                        const firstSix = cardNumber.substring(0, 6);
                        const lastFour = cardNumber.substring(cardNumber.length - 4);
                        // const maskedNumber = `${firstSix}******${lastFour}`.replace(/(\d{4})(?=.)/g, '$1 ').trim();
                        document.getElementById('card-number').value = cardNumber;
                        // document.getElementById('card-number').setAttribute('data-original-number', cardNumber);
                        
                        // Set expiry date
                        document.getElementById('card-expiry').value = card.card_exp || '';
                        
                        // Set CVV (if available, otherwise leave empty for security)
                        document.getElementById('card-cvv').value = card.card_cvv || '';
                        // document.getElementById('card-cvv').setAttribute('placeholder', '••••')
                            // .setAttribute('data-original-cvv', card.card_cvv || '');
                        
                        // Set card type
                        const cardType = card.card_type?.toLowerCase() || 'visa';
                        const cardTypeInput = document.querySelector(`input[name="card-type"][value="${cardType}"]`);
                        if (cardTypeInput) {
                            cardTypeInput.checked = true;
                        }
                        
                        // Update form title and submit button
                        document.querySelector('.popup-header h3').textContent = 'Edit Card';
                        document.querySelector('#submit-btn .btn-text').textContent = 'Update Card';
                        
                        // Show the form
                        showAddCardForm();
                    } else {
                        throw new Error(data.message || 'Failed to load card details');
                    }
                } catch (error) {
                    console.error('Error loading card details:', error);
                    Swal.fire(
                        'Error',
                        error.message || 'Failed to load card details. Please try again.',
                        'error'
                    );
                }
            }

            // DOM Elements
            const paymentPopup = document.getElementById('payment-popup');
            const paymentForm = document.getElementById('payment-form');
            const submitBtn = document.getElementById('submit-btn');
            const btnText = submitBtn.querySelector('.btn-text');
            const btnLoader = submitBtn.querySelector('.btn-loader');

            // Validation functions
            function validateCardNumber(cardNumber) {
                // Remove all non-digits and spaces
                const cleanNumber = cardNumber.replace(/\s+/g, '');
                // Check if it's a valid card number (13-19 digits)
                return /^[0-9]{13,19}$/.test(cleanNumber) ;
            }

            

            function validateExpiryDate(expiryDate) {
                if (!/^\d{2}\/\d{2}$/.test(expiryDate)) return false;
                
                const [month, year] = expiryDate.split('/').map(Number);
                if (month < 1 || month > 12) return false;
                
                const currentDate = new Date();
                const currentYear = currentDate.getFullYear() % 100;
                const currentMonth = currentDate.getMonth() + 1;
                
                // Check if the card is expired
                if (year < currentYear || (year === currentYear && month < currentMonth)) {
                    return false;
                }
                
                // Check if the year is within a reasonable range (current year to current year + 20)
                const maxYear = (currentDate.getFullYear() % 100) + 20;
                return year <= maxYear;
            }

            function validateCVV(cvv) {
                // CVV can be 3 or 4 digits
                return /^\d{3,4}$/.test(cvv);
            }

            function validateCardHolder(name) {
                // Basic name validation - allows letters, spaces, hyphens, and apostrophes
                return /^[a-zA-Z\s'-]+$/.test(name) && name.length >= 2 && name.length <= 50;
            }

            function showError(input, message) {
                const formGroup = input.closest('.form-group');
                const errorElement = formGroup.querySelector('.error-message');
                
                if (errorElement) {
                    errorElement.textContent = message;
                    input.classList.add('error');
                }
                
                return false;
            }

            function clearError(input) {
                const formGroup = input.closest('.form-group');
                if (!formGroup) return;
                
                const errorElement = formGroup.querySelector('.error-message');
                if (errorElement) {
                    errorElement.textContent = '';
                }
                
                input.classList.remove('error');
                return true;
            }

            // Show payment popup
            function showAddCardForm() {
                paymentPopup.style.display = 'block';
                // Trigger reflow to enable animation
                void paymentPopup.offsetWidth;
                paymentPopup.classList.add('active');
                
                // Set focus on the first input
                const firstInput = paymentForm.querySelector('input');
                if (firstInput) {
                    firstInput.focus();
                }
            }

            // Close payment popup
            function closePaymentPopup() {
                paymentPopup.classList.remove('active');
                // Reset form when closing
                setTimeout(() => {
                    paymentPopup.style.display = 'none';
                    paymentForm.reset();
                    // Clear any errors and reset form state
                    document.querySelectorAll('.form-control').forEach(input => {
                        clearError(input);
                        input.removeAttribute('data-original-number');
                        input.removeAttribute('data-original-cvv');
                    });
                    document.querySelector('.popup-header h3').textContent = 'Add New Card';
                    document.querySelector('#submit-btn .btn-text').textContent = 'Add Card';
                    currentEditingCardId = null;
                }, 300);
            }

            // Close payment popup and reset form
            function resetPaymentForm() {
                paymentForm.reset();
                document.querySelector('.popup-header h3').textContent = 'Add New Card';
                document.querySelector('#submit-btn .btn-text').textContent = 'Add Card';
                currentEditingCardId = null;
                closePaymentPopup();
            }

            // Process payment form submission
            async function processPayment(event) {
                event.preventDefault();
                
                // Get form elements
                const cardHolder = document.getElementById('card-holder');
                const cardNumber = document.getElementById('card-number');
                const expiryDate = document.getElementById('card-expiry');
                const cvv = document.getElementById('card-cvv');
                const cardTypeInput = document.querySelector('input[name="card-type"]:checked');
                
                // Use original card number if we're in edit mode and number wasn't changed
                const originalNumber = cardNumber.getAttribute('data-original-number');
                const isEditing = !!currentEditingCardId;
                
                // Clear previous errors
                [cardHolder, cardNumber, expiryDate, cvv].forEach(clearError);
                
                // Validate all fields
                let isValid = true;
                
                if (!validateCardHolder(cardHolder.value)) {
                    showError(cardHolder, 'Please enter a valid name (letters, spaces, hyphens, and apostrophes only)');
                    isValid = false;
                }
                
                if (!validateCardNumber(cardNumber.value)) {
                    showError(cardNumber, 'Please enter a valid card number');
                    isValid = false;
                }
                
                if (!validateExpiryDate(expiryDate.value)) {
                    showError(expiryDate, 'Please enter a valid expiry date (MM/YY)');
                    isValid = false;
                }
                
                if (!validateCVV(cvv.value)) {
                    showError(cvv, 'Please enter a valid CVV (3-4 digits)');
                    isValid = false;
                }
                
                // Auto-detect and update card type based on card number if it's a valid number
                const cleanCardNumber = cardNumber.value.replace(/\s+/g, '');
                if (/^\d{13,19}$/.test(cleanCardNumber)) {
                    // const detectedCardType = detectCardType(cleanCardNumber);
                    // const matchingRadio = document.querySelector(`input[name="card-type"][value="${detectedCardType}"]`);
                    // if (matchingRadio) {
                    //     matchingRadio.checked = true;
                    // }
                }
                
                if (!isValid) {
                    // Scroll to the first error
                    const firstError = document.querySelector('.error');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    return false;
                }
                <?php 
                    if (isset($_COOKIE["user"])) {
                    ?>
                    var userData = <?php echo ($_COOKIE["user"]); ?>;
                    <?php } else { ?>
                    var userData = [];
                    <?php } ?>
                
                // Disable submit button and show loading state
                submitBtn.disabled = true;
                btnText.style.opacity = '0';
                btnLoader.style.display = 'flex';
                
                let formData = new FormData();
                formData.append('card-holder', cardHolder.value);
                
                // If editing and card number wasn't changed, use the original number
                const cardNumberValue = isEditing && cardNumber.value.includes('*') 
                    ? originalNumber 
                    : cardNumber.value.replace(/\s+/g, '');
                    
                formData.append('card-number', cardNumberValue);
                formData.append('user-id', userData.id);
                formData.append('card-expiry', expiryDate.value);
                
                // If editing and CVV wasn't changed, use the original CVV
                const cvvValue = isEditing && cvv.value === '' && cvv.getAttribute('data-original-cvv')
                    ? cvv.getAttribute('data-original-cvv')
                    : cvv.value;
                    
                formData.append('card-cvv', cvvValue);
                formData.append('card-type', cardTypeInput ? cardTypeInput.value : 'visa');
                formData.append('method', isEditing ? 'updateCard' : 'addCard');
                formData.append('type', 'shipper');
                
                if (isEditing) {
                    formData.append('id', currentEditingCardId);
                }
                
                let response = await fetch('https://stretchxlfreight.com/logistx/index.php?entryPoint=VendorSystem', {
                    method: 'POST',
                    body: formData
                });
                
                let data = await response.json();
                
                if(data.status == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Your card has been added successfully!',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Reset form and close popup on success
                        resetPaymentForm();
                        <?php
                        if($redirect){
                            echo "console.log('redirecting');";
                            echo "location.href = 'agreement.php?redirect=true';";
                        }else{
                            echo "console.log('not redirecting');";
                            echo "location.reload();";
                        }
                        
                        ?>
                       
                    });
                    
                    // Re-enable submit button
                    submitBtn.disabled = false;
                    btnText.style.opacity = '1';
                    btnLoader.style.display = 'none';
                }
                
                return false;
            }

            // Initialize event listeners
            document.addEventListener('DOMContentLoaded', function() {
                // Card holder name validation
                const cardHolder = document.getElementById('card-holder');
                if (cardHolder) {
                    cardHolder.addEventListener('input', function(e) {
                        clearError(e.target);
                    });
                    
                    cardHolder.addEventListener('blur', function(e) {
                        if (!validateCardHolder(e.target.value)) {
                            showError(e.target, 'Please enter a valid name (letters, spaces, hyphens, and apostrophes only)');
                        }
                    });
                }

                // Card number formatting and validation
                const cardNumber = document.getElementById('card-number');
                if (cardNumber) {
                    cardNumber.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/\D/g, '');
                        value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
                        e.target.value = value.trim();
                        clearError(e.target);
                    });
                    
                    cardNumber.addEventListener('blur', function(e) {
                        if (!validateCardNumber(e.target.value)) {
                            showError(e.target, 'Please enter a valid card number');
                        }
                    });
                }

                // Expiry date formatting and validation
                const expiryDate = document.getElementById('card-expiry');
                if (expiryDate) {
                    expiryDate.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/\D/g, '');
                        if (value.length > 2) {
                            value = value.substring(0, 2) + '/' + value.substring(2, 4);
                        }
                        e.target.value = value;
                        clearError(e.target);
                    });
                    
                    expiryDate.addEventListener('blur', function(e) {
                        if (!validateExpiryDate(e.target.value)) {
                            showError(e.target, 'Please enter a valid expiry date (MM/YY)');
                        }
                    });
                }

                // CVV formatting and validation
                const cvv = document.getElementById('card-cvv');
                if (cvv) {
                    cvv.addEventListener('input', function(e) {
                        e.target.value = e.target.value.replace(/\D/g, '').substring(0, 4);
                        clearError(e.target);
                    });
                    
                    cvv.addEventListener('blur', function(e) {
                        if (!validateCVV(e.target.value)) {
                            showError(e.target, 'Please enter a valid CVV (3-4 digits)');
                        }
                    });
                }
                
                // Close popup when clicking outside the content
                document.querySelector('.popup-overlay').addEventListener('click', closePaymentPopup);
                
                // Close popup when pressing Escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && paymentPopup.classList.contains('active')) {
                        closePaymentPopup();
                    }
                });
            });
</script>
</body>
</html>
