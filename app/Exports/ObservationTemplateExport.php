<?php

namespace App\Exports;

use App\Models\Training;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ObservationTemplateExport implements FromCollection, WithStyles, WithColumnWidths
{
    protected $training;

    public function __construct(Training $training)
    {
        $this->training = $training;
    }

    public function collection()
    {
        // Group participants: DP first, then others
        $participants = $this->training->participants->sortByDesc(fn($p) => $p->subco === 'DP');
        $participantCount = $participants->count();

        // Removed Column D. Table Header Area: A (No), B-C (Item Observasi)
        // Participants start at Column D (Index 3)
        $displayCount = max(4, $participantCount); // Minimum 4 columns for signatures
        $totalCols = 3 + $displayCount;

        // Define dynamic indices for signatures (aligned to the rightmost edge)
        $obsIdx = $totalCols - 4;
        $dikIdx = $totalCols - 2;

        $data = [];

        // Column after signature blocks for Instructions (e.g., $totalCols + 1)
        $instrIdx = $totalCols + 1;

        // Row 1: Title & Signature Labels & Instruction Header
        $row1 = array_fill(0, $instrIdx + 4, '');
        $row1[0] = 'FORM OBSERVASI TRAINING';
        $row1[$obsIdx] = 'Observer';
        $row1[$dikIdx] = 'Diketahui';
        $row1[$instrIdx] = 'Petunjuk Pengisian:';
        $data[] = $row1;

        // Row 2: Empty for signature boxes & Instruction 1
        $row2 = array_fill(0, $instrIdx + 4, '');
        $row2[$instrIdx] = '1. Ketik "1" untuk tanda (v)';
        $data[] = $row2;

        // Row 3: Nama Training & Instruction 2
        $row3 = array_fill(0, $instrIdx + 4, '');
        $row3[0] = 'Nama Training';
        $row3[2] = ': ' . $this->training->title;
        $row3[$instrIdx] = '2. Ketik "0" untuk tanda (x)';
        $data[] = $row3;

        // Row 4: Tanggal & Signature "nama" & Instruction 3
        $row4 = array_fill(0, $instrIdx + 4, '');
        $row4[0] = 'Tanggal';
        $row4[2] = ': ' . $this->training->start_date;
        $row4[$obsIdx] = 'nama';
        $row4[$dikIdx] = 'nama';
        $row4[$instrIdx] = '3. Skor otomatis terhitung';
        $data[] = $row4;

        // Row 5: Trainer & Signature "Manager Class"
        $row5 = array_fill(0, $instrIdx + 4, '');
        $row5[0] = 'Trainer';
        $row5[2] = ': ' . auth()->user()->name;
        $row5[$obsIdx] = 'Manager Class';
        $row5[$dikIdx] = '....';
        $data[] = $row5;

        $data[] = array_fill(0, $instrIdx + 4, ''); // Spacer Row 6

        // Row 7: Header labels (Combined B and C for Item Observasi)
        $row7 = array_fill(0, $totalCols, '');
        $row7[0] = 'No';
        $row7[1] = 'Item Observasi';
        $row7[3] = 'Checksheet Observasi Peserta (v / x)';
        $data[] = $row7;

        // Row 8: Subcos (Starts from Index 3 - Col D) - NO MERGING
        $subcos = array_fill(0, 3, '');
        foreach ($participants as $p) {
            $subcos[] = $p->subco;
        }
        $data[] = $subcos;

        // Row 9: Names (Starts from Index 3 - Col D)
        $names = array_fill(0, 3, '');
        foreach ($participants as $p) {
            $names[] = $p->name;
        }
        $data[] = $names;

        // Scoring Categories
        $categories = [
            'PUNCTUALITY' => [
                'Kehadiran lebih dari 15 menit sebelum Training dimulai',
                'Kehadiran tepat waktu sebelum training dimulai',
                'Hadir tepat waktu setelah istirahat sesi break selesai',
                'Hadir tepat waktu setelah istirahat makan siang selesai',
                'Tepat waktu saat mengumpulkan tugas/test/quiz'
            ],
            'ACTIVENESS' => [
                'Menjawab pertanyaan namun belum tepat',
                'Menjawab pertanyaan dengan tepat dan antusias',
                'Bertanya satu kali saat proses training',
                'Bertanya lebih dari satu kali saat proses training',
                'Mampu mengemukakan pendapat dengan baik',
                'Aktif berdiskusi pada saat proses training',
                'Mencatat atau mendokumentasikan hal-hal penting yang didapat saat training'
            ],
            'COOPERATION' => [
                'Mampu bekerja sama dengan baik antar peserta atau kelompok',
                'Mendengar dengan tenang saat proses training berlangsung',
                'Tidak mengerjakan pekerjaan/tugas lain selama training',
                'Tidak menggunakan gadget (smartphone/laptop) untuk keperluan lain selain keperluan kegiatan belajar mengajar',
                'Mengerjakan tugas/test/quiz dengan baik',
                'Mengikuti instruksi dengan baik'
            ],
            'ATTITUDE' => [
                'Mengamati jalannya training dengan tenang',
                'Sopan selama proses training',
                'Tidak melanggar aturan atau instruksi yang berlaku saat training',
                'Bertanggung jawab selama mengikuti proses training',
                'Menjaga kebersihan dan kerapian perlengkapan, perlengkapan, dan ruang kelas'
            ]
        ];

        $currentRow = 10;
        foreach ($categories as $catName => $items) {
            $itemCount = count($items);
            $startItemRow = $currentRow + 1;
            $endItemRow = $currentRow + $itemCount;

            // Category Header Row (-1 column gap now)
            $headerRow = [$catName, '', ''];
            for ($i = 0; $i < $participantCount; $i++) {
                $colLetter = $this->getColumnLetter(4 + $i);
                $headerRow[] = '=IFERROR((COUNTIF(' . $colLetter . $startItemRow . ':' . $colLetter . $endItemRow . ', 1) / ' . $itemCount . ') * 4, 0)';
            }
            $data[] = $headerRow;

            // Item Rows
            foreach ($items as $index => $item) {
                $row = [$index + 1, $item, ''];
                for ($i = 0; $i < $participantCount; $i++) {
                    $row[] = ''; // Placeholder for input
                }
                $data[] = $row;
            }
            $currentRow += ($itemCount + 1);
        }

        return collect($data);
    }

    public function styles(Worksheet $sheet)
    {
        $participantCount = $this->training->participants->count();
        $displayCount = max(4, $participantCount);
        $lastColIndex = 3 + $displayCount; // Now 3 + X
        $lastColLetter = $this->getColumnLetter($lastColIndex);

        // Dynamic Signature Column positions
        $dikEndIdx = $lastColIndex;
        $dikStartIdx = $dikEndIdx - 1;
        $obsEndIdx = $dikStartIdx - 1;
        $obsStartIdx = $obsEndIdx - 1;

        $dikEnd = $this->getColumnLetter($dikEndIdx);
        $dikStart = $this->getColumnLetter($dikStartIdx);
        $obsEnd = $this->getColumnLetter($obsEndIdx);
        $obsStart = $this->getColumnLetter($obsStartIdx);

        // Title area
        $sheet->mergeCells('A1:' . $this->getColumnLetter($obsStartIdx - 1) . '1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells($obsStart . '2:' . $obsEnd . '3');
        $sheet->mergeCells($dikStart . '2:' . $dikEnd . '3');
        $sheet->mergeCells($obsStart . '4:' . $obsEnd . '4');
        $sheet->mergeCells($dikStart . '4:' . $dikEnd . '4');
        $sheet->mergeCells($obsStart . '5:' . $obsEnd . '5');
        $sheet->mergeCells($dikStart . '5:' . $dikEnd . '5');

        $sheet->getStyle($obsStart . '1:' . $dikEnd . '1')->getFont()->setBold(true);
        $sheet->getStyle($obsStart . '1:' . $dikEnd . '6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($obsStart . '4:' . $dikEnd . '5')->getFont()->setItalic(true)->setSize(9);

        // Borders for signature boxes
        $sheet->getStyle($obsStart . '1:' . $obsEnd . '5')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle($dikStart . '1:' . $dikEnd . '5')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Header merges for No and Item Observasi (B+C)
        $sheet->mergeCells('A7:A9');
        $sheet->mergeCells('B7:C9');
        $sheet->getStyle('A7:C9')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A7:C9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Header Checksheet merge (Starts at D)
        if ($participantCount > 0) {
            $sheet->mergeCells('D7:' . $lastColLetter . '7');
            $sheet->getStyle('D7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        // Bold info labels and merge AB for Labels (Rows 3-5)
        $sheet->getStyle('A3:A5')->getFont()->setBold(true);
        $sheet->mergeCells('A3:B3');
        $sheet->mergeCells('A4:B4');
        $sheet->mergeCells('A5:B5');

        $sheet->getStyle('A7:' . $lastColLetter . '9')->getFont()->setBold(true);

        // Borders for the whole table
        $lastRow = 36;
        $sheet->getStyle('A7:' . $lastColLetter . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Subco and Name alignment/rotation (Starts at D)
        $sheet->getStyle('D8:' . $lastColLetter . '8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D9:' . $lastColLetter . '9')->getAlignment()->setTextRotation(90)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Individual Subco labels and Alternating Column Colors for Participants (Row 8 to LastRow, Starts at D)
        for ($i = 0; $i < $participantCount; $i++) {
            $colLetter = $this->getColumnLetter(4 + $i);
            if ($i % 2 == 1) {
                $sheet->getStyle($colLetter . '8:' . $colLetter . $lastRow)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2CC');
            }
        }

        // Instruction Box Styling (Gray Box at Right)
        $instrStartCol = $this->getColumnLetter($lastColIndex + 2);
        $instrEndCol = $this->getColumnLetter($lastColIndex + 5);
        $sheet->getStyle($instrStartCol . '1:' . $instrEndCol . '5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('F2F2F2');
        $sheet->getStyle($instrStartCol . '1:' . $instrEndCol . '5')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle($instrStartCol . '1')->getFont()->setBold(true);
        $sheet->getStyle($instrStartCol . '1:' . $instrEndCol . '5')->getFont()->setSize(10);
        $sheet->getStyle($instrStartCol . '1:' . $instrEndCol . '5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Category Score Rows formatting and Item Row Merges
        $categories = [
            'PUNCTUALITY' => 5,
            'ACTIVENESS' => 7,
            'COOPERATION' => 6,
            'ATTITUDE' => 5
        ];

        $currentRow = 10;
        foreach ($categories as $catName => $itemCount) {
            // Category Header Row Merges (A:C)
            $sheet->mergeCells('A' . $currentRow . ':C' . $currentRow);
            $sheet->getStyle('A' . $currentRow . ':' . $lastColLetter . $currentRow)->getFont()->setBold(true);
            $sheet->getStyle('A' . $currentRow . ':' . $lastColLetter . $currentRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A' . $currentRow . ':' . $lastColLetter . $currentRow)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('F2F2F2');
            $sheet->getStyle('D' . $currentRow . ':' . $lastColLetter . $currentRow)->getNumberFormat()->setFormatCode('0.0');

            // Item Row Merges (B:C)
            for ($i = 1; $i <= $itemCount; $i++) {
                $itemRow = $currentRow + $i;
                $sheet->mergeCells('B' . $itemRow . ':C' . $itemRow);

                // Set Custom Toggles for Checksheet area (Columns D onwards)
                if ($participantCount > 0) {
                    $checkRange = 'D' . $itemRow . ':' . $lastColLetter . $itemRow;
                    $sheet->getStyle($checkRange)->getNumberFormat()->setFormatCode('[Color10][=1]"v";[Color3][=0]"x";;');
                    $sheet->getStyle($checkRange)->getFont()->setBold(true);
                }
            }

            $currentRow += ($itemCount + 1);
        }

        // Global Alignments
        $sheet->getStyle('A7:' . $lastColLetter . $lastRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('D10:' . $lastColLetter . $lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }

    public function columnWidths(): array
    {
        $widths = [
            'A' => 5,
            'B' => 50,
            'C' => 12, // Merged with B but needs width for Value colon area
        ];

        // Participant columns width (Starts at D)
        $participantCount = $this->training->participants->count();
        $displayCols = max(4, $participantCount);
        for ($i = 0; $i < $displayCols; $i++) {
            $colLetter = $this->getColumnLetter(4 + $i);
            $widths[$colLetter] = 12;
        }

        return $widths;
    }

    private function getColumnLetter($index)
    {
        return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index);
    }
}
