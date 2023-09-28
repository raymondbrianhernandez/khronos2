<?php
// Set the content type as a Word document
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
// Set the Content-Disposition header to prompt the user to download the file
header('Content-Disposition: attachment; filename="oclm_report.docx"');

// Read and output the contents of the Word document
readfile('C:\Users\Owner\Downloads\oclm_report.docx');
?>

