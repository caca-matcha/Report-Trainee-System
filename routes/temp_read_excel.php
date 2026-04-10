<?php

use Illuminate\Support\Facades\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;

Route::get('/dev/read-excel', function () {
    $files = [
        'Standarisasi Kode training.xlsx',
        'Master Central Customer Satisfaction Index (CSI) Training (1-109) (2).xlsx',
        'Form Observasi Report Training SS.xlsx',
        'Pre & Post Training Kaizen & Standarisasi Kerja(1-34).xlsx',
    ];

    $result = '';

    foreach ($files as $file) {
        $result .= "\n\n========== $file ==========\n";
        $path = base_path($file);
        if (!file_exists($path)) {
            $result .= "FILE NOT FOUND: $path\n";
            continue;
        }
        try {
            $spreadsheet = IOFactory::load($path);
            foreach ($spreadsheet->getSheetNames() as $sheetName) {
                $result .= "\n--- Sheet: $sheetName ---\n";
                $ws = $spreadsheet->getSheetByName($sheetName);
                $maxRow = min(15, $ws->getHighestRow());
                $maxCol = $ws->getHighestColumn();
                for ($row = 1; $row <= $maxRow; $row++) {
                    $rowData = [];
                    for ($col = 'A'; $col <= $maxCol; $col++) {
                        $val = $ws->getCell($col . $row)->getValue();
                        if ($val !== null && $val !== '') {
                            $rowData[] = "{$col}{$row}:" . substr((string) $val, 0, 35);
                        }
                        if ($col === 'Z')
                            break;
                    }
                    if (!empty($rowData)) {
                        $result .= "  Row[$row]: " . implode(' | ', array_slice($rowData, 0, 10)) . "\n";
                    }
                }
            }
        } catch (\Exception $e) {
            $result .= "ERROR: " . $e->getMessage() . "\n";
        }
    }

    return response($result, 200)->header('Content-Type', 'text/plain; charset=utf-8');
});

