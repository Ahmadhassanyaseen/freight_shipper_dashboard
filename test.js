
    $(document).ready(function() {
        // Initialize signature pads with options
        const signaturePadOptions = {
            onBegin: function() {
                if (this.canvas.id === 'signaturePad1') {
                    setTimeout(checkFirstSignatureAndToggleButtons, 0);
                }
            },
            onEnd: function() {
                // Remove error state when user finishes drawing
                const $canvas = $(this.canvas);
                $canvas.removeClass('error');
                const $errorDiv = $canvas.next('.error-message');
                if ($errorDiv.length) {
                    $errorDiv.removeClass('show');
                }

                // Check first signature pad content
                if (this.canvas.id === 'signaturePad1') {
                    setTimeout(checkFirstSignatureAndToggleButtons, 0);
                }
            }
        };

        const signaturePad1 = new SignaturePad(document.getElementById('signaturePad1'), signaturePadOptions);
        const signaturePad2 = new SignaturePad(document.getElementById('signaturePad2'), signaturePadOptions);
        const signaturePad3 = new SignaturePad(document.getElementById('signaturePad3'), signaturePadOptions);
        const signaturePad4 = new SignaturePad(document.getElementById('signaturePad4'), signaturePadOptions);
        const signaturePad6 = new SignaturePad(document.getElementById('signaturePad6'), signaturePadOptions);

        // Add additional event listeners for the first signature pad
        signaturePad1.addEventListener("endStroke", () => {
            setTimeout(checkFirstSignatureAndToggleButtons, 0);
        });

        // Function to check first signature and toggle buttons
        function checkFirstSignatureAndToggleButtons() {
            const hasSignature = !signaturePad1.isEmpty();
            console.log('First signature pad has content:', hasSignature); // Debug log
            toggleUseAsAboveButtons(hasSignature);
        }

        // Function to toggle visibility of "Use as above" buttons
        function toggleUseAsAboveButtons(show) {
            console.log('Toggling buttons:', show); // Debug log
            $('.use-as-above').each(function() {
                $(this).toggleClass('show', show);
            });
        }

        // Check initial state
        checkFirstSignatureAndToggleButtons();

        // Handle "Use as above" button clicks
        $('.use-as-above').on('click', function() {
            console.log('Use as above clicked');
            console.log($(this).data('pad'));
            const padNumber = $(this).data('pad');
            const targetPad = eval('signaturePad' + padNumber);
            const currentInitials = document.getElementById('initials' + padNumber);

            // Clear the target pad first
            targetPad.clear();
            currentInitials.value= '';

            // Get the data from the first signature pad
            const sourceData = signaturePad1.toData();
            const sourceInitials = document.getElementById('initials1').value;
            if (sourceData) {
                // Copy the signature data to the target pad
                console.log(sourceData);
                console.log(sourceInitials);
                console.log(currentInitials);
                targetPad.fromData(sourceData);
                currentInitials.value = sourceInitials;

                // Remove any error states
                const $canvas = $(targetPad.canvas);
                validateSignature(targetPad, $canvas);
                // currentInitials.value = '';
            }
        });

        // Validation patterns
        const patterns = {
            email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            phone: /^\+?[\d\s-]{10,}$/,
            zipcode: /^\d{5}(-\d{4})?$/,
            // creditCard: /^\d{4}(-?\d{4}){3}$/,
            creditCard: /^\d{4}-?\d{4}-?\d{7,8}$/, // Updated pattern
            cvv: /^\d{3,4}$/,
            expDate: /^(0[1-9]|1[0-2])\/([0-9]{2})$/
        };

        // Validation messages
        const messages = {
            required: 'This field is required',
            email: 'Please enter a valid email address',
            phone: 'Please enter a valid phone number',
            zipcode: 'Please enter a valid ZIP code',
            creditCard: 'Please enter a valid credit card number',
            cvv: 'Please enter a valid security code',
            expDate: 'Please enter a valid expiration date (MM/YY)',
            minLength: 'Please enter at least {0} characters',
            maxLength: 'Please enter no more than {0} characters',
            signature: 'Signature is required'
        };

        // Add error message elements after each input
        $('.formInput').each(function() {
            const $input = $(this);
            const $errorDiv = $('<div>').addClass('error-message');
            $input.after($errorDiv);
        });

        // Validation function
        function validateField($field) {
            const fieldName = $field.attr('name');
            const value = $field.val().trim();
            const required = $field.prop('required');
            const type = $field.attr('type');
            const pattern = $field.data('pattern');
            const minLength = $field.data('minlength');
            const maxLength = $field.data('maxlength');




            let isValid = true;
            let errorMessage = '';

            // Required field validation
            if (required && !value) {
                isValid = false;
                errorMessage = messages.required;
            }
            // Length validation
            else if (value && minLength && value.length < minLength) {
                isValid = false;
                errorMessage = messages.minLength.replace('{0}', minLength);
            } else if (value && maxLength && value.length > maxLength) {
                isValid = false;
                errorMessage = messages.maxLength.replace('{0}', maxLength);
            }
            // Pattern validation
            else if (value && pattern && !new RegExp(pattern).test(value)) {
                isValid = false;
                errorMessage = messages[type] || 'Invalid format';
            }

            // Special field validations
            if (value && $field.attr('name') === 'credit_card_number') {
                if (!patterns.creditCard.test(value.replace(/\s+/g, ''))) {
                    isValid = false;
                    errorMessage = messages.creditCard;
                }
            } else if (value && $field.attr('name') === 'vid_security_code') {
                if (!patterns.cvv.test(value)) {
                    isValid = false;
                    errorMessage = messages.cvv;
                }
            } else if (value && $field.attr('name') === 'credit_card_expiration_date') {
                if (!patterns.expDate.test(value)) {
                    isValid = false;
                    errorMessage = messages.expDate;
                }
            }

            // Deposit amount check
			if (fieldName === 'deposit_amount') {
                    let totalAmount = parseFloat(<?php echo floatval($lead_data['total_trip_cost_c']); ?>);
                    const depositAmount = parseFloat(value);

                    // Ensure totalAmount is fixed to two decimal places
                    totalAmount = parseFloat(totalAmount.toFixed(2));

                    console.log(totalAmount, depositAmount);

                            if (depositAmount < (totalAmount / 2)) {
                                isValid = false;
                                errorMessage = `Kindly add a deposit greater than ${totalAmount / 2}`;
                            }
                }

           
            // Update field styling
            $field.toggleClass('error', !isValid);
            const $errorMessage = $field.next('.error-message');
            $errorMessage.text(errorMessage).toggleClass('show', !isValid);

            return isValid;
        }

        $('.deposit_amount_btn').on('click', function(e) {
            e.preventDefault();
            const totalAmount = parseFloat(<?php echo floatval($lead_data['total_trip_cost_c']); ?>);
            const percentage = $(this).data('amount'); // Get percentage from button
            const depositAmount = (totalAmount * percentage) / 100; // Calculate deposit amount
            $('#deposit_amount').val(depositAmount.toFixed(2)); // Set value with 2 decimal places
        });
        // Validate signature function
        function validateSignature(pad, $canvas) {
            const isEmpty = pad.isEmpty();
            const $errorDiv = $canvas.next('.error-message');

            if (isEmpty) {
                if (!$errorDiv.length) {
                    $('<div>').addClass('error-message show')
                        .text(messages.signature)
                        .insertAfter($canvas);
                } else {
                    $errorDiv.text(messages.signature).addClass('show');
                }
                $canvas.addClass('error');
                return false;
            } else {
                if ($errorDiv.length) {
                    $errorDiv.removeClass('show');
                }
                $canvas.removeClass('error');
                return true;
            }
        }

        // Real-time validation
        $('.formInput').on('input blur', function() {
            validateField($(this));
        });


        // Form submission handler
        $('#agreementForm').on('submit', function(e) {
            e.preventDefault();
            let isValid = true;

            // Validate all fields
            $('.formInput').each(function() {
                if (!validateField($(this))) {
                    isValid = false;
                }
            });

            // Validate signatures
            const signatures = [{
                    pad: signaturePad1,
                    canvas: $('#signaturePad1')
                },
                {
                    pad: signaturePad2,
                    canvas: $('#signaturePad2')
                },
                {
                    pad: signaturePad3,
                    canvas: $('#signaturePad3')
                },
                {
                    pad: signaturePad4,
                    canvas: $('#signaturePad4')
                },{
                    pad: signaturePad6,
                    canvas: $('#signaturePad6')
                }
            ];

            signatures.forEach(({
                pad,
                canvas
            }) => {
                if (!validateSignature(pad, canvas)) {
                    isValid = false;
                }
            });

            if (!isValid) {
                // Scroll to first error
                const $firstError = $('.error').first();
                if ($firstError.length) {
                    $('html, body').animate({
                        scrollTop: $firstError.offset().top - 100
                    }, 500);
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Form Validation Error',
                    text: 'Please fill in all required fields and provide all signatures.',
                    confirmButtonColor: '#3085d6'
                });

                return false;
            }

            // If valid, proceed with form submission
            var formData = new FormData(this);

            // Add signatures to form data
            formData.append('signature1', signaturePad1.toDataURL());
            formData.append('signature2', signaturePad2.toDataURL());
            formData.append('signature3', signaturePad3.toDataURL());
            formData.append('signature4', signaturePad4.toDataURL());
            formData.append('signature6', signaturePad6.toDataURL());

            <?php
            foreach ($lead_data as $key => $value) {
                ?>
                formData.append('<?php echo $key; ?>', '<?php echo json_encode(trim($value)); ?>');
            <?php
            }
            ?>

            // Show loading state
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we process your agreement',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // First send to process.php
            fetch('process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(processResponse => {
                try {
                    // if (processResponse.transaction_id) {
                        // If processing successful, proceed with PDF generation
                        fetch('generate_pdf.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(response => {
                            try {
                                if (response.success) {
                                    // Convert FormData to plain object
                                    var formDataObj = {};
                                    formData.forEach((value, key) => {
                                        formDataObj[key] = value;
                                    });

                                    // Send credit info
                                    fetch('https://unlimitedcharters.com/betacrm/index.php?entryPoint=VendorSystem', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded'
                                        },
                                        body: `credit_card_number=${formDataObj.credit_card_number}&credit_card_expiration_date=${formDataObj.credit_card_expiration_date}&vid_security_code=${formDataObj.vid_security_code}&paymentMethod=${formDataObj.paymentMethod}&zip=${formDataObj.zip}&address=${formDataObj.card_billing_address}&city=${formDataObj.city}&name=${formDataObj.first_name}+${formDataObj.last_name}&amount=${formDataObj.deposit_amount}&transaction_id=${processResponse.transaction_id}&method=addCreditInfo&lead_id=<?php echo $_GET['lead_id']; ?>&early_termination_cost=${formDataObj.early_termination_cost}`
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        console.log(data);
                                    })
                                    .catch(error => {
                                        console.error('Error sending credit info:', error);
                                    });

                                    // Send agreement email
                                    fetch('https://unlimitedcharters.com/betacrm/index.php?entryPoint=VendorSystem', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded'
                                        },
                                        body: `lead_id=<?php echo $_GET['lead_id']; ?>&lead_email=<?php echo $lead_data['email']; ?>&lead_name=<?php echo $lead_data['first_name']; ?>&method=sendAgreementMailPDF&agreementLink=https://unlimitedcharters.com/xeno/agreement/pdf/${response.pdfName}&userAgent=${navigator.userAgent}&userIp=${window.location.hostname}&dest1=${formDataObj.destination_address_1}&dest2=${formDataObj.destination_address_2}&dest3=${formDataObj.destination_address_3}&type=1`
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        console.log(data);
                                    })
                                    .catch(error => {
                                        console.error('Error sending agreement email:', error);
                                    });

                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Form processed successfully. Click OK to download the PDF.',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = 'pdf/' + response.pdfName;
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: response.message || 'PDF generation failed',
                                        icon: 'error'
                                    });
                                }
                            } catch (e) {
                                console.error('Error parsing PDF response:', e);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'An unexpected error occurred during PDF generation',
                                    icon: 'error'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error generating PDF:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to generate PDF',
                                icon: 'error'
                            });
                        });
                    // } else {
                    //     Swal.fire({
                    //         title: 'Error!',
                    //         text: processResponse.message || 'Processing failed',
                    //         icon: 'error'
                    //     });
                    // }
                } catch (e) {
                    console.error('Error parsing process response:', e);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An unexpected error occurred during processing',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Processing Error:', error);
                let errorMessage = 'Failed to process the form';
                try {
                    let formattedResponse = JSON.parse(error.responseText);
                    errorMessage = formattedResponse.error_code || errorMessage;
                } catch(e) {}
                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error'
                });
            });
        });

        // Clear button functionality
        $('.clear-button').on('click', function() {
            const padNumber = $(this).data('pad');
            const pad = eval('signaturePad' + padNumber);
            const currentInitials = document.getElementById('initials' + padNumber);
            pad.clear();
            currentInitials.value = '';

            // If clearing the first pad, hide the "Use as above" buttons
            if (padNumber === 1) {
                setTimeout(checkFirstSignatureAndToggleButtons, 0);
            }

            // Update validation state
            const $canvas = $(pad.canvas);
            validateSignature(pad, $canvas);
            currentInitials.value = '';
        });

        // Handle window resize for signature pads
        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            ['signaturePad1', 'signaturePad2', 'signaturePad3', 'signaturePad4'].forEach(id => {
                const canvas = document.getElementById(id);
                if (canvas) {
                    canvas.width = canvas.offsetWidth * ratio;
                    canvas.height = canvas.offsetHeight * ratio;
                    canvas.getContext("2d").scale(ratio, ratio);
                }
            });
        }

        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();
    });



    $(document).ready(function() {
                const eventDate = new Date('<?php echo $lead_data['eventdate_c']; ?>');
                const today = new Date();
                const diffTime = eventDate - today;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                const totalAmount = parseFloat(<?php echo floatval($lead_data['total_trip_cost_c']); ?>);

                if (diffDays <= 7) {
                    // Set full amount
                    $('#deposit_amount').val(totalAmount.toFixed(2));
                    // Hide buttons
                    $('.deposit_amount_btn').hide();
                    // Add message explaining why full payment is required
                    $('<div class="payment-notice" style="color: #f44336; margin-top: 10px;">')
                        .text('Full payment is required for bookings within 7 days of the event date.')
                        .insertAfter('#deposit_amount');
                    // Make the input readonly
                    $('#deposit_amount').prop('readonly', true);
                }
    });

    $(document).ready(function() {
    let totalAmount = 0;
    let earlyTerminationFee = 0;
    let newTotalTripCost = 0;
    let newTotalDepositCost = 0;
    
    $('#closeEarlyTermination').on('click', function() {
        $('#early-termination-container').hide();
    });
    $('#addEarlyTermination').on('change', function() {
        totalAmount = parseFloat(<?php echo floatval($lead_data['total_trip_cost_c']); ?>);
        earlyTerminationFee = Math.round(totalAmount * 0.15);
        $('#earlyTerminationFee').text(earlyTerminationFee.toFixed(2));
            $('#early-termination-container').show();
        });
        $('#addEarlyTerminationPrice').on('click', function() {
             totalAmount = parseFloat(<?php echo floatval($lead_data['total_trip_cost_c']); ?>);
             depositAmount = parseFloat($('#deposit_amount').val());
             earlyTerminationFee = Math.round(totalAmount * 0.15);
             newTotalTripCost = totalAmount + earlyTerminationFee;
             newTotalDepositCost = earlyTerminationFee + depositAmount;
             
            
            $('#early_termination_cost_value').text(earlyTerminationFee.toFixed(2));
            $('#early_termination_cost').val(earlyTerminationFee.toFixed(2));
            $('#early-termination-container').hide();
            $('#early-termination-cost-container').show();   
            $('#new-total-deposit-cost-container').show();   
            $('#new_total_deposit_cost_value').text((newTotalDepositCost).toFixed(2));
            // $('#new_total_deposit_cost_value').text((newTotalDepositCost).toFixed(2));
            $('#new-total-trip-cost-container').show();   
            $('#new_total_trip_cost_value').text((newTotalTripCost).toFixed(2));
            // $('#new_total_trip_cost_value').text((newTotalDepositCost).toFixed(2));
            $('#early_termination_cost_image').show();
            $('#early_termination_cost_image').attr('src', signaturePad6.toDataURL());
        });
    });
</script>