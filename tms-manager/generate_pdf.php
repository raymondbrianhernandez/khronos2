<?php

require_once 'dompdf/autoload.inc.php';

// Create a new Dompdf instance
$dompdf = new Dompdf();

// Load HTML content into Dompdf (your report content here)
$html = '<html><body>Your PDF content here</body></html>';
$dompdf->loadHtml($html);

// Render the PDF (you can customize PDF options as needed)
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Set appropriate headers for PDF document download
header('Content-Type: application/pdf');
header("Content-Disposition: attachment; filename=report.pdf");

// Output the PDF document
echo $dompdf->output();
