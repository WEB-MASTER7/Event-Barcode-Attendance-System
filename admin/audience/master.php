<?php
require_once('../../config.php');
require 'vendor/autoload.php'; // Load PHPSpreadsheet

if (isset($_GET['f'])) {
    switch ($_GET['f']) {
        case 'import_audience':
            importAudience();
            break;
        // Additional functions can be added here
    }
}

function importAudience() {
    global $conn; // Use the global connection variable

    if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['excelFile'];
        $fileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file['tmp_name']);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($fileType);
        $spreadsheet = $reader->load($file['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        foreach ($sheetData as $row) {
            $name = $row['A'];
            $email = $row['B'];
            $contact = $row['C'];
            $remarks = $row['D'];
            $event_id = $row['E'];

            $stmt = $conn->prepare("INSERT INTO event_audience (name, email, contact, remarks, event_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $name, $email, $contact, $remarks, $event_id);
            $stmt->execute();
        }

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'File upload error']);
    }
}
?>
