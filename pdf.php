<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if TCPDF exists
$tcpdfPath = __DIR__ . '/tcpdf/tcpdf.php';
if (!file_exists($tcpdfPath)) {
    die('TCPDF library not found at: ' . $tcpdfPath);
}

// Include TCPDF library
require_once($tcpdfPath);

// Function to generate PDF from agreement data
function generateAgreementPdf($agreementData, $signature, $paymentData = null) {
    // Create new PDF document with larger page size to accommodate signature
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator('StretchXL Freight');
    $pdf->SetAuthor('StretchXL Freight');
    $pdf->SetTitle('Freight Shipping Agreement - ' . $agreementData['id']);
    $pdf->SetSubject('Freight Shipping Agreement');
    $pdf->SetKeywords('freight, shipping, agreement');

    // Remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // Set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // Set margins
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetHeaderMargin(0);
    $pdf->SetFooterMargin(0);

    // Set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, 25);

    // Set image scale factor
    // Use TCPDF's constant for image scale ratio
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 10);

    // Initialize HTML content
    $html = '';

    // Company Header with styling
    $html .= '<div style="text-align:center;margin-bottom:30px;border-bottom:3px solid #2c5aa0;padding-bottom:15px;">';
    $html .= '<h1 style="color:#2c5aa0;font-size:24px;margin:0;font-weight:bold;line-height:0.1;">StretchXL Freight</h1>';
    $html .= '<h2 style="color:#666;font-size:16px;margin:5px 0 0 0;">FREIGHT SHIPPING AGREEMENT</h2>';
    $html .= '<div style="color:#888;font-size:10px;margin-top:10px;">Agreement ID: ' . htmlspecialchars($agreementData['id']) . '</div>';
    $html .= '<div style="color:#888;font-size:10px;">Generated: ' . date('F j, Y \a\t g:i A') . '</div>';
    $html .= '</div>';

    // Shipper Information Section
    $html .= '<div style="margin-bottom:-20px;">';
    $html .= '<table cellspacing="0" cellpadding="6" border="0" style="width:100%;border:2px solid #2c5aa0;border-radius:5px;">';
    $html .= '<tr><td colspan="4" style="background-color:#2c5aa0;color:white;font-weight:bold;font-size:12px;text-align:center;">SHIPPER INFORMATION</td></tr>';
    
    $html .= '<tr style="background-color:#f8f9fa;">';
    $html .= '<td style="width:15%;font-weight:bold;color:#2c5aa0;">Name:</td>';
    $html .= '<td style="width:35%;">' . htmlspecialchars($agreementData['shipper_name']) . '</td>';
    $html .= '<td style="width:15%;font-weight:bold;color:#2c5aa0;">Phone:</td>';
    $html .= '<td style="width:35%;">' . htmlspecialchars($agreementData['shipper_phone']) . '</td>';
    $html .= '</tr>';
    
    $html .= '<tr>';
    $html .= '<td style="font-weight:bold;color:#2c5aa0;">Address:</td>';
    $html .= '<td>' . htmlspecialchars($agreementData['shipper_address']) . '</td>';
    $html .= '<td style="font-weight:bold;color:#2c5aa0;">Email:</td>';
    $html .= '<td>' . htmlspecialchars($agreementData['shipper_email']) . '</td>';
    $html .= '</tr>';
    $html .= '</table>';
    $html .= '</div>';

    // Shipment Details Section
    $html .= '<div style="margin-bottom:-10px;">';
    $html .= '<table cellspacing="0" cellpadding="8" border="0" style="width:100%;border:2px solid #28a745;border-radius:5px;">';
    $html .= '<tr><td colspan="4" style="background-color:#28a745;color:white;font-weight:bold;font-size:12px;text-align:center;">SHIPMENT DETAILS</td></tr>';
    
    $html .= '<tr style="background-color:#f8f9fa;">';
    $html .= '<td style="width:20%;font-weight:bold;color:#28a745;">Pickup Location:</td>';
    $html .= '<td style="width:30%;">' . htmlspecialchars($agreementData['pickup_address']) . '</td>';
    $html .= '<td style="width:20%;font-weight:bold;color:#28a745;">Dropoff Location:</td>';
    $html .= '<td style="width:30%;">' . htmlspecialchars($agreementData['dropoff_address']) . '</td>';
    $html .= '</tr>';
    
    $html .= '<tr>';
    $html .= '<td style="font-weight:bold;color:#28a745;">Pickup Date/Time:</td>';
    $html .= '<td>' . date('M j, Y g:i A', strtotime($agreementData['pickup_date'] . ' ' . $agreementData['pickup_time'])) . '</td>';
    $html .= '<td style="font-weight:bold;color:#28a745;">Dropoff Date/Time:</td>';
    $html .= '<td>' . date('M j, Y g:i A', strtotime($agreementData['dropoff_date'] . ' ' . $agreementData['dropoff_time'])) . '</td>';
    $html .= '</tr>';
    
    $html .= '<tr style="background-color:#f8f9fa;">';
    $html .= '<td style="font-weight:bold;color:#28a745;">Freight Type:</td>';
    $html .= '<td>' . ucfirst(str_replace('_', ' ', htmlspecialchars($agreementData['freight_type']))) . '</td>';
    $html .= '<td style="font-weight:bold;color:#28a745;">Vehicle Type:</td>';
    $html .= '<td>' . ucfirst(str_replace('_', ' ', htmlspecialchars($agreementData['carrier_vehicle_type']))) . '</td>';
    $html .= '</tr>';
    
    $html .= '<tr>';
    $html .= '<td style="font-weight:bold;color:#28a745;">Distance:</td>';
    $html .= '<td>' . htmlspecialchars($agreementData['distance']) . '</td>';
    $html .= '<td style="font-weight:bold;color:#28a745;">Duration:</td>';
    $html .= '<td>' . htmlspecialchars($agreementData['duration']) . '</td>';
    $html .= '</tr>';
    $html .= '</table>';
    $html .= '</div>';

    // Freight Specifications
    $html .= '<div style="margin-bottom:10px;">';
    $html .= '<table cellspacing="0" cellpadding="8" border="0" style="width:100%;border:2px solid #ffc107;border-radius:5px;">';
    $html .= '<tr><td colspan="4" style="background-color:#ffc107;color:#212529;font-weight:bold;font-size:12px;text-align:center;">FREIGHT SPECIFICATIONS</td></tr>';
    
    $html .= '<tr style="background-color:#fffbf0;">';
    $html .= '<td style="width:25%;font-weight:bold;color:#856404;">Weight:</td>';
    $html .= '<td style="width:25%;">' . htmlspecialchars($agreementData['freight_weight']) . ' lbs</td>';
    $html .= '<td style="width:25%;font-weight:bold;color:#856404;">Dimensions:</td>';
    $html .= '<td style="width:25%;">' . htmlspecialchars($agreementData['freight_length']) . 'L × ' . htmlspecialchars($agreementData['freight_width']) . 'W × ' . htmlspecialchars($agreementData['freight_height']) . 'H</td>';
    $html .= '</tr>';
    
    $html .= '<tr>';
    $html .= '<td style="font-weight:bold;color:#856404;">Pallet Count:</td>';
    $html .= '<td>' . htmlspecialchars($agreementData['freight_pallet_count']) . '</td>';
    $html .= '<td style="font-weight:bold;color:#856404;">Box Count:</td>';
    $html .= '<td>' . htmlspecialchars($agreementData['freight_box_count']) . '</td>';
    $html .= '</tr>';
    
    if (!empty($agreementData['description'])) {
        $html .= '<tr style="background-color:#fffbf0;">';
        $html .= '<td style="font-weight:bold;color:#856404;">Description:</td>';
        $html .= '<td colspan="3">' . htmlspecialchars($agreementData['description']) . '</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';
    $html .= '</div>';

    // Pricing Summary
    $baseRate = floatval($agreementData['platform_price']);
    $addonsTotal = floatval($agreementData['addons_total']);
    $totalPrice = floatval($agreementData['total_price']);
    $fuelCost = floatval($agreementData['fuel']);

    $html .= '<div style="margin-bottom:10px;">';
    $html .= '<table cellspacing="0" cellpadding="8" border="0" style="width:100%;border:2px solid #dc3545;border-radius:5px;">';
    $html .= '<tr><td colspan="2" style="background-color:#dc3545;color:white;font-weight:bold;font-size:12px;text-align:center;">PRICING SUMMARY</td></tr>';
    
    $html .= '<tr style="background-color:#fff5f5;">';
    $html .= '<td style="width:70%;font-weight:bold;color:#721c24;">Base Transportation Rate</td>';
    $html .= '<td style="width:30%;text-align:right;font-weight:bold;">$' . number_format($baseRate, 2) . '</td>';
    $html .= '</tr>';
    
    if ($fuelCost > 0) {
        $html .= '<tr>';
        $html .= '<td style="color:#721c24;">Fuel Surcharge</td>';
        $html .= '<td style="text-align:right;">$' . number_format($fuelCost, 2) . '</td>';
        $html .= '</tr>';
    }
    
    if ($addonsTotal > 0) {
        $html .= '<tr style="background-color:#fff5f5;">';
        $html .= '<td style="color:#721c24;">Additional Services</td>';
        $html .= '<td style="text-align:right;">$' . number_format($addonsTotal, 2) . '</td>';
        $html .= '</tr>';
    }
    
    $html .= '<tr style="border-top:2px solid #dc3545;">';
    $html .= '<td style="font-weight:bold;color:#721c24;font-size:14px;">TOTAL AMOUNT</td>';
    $html .= '<td style="text-align:right;font-weight:bold;font-size:14px;color:#dc3545;">$' . number_format($totalPrice, 2) . '</td>';
    $html .= '</tr>';
    $html .= '</table>';
    $html .= '</div>';

   
    
    // Payment Information (if provided)
    if ($paymentData && isset($paymentData['card_number'])) {
        $html .= '<div style="margin-bottom:10px;">';
        $html .= '<table cellspacing="0" cellpadding="8" border="0" style="width:100%;border:2px solid #6f42c1;border-radius:5px;">';
        $html .= '<tr><td colspan="2" style="background-color:#6f42c1;color:white;font-weight:bold;font-size:12px;text-align:center;">PAYMENT INFORMATION</td></tr>';
        
        $html .= '<tr style="background-color:#f8f6ff;">';
        $html .= '<td style="width:50%;font-weight:bold;color:#4c2a85;">Payment Method:</td>';
        $html .= '<td style="width:50%;">Credit Card</td>';
        $html .= '</tr>';
        
        $html .= '<tr>';
        $html .= '<td style="font-weight:bold;color:#4c2a85;">Card ID:</td>';
        $html .= '<td>****-****-****-' . substr($paymentData['card_number'], -4) . '</td>';
        $html .= '</tr>';
        
        $html .= '<tr style="background-color:#f8f6ff;">';
        $html .= '<td style="font-weight:bold;color:#4c2a85;">Transaction Amount:</td>';
        $html .= '<td style="font-weight:bold;">$' . number_format(floatval($paymentData['amount']), 2) . '</td>';
        $html .= '</tr>';
        $html .= '</table>';
        $html .= '</div>';
    }
   

    // Terms and Conditions
    $html .= '<div style="margin-bottom:30px;">';
    $html .= '<h3 style="color:#2c5aa0;font-size:14px;margin-bottom:30px;border-bottom:1px solid #2c5aa0;padding-bottom:20px;">TERMS AND CONDITIONS</h3>';
    $html .= '<div style="font-size:9px;line-height:1.6;color:#333;">';
    $html .= '<table cellspacing="0" cellpadding="3" border="0" style="width:100%;">';
    
    $terms = [
        'LIABILITY' => 'The carrier\'s liability for loss or damage to cargo is limited to $0.50 per pound unless a higher value is declared and additional charges are paid.',
        'PAYMENT TERMS' => 'Payment is due in full within 15 days of invoice date. Late payments may be subject to a 1.5% monthly finance charge.',
        'PICKUP/DELIVERY' => 'Shipper is responsible for loading and consignee is responsible for unloading the shipment unless otherwise arranged.',
        'CLAIMS' => 'All claims for loss or damage must be submitted in writing within 60 days of delivery.',
        'ACCESSORIAL CHARGES' => 'Additional charges may apply for services including but not limited to: liftgate service, inside delivery, residential pickup/delivery, and storage.',
        'HAZARDOUS MATERIALS' => 'Shipment of hazardous materials must be declared in writing prior to pickup and must comply with all applicable regulations.',
        'FORCE MAJEURE' => 'Neither party shall be liable for any failure or delay in performance due to causes beyond their reasonable control.',
        'GOVERNING LAW' => 'This agreement shall be governed by and construed in accordance with the laws of the state where the carrier\'s principal place of business is located.'
    ];
    
    $counter = 1;
    foreach ($terms as $title => $content) {
        $html .= '<tr>';
        $html .= '<td style="width:5%;vertical-align:top;font-weight:bold;">' . $counter . '.</td>';
        $html .= '<td style="width:25%;vertical-align:top;font-weight:bold;color:#2c5aa0;">' . $title . ':</td>';
        $html .= '<td style="width:70%;vertical-align:top;">' . $content . '</td>';
        $html .= '</tr>';
        $counter++;
    }
    
    $html .= '</table>';
    $html .= '</div>';
    $html .= '</div>';

    // Signature Section
    $html .= '<div style="margin-top:40px;border-top:2px solid #2c5aa0;padding-top:20px;">';
    $html .= '<h3 style="color:#2c5aa0;font-size:14px;margin-bottom:20px;">AGREEMENT SIGNATURE</h3>';
    
    $html .= '<table cellspacing="0" cellpadding="10" border="0" style="width:100%;">';
    $html .= '<tr>';
    
    // Left side - Signature
    $html .= '<td style="width:60%;vertical-align:top;">';
    $html .= '<div style="font-weight:bold;color:#2c5aa0;margin-bottom:10px;">Shipper\'s Signature:</div>';
    
    // Handle signature display
    if (!empty($signature)) {
        // Clean up the signature data
        $signatureData = $signature;
        if (strpos($signatureData, 'data:image/png;base64,') === 0) {
            $signatureData = str_replace('data:image/png;base64,', '', $signatureData);
        }
        
        // Create a temporary file for the signature
        $tempDir = sys_get_temp_dir();
        $tempFile = $tempDir . '/signature_' . uniqid() . '.png';
        
        try {
            $decodedSignature = base64_decode($signatureData);
            if ($decodedSignature !== false) {
                file_put_contents($tempFile, $decodedSignature);
                
                // Add the signature image to PDF
                $pdf->writeHTML($html, true, false, true, false, '');
                
                // Get current position
                $y = $pdf->GetY();
                
                // Add signature image
                $pdf->Image($tempFile, 20, $y, 80, 30, 'PNG');
                
                // Clean up temp file
                unlink($tempFile);
                
                // Move to next position
                $pdf->SetY($y + 35);
                
                // Add remaining content
                $html = '<table cellspacing="0" cellpadding="10" border="0" style="width:100%;">';
                $html .= '<tr>';
                $html .= '<td style="width:60%;">&nbsp;</td>';
                $html .= '<td style="width:40%;text-align:right;vertical-align:top;">';
                $html .= '<div style="font-weight:bold;color:#2c5aa0;margin-bottom:5px;">Date Signed:</div>';
                $html .= '<div style="padding:5px;border:1px solid #ddd;background-color:#f8f9fa;">' . date('F j, Y') . '</div>';
                $html .= '<div style="margin-top:15px;font-weight:bold;color:#2c5aa0;">Agreement Status:</div>';
                $html .= '<div style="padding:5px;background-color:#d4edda;color:#155724;border:1px solid #c3e6cb;font-weight:bold;">SIGNED & CONFIRMED</div>';
                $html .= '</td>';
                $html .= '</tr>';
                $html .= '</table>';
                
                $pdf->writeHTML($html, true, false, true, false, '');
                
            } else {
                // Fallback if signature decode fails
                $html .= '<div style="height:40px;border:1px solid #ddd;background-color:#f8f9fa;text-align:center;line-height:40px;color:#666;">Signature could not be displayed</div>';
                $html .= '</td>';
                
                // Right side - Date and Status
                $html .= '<td style="width:40%;text-align:right;vertical-align:top;">';
                $html .= '<div style="font-weight:bold;color:#2c5aa0;margin-bottom:5px;">Date Signed:</div>';
                $html .= '<div style="padding:5px;border:1px solid #ddd;background-color:#f8f9fa;">' . date('F j, Y') . '</div>';
                $html .= '<div style="margin-top:15px;font-weight:bold;color:#2c5aa0;">Agreement Status:</div>';
                $html .= '<div style="padding:5px;background-color:#d4edda;color:#155724;border:1px solid #c3e6cb;font-weight:bold;">SIGNED & CONFIRMED</div>';
                $html .= '</td>';
                $html .= '</tr>';
                $html .= '</table>';
                
                $pdf->writeHTML($html, true, false, true, false, '');
            }
        } catch (Exception $e) {
            // Fallback for any errors
            $html .= '<div style="height:40px;border:1px solid #ddd;background-color:#f8f9fa;text-align:center;line-height:40px;color:#666;">Signature Error</div>';
            $html .= '</td>';
            
            $html .= '<td style="width:40%;text-align:right;vertical-align:top;">';
            $html .= '<div style="font-weight:bold;color:#2c5aa0;margin-bottom:5px;">Date Signed:</div>';
            $html .= '<div style="padding:5px;border:1px solid #ddd;background-color:#f8f9fa;">' . date('F j, Y') . '</div>';
            $html .= '</td>';
            $html .= '</tr>';
            $html .= '</table>';
            
            $pdf->writeHTML($html, true, false, true, false, '');
        }
    } else {
        // No signature provided
        $html .= '<div style="height:40px;border-bottom:2px solid #2c5aa0;width:80%;margin-bottom:5px;"></div>';
        $html .= '<div style="font-size:9px;color:#666;">Please sign above</div>';
        $html .= '</td>';
        
        // Right side - Date
        $html .= '<td style="width:40%;text-align:right;vertical-align:top;">';
        $html .= '<div style="font-weight:bold;color:#2c5aa0;margin-bottom:5px;">Date:</div>';
        $html .= '<div style="height:25px;border-bottom:1px solid #2c5aa0;width:100%;"></div>';
        $html .= '</td>';
        $html .= '</tr>';
        $html .= '</table>';
        
        $pdf->writeHTML($html, true, false, true, false, '');
    }

    try {
        // Create the pdf directory if it doesn't exist
        $pdfDir = __DIR__ . '/pdf';
        if (!file_exists($pdfDir)) {
            if (!@mkdir($pdfDir, 0777, true)) {
                throw new Exception('Failed to create PDF directory: ' . $pdfDir);
            }
        }

        // Check if directory is writable
        if (!is_writable($pdfDir)) {
            throw new Exception('PDF directory is not writable: ' . $pdfDir);
        }

        // Generate a unique filename
        $filename = 'agreement_' . $agreementData['id'] . '_' . time() . '.pdf';
        $filepath = $pdfDir . '/' . $filename;

        // Save the PDF
        $pdfContent = $pdf->Output('', 'S'); // Get PDF content as string
        
        // Save to file
        if (file_put_contents($filepath, $pdfContent) === false) {
            throw new Exception('Failed to write PDF file: ' . $filepath);
        }

        // Verify file was created
        if (!file_exists($filepath)) {
            throw new Exception('PDF file was not created: ' . $filepath);
        }

        // Return the relative path to the PDF
        return 'pdf/' . $filename;
        
    } catch (Exception $e) {
        // Log the error
        error_log('PDF Generation Error: ' . $e->getMessage());
        throw $e; // Re-throw to be caught by the calling code
    }
}

// Test endpoint to check PDF generation
if (isset($_GET['test'])) {
    try {
        // Create a test PDF
        $testPdf = new TCPDF('P', 'mm', 'A4');
        $testPdf->AddPage();
        $testPdf->SetFont('helvetica', '', 12);
        $testPdf->Cell(0, 10, 'Test PDF Generation', 0, 1, 'C');
        
        $testFile = __DIR__ . '/pdf/test_' . time() . '.pdf';
        if (!is_dir(dirname($testFile))) {
            mkdir(dirname($testFile), 0777, true);
        }
        
        $testPdf->Output($testFile, 'F');
        
        if (file_exists($testFile)) {
            echo "Test PDF created successfully at: " . $testFile . "<br>";
            echo "Directory permissions: " . substr(sprintf('%o', fileperms(dirname($testFile))), -4) . "<br>";
            echo "File permissions: " . substr(sprintf('%o', fileperms($testFile)), -4) . "<br>";
            echo "<a href='pdf/" . basename($testFile) . "' target='_blank'>View Test PDF</a>";
        } else {
            echo "Failed to create test PDF. Check server error logs.";
        }
        exit;
    } catch (Exception $e) {
        die("Test failed: " . $e->getMessage());
    }
}

// Enable error logging for debugging
error_log('PDF Generation Request: ' . print_r($_REQUEST, true));

// Set content type for JSON responses
header('Content-Type: application/json');

// Handle test mode
if (isset($_GET['test']) || (isset($_POST['test']) && $_POST['test'] === 'true')) {
    try {
        // Create a simple test PDF
        $testPdf = new TCPDF('P', 'mm', 'A4');
        $testPdf->AddPage();
        $testPdf->SetFont('helvetica', '', 12);
        $testPdf->Cell(0, 10, 'Test PDF Generation - ' . date('Y-m-d H:i:s'), 0, 1, 'C');
        $testPdf->Cell(0, 10, 'This is a test PDF to verify that the PDF generation is working.', 0, 1, 'C');
        
        // Create pdf directory if it doesn't exist
        $pdfDir = __DIR__ . '/pdf';
        if (!file_exists($pdfDir)) {
            if (!mkdir($pdfDir, 0777, true)) {
                throw new Exception('Failed to create PDF directory');
            }
        }
        
        // Generate a unique filename
        $filename = 'test_' . uniqid() . '.pdf';
        $filepath = $pdfDir . '/' . $filename;
        
        // Save the PDF
        $testPdf->Output($filepath, 'F');
        
        // Verify the file was created
        if (!file_exists($filepath)) {
            throw new Exception('Failed to create test PDF file');
        }
        
        // Return success response
        echo json_encode([
            'success' => true,
            'message' => 'Test PDF generated successfully',
            'pdfPath' => 'pdf/' . $filename,
            'pdfUrl' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . 
                       '://' . $_SERVER['HTTP_HOST'] . 
                       rtrim(dirname($_SERVER['PHP_SELF']), '/') . '/pdf/' . $filename
        ]);
        exit;
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Test PDF generation failed: ' . $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        exit;
    }
}

// Handle API request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get the raw POST data
        $json = file_get_contents('php://input');
        if ($json === false) {
            throw new Exception('Failed to read POST data');
        }
        
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON data: ' . json_last_error_msg());
        }
        
        if (empty($data) || !isset($data['shipmentData'])) {
            throw new Exception('Missing required data: shipmentData');
        }
        
        // Log received data for debugging
        error_log('PDF Generation Request: ' . print_r([
            'shipmentData_keys' => array_keys($data['shipmentData']),
            'has_signature' => !empty($data['signature']),
            'has_payment' => !empty($data['card_number']) && !empty($data['amount'])
        ], true));

        // Extract payment data if available
        $paymentData = null;
        if (isset($data['card_number']) && isset($data['amount'])) {
            $paymentData = [
                'card_number' => $data['card_number'],
                'amount' => $data['amount']
            ];
        }
        
        // Generate the PDF
        $pdfPath = generateAgreementPdf(
            $data['shipmentData'], 
            $data['signature'] ?? null,
            $paymentData
        );
        
        // Verify the PDF was created
        if (!file_exists(__DIR__ . '/' . $pdfPath)) {
            throw new Exception('PDF file was not created at expected location: ' . $pdfPath);
        }
        
        // Return success response with PDF path
        $response = [
            'success' => true,
            'pdfPath' => $pdfPath,
            'pdfUrl' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . 
                       '://' . $_SERVER['HTTP_HOST'] . 
                       rtrim(dirname($_SERVER['PHP_SELF']), '/') . '/' . 
                       ltrim($pdfPath, '/'),
            'message' => 'PDF generated successfully'
        ];
        
        header('Content-Type: application/json');
        echo json_encode($response);
        
    } catch (Exception $e) {
        // Log the full error with trace
        error_log('PDF Generation Failed: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        
        // Return error response
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'error' => 'Failed to generate PDF: ' . $e->getMessage(),
            'error_details' => [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => explode("\n", $e->getTraceAsString())[0] // First line of trace
            ]
        ]);
    }
} else {
    // Invalid request method
    header('HTTP/1.1 405 Method Not Allowed');
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'error' => 'Method not allowed. Use POST.'
    ]);
}
exit;
?>