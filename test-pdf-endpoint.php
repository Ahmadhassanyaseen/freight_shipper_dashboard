<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set content type for JSON
header('Content-Type: application/json');

// Simple test function to check if TCPDF is working
function testTcpdf() {
    try {
        // Include TCPDF library
        require_once('tcpdf/tcpdf.php');
        
        // Create new PDF document
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
        $pdf->Cell(0, 10, 'Server Time: ' . date('Y-m-d H:i:s'), 0, 1);
        
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
        $pdf->Output($filepath, 'F');
        
        // Verify the file was created
        if (!file_exists($filepath)) {
            throw new Exception('Failed to create PDF file');
        }
        
        return [
            'success' => true,
            'message' => 'PDF generated successfully',
            'filepath' => $filepath,
            'url' => 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/') . '/pdf/' . $filename
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ];
    }
}

// Run the test
$result = testTcpdf();

// Output the result
echo json_encode($result, JSON_PRETTY_PRINT);
?>
