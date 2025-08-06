<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the TCPDF library
require_once('tcpdf/tcpdf.php');

// Create test data
$testData = [
    'id' => 'TEST_' . uniqid(),
    'shipper_name' => 'Test Shipper',
    'shipper_phone' => '123-456-7890',
    'shipper_email' => 'test@example.com',
    'shipper_address' => '123 Test St, Test City, TS 12345',
    'pickup_address' => '456 Pickup St, Pickup City, PC 12345',
    'dropoff_address' => '789 Delivery St, Delivery City, DC 12345',
    'pickup_date' => date('Y-m-d'),
    'pickup_time' => '10:00:00',
    'dropoff_date' => date('Y-m-d', strtotime('+1 day')),
    'dropoff_time' => '14:00:00',
    'freight_type' => 'general',
    'carrier_vehicle_type' => 'box_truck',
    'distance' => '150 miles',
    'duration' => '3 hours',
    'freight_weight' => '1000',
    'freight_length' => '48',
    'freight_width' => '40',
    'freight_height' => '40',
    'freight_pallet_count' => '2',
    'freight_box_count' => '10',
    'description' => 'Test shipment',
    'platform_price' => '500.00',
    'addons_total' => '50.00',
    'total_price' => '550.00',
    'fuel' => '25.00'
];

// Create a test PDF
function createTestPdf($data) {
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    
    // Set document information
    $pdf->SetCreator('Test Script');
    $pdf->SetAuthor('Test Script');
    $pdf->SetTitle('Test PDF');
    
    // Remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    
    // Add a page
    $pdf->AddPage();
    
    // Add some content
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Test PDF Generation', 0, 1, 'C');
    $pdf->Ln(10);
    
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, 'Shipment ID: ' . $data['id'], 0, 1);
    $pdf->Cell(0, 10, 'Shipper: ' . $data['shipper_name'], 0, 1);
    $pdf->Cell(0, 10, 'From: ' . $data['pickup_address'], 0, 1);
    $pdf->Cell(0, 10, 'To: ' . $data['dropoff_address'], 0, 1);
    $pdf->Cell(0, 10, 'Total Price: $' . $data['total_price'], 0, 1);
    
    // Save the PDF
    $pdfDir = __DIR__ . '/pdf';
    if (!file_exists($pdfDir)) {
        mkdir($pdfDir, 0777, true);
    }
    
    $filename = 'test_' . $data['id'] . '.pdf';
    $filepath = $pdfDir . '/' . $filename;
    
    $pdf->Output($filepath, 'F');
    
    return [
        'success' => file_exists($filepath),
        'filepath' => 'pdf/' . $filename,
        'full_path' => $filepath
    ];
}

// Run the test
$result = createTestPdf($testData);

// Output results
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>PDF Generation Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        pre { background: #f5f5f5; padding: 10px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <h1>PDF Generation Test</h1>
    
    <?php if ($result['success']): ?>
        <p class="success">✓ PDF generated successfully!</p>
        <p>File saved to: <?php echo htmlspecialchars($result['filepath']); ?></p>
        <p><a href="<?php echo htmlspecialchars($result['filepath']); ?>" target="_blank">View PDF</a></p>
    <?php else: ?>
        <p class="error">✗ Failed to generate PDF</p>
        <p>Check server error logs for more information.</p>
    <?php endif; ?>
    
    <h2>Test Data:</h2>
    <pre><?php echo htmlspecialchars(print_r($testData, true)); ?></pre>
    
    <h2>Result:</h2>
    <pre><?php echo htmlspecialchars(print_r($result, true)); ?></pre>
    
    <h2>Directory Permissions:</h2>
    <pre>PDF Directory: <?php echo is_writable(__DIR__ . '/pdf') ? 'Writable' : 'Not writable'; ?></pre>
    
    <h2>PHP Info:</h2>
    <p>PHP Version: <?php echo phpversion(); ?></p>
    <p>Memory Limit: <?php echo ini_get('memory_limit'); ?></p>
    <p>Max Execution Time: <?php echo ini_get('max_execution_time'); ?> seconds</p>
    
    <h2>Next Steps:</h2>
    <ol>
        <li>Check if the PDF was created at: <?php echo htmlspecialchars($result['full_path'] ?? 'N/A'); ?></li>
        <li>Check PHP error logs for any errors during PDF generation</li>
        <li>Verify that the TCPDF library is properly installed in the tcpdf/ directory</li>
        <li>Check that the web server has write permissions to the pdf/ directory</li>
    </ol>
</body>
</html>
