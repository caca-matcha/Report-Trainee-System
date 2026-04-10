<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\TrainingEvaluation;
use App\Exports\CsiTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class TrainingEvaluationController extends Controller
{
    public function exportTemplate(Training $training)
    {
        $filename = 'CSI_Template_' . str_replace(' ', '_', $training->title) . '.csv';
        return Excel::download(new CsiTemplateExport($training), $filename, \Maatwebsite\Excel\Excel::CSV);
    }

    public function import(Request $request, Training $training)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls,csv,txt',
            ]);

            $file = $request->file('file');
            $dataArray = Excel::toArray(new \App\Imports\CsiImport, $file);

            if (empty($dataArray) || empty($dataArray[0])) {
                return back()->with('error', 'File kosong atau tidak valid.');
            }

            $rows = $dataArray[0];
            array_shift($rows); // Remove header

            $data = $this->processCsiRows($rows);

            $training->evaluation()->updateOrCreate(
                ['training_id' => $training->id],
                ['data' => $data]
            );

            return back()->with('success', 'Data CSI berhasil diimport.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('CSI Import Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    public function syncFromGoogleSheets(Request $request, Training $training)
    {
        try {
            $request->validate([
                'google_sheets_url' => 'required|url',
            ]);

            $url = $request->google_sheets_url;
            
            // Ensure it's a CSV export link if it's a standard google sheets link
            if (str_contains($url, 'docs.google.com/spreadsheets') && !str_contains($url, 'output=csv')) {
                // Try to convert to export link if it's just a sharing link
                if (preg_match('/\/d\/(.*?)(\/|$)/', $url, $matches)) {
                    $url = "https://docs.google.com/spreadsheets/d/{$matches[1]}/export?format=csv";
                }
            }

            $response = \Illuminate\Support\Facades\Http::get($url);
            
            if (!$response->successful()) {
                return response()->json(['success' => false, 'message' => 'Gagal mengambil data dari Google Sheets. Pastikan link sudah di-"Publish to the Web" sebagai CSV.'], 400);
            }

            $csvData = $response->body();
            $rows = array_map('str_getcsv', explode("\n", trim($csvData)));
            array_shift($rows); // Remove header

            $data = $this->processCsiRows($rows);

            $training->evaluation()->updateOrCreate(
                ['training_id' => $training->id],
                [
                    'data' => $data,
                    'google_sheets_url' => $request->google_sheets_url
                ]
            );

            return response()->json(['success' => true, 'message' => 'Data CSI berhasil disinkronisasi dari Google Sheets.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    private function processCsiRows($rows)
    {
        $subjectScores = [];
        $operationalScores = [];
        $voiceOperational = [];
        $voiceSubjectSuggestion = [];

        $trainer1Scores = [];
        $trainer1Feedback = [];
        $trainer1Impressions = [];
        $trainer1NameFromCsv = null;

        $trainer2Scores = [];
        $trainer2Feedback = [];
        $trainer2Impressions = [];
        $trainer2NameFromCsv = null;
        $hasTrainer2 = false;

        foreach ($rows as $row) {
            if (count($row) < 34) continue;

            for ($i = 11; $i <= 14; $i++) {
                if (isset($row[$i]) && is_numeric($row[$i])) {
                    $subjectScores[$i][] = (float) $row[$i];
                }
            }

            for ($i = 16; $i <= 20; $i++) {
                if (isset($row[$i]) && is_numeric($row[$i])) {
                    $operationalScores[$i][] = (float) $row[$i];
                }
            }

            for ($i = 25; $i <= 32; $i++) {
                if (isset($row[$i]) && is_numeric($row[$i])) {
                    $trainer1Scores[$i][] = (float) $row[$i];
                }
            }

            if (!empty($row[15])) $voiceSubjectSuggestion[] = $row[15];
            if (!empty($row[21])) $voiceOperational[] = $row[21];
            if (!empty($row[33])) $trainer1Impressions[] = $row[33];
            if (!empty($row[34])) $trainer1Feedback[] = $row[34];

            if (!empty($row[23])) $trainer1NameFromCsv = $row[23];
            elseif (!empty($row[24])) $trainer1NameFromCsv = $row[24];

            if ((isset($row[35]) && stripos(trim($row[35]), 'ya') !== false) || !empty($row[37]) || !empty($row[38])) {
                $hasTrainer2 = true;
                if (!empty($row[37])) $trainer2NameFromCsv = $row[37];
                elseif (!empty($row[38])) $trainer2NameFromCsv = $row[38];

                for ($i = 39; $i <= 46; $i++) {
                    if (isset($row[$i]) && is_numeric($row[$i])) {
                        $mappedIndex = 25 + ($i - 39);
                        $trainer2Scores[$mappedIndex][] = (float) $row[$i];
                    }
                }

                if (isset($row[47]) && !empty($row[47])) $trainer2Impressions[] = $row[47];
                if (isset($row[48]) && !empty($row[48])) $trainer2Feedback[] = $row[48];
            }
        }

        $calculateAvg = function ($scores) {
            $results = [];
            foreach ($scores as $index => $values) {
                if (count($values) > 0) {
                    $results[$index] = round(array_sum($values) / count($values), 2);
                }
            }
            return $results;
        };

        $buildTrainer = function ($scores, $impressions, $feedback, $nameFromCsv) use ($calculateAvg) {
            $name = $nameFromCsv ?? 'Unknown Trainer';
            $user = \App\Models\User::where('name', 'like', '%' . $name . '%')->first();
            return [
                'name' => $user ? $user->name : $name,
                'photo' => $user ? $user->photo : null,
                'scores' => $calculateAvg($scores),
                'impressions' => array_slice($impressions, 0, 10),
                'feedback' => array_slice($feedback, 0, 10),
            ];
        };

        $trainers = [];
        $trainers[] = $buildTrainer($trainer1Scores, $trainer1Impressions, $trainer1Feedback, $trainer1NameFromCsv ?? 'Luthfi Dhimas W.');
        if ($hasTrainer2) {
            $trainers[] = $buildTrainer($trainer2Scores, $trainer2Impressions, $trainer2Feedback, $trainer2NameFromCsv ?? 'Trainer 2');
        }

        return [
            'subject' => $calculateAvg($subjectScores),
            'operational' => $calculateAvg($operationalScores),
            'qualitative' => [
                'voice_operational' => array_slice($voiceOperational, 0, 10),
                'voice_subject' => array_slice(array_merge($voiceSubjectSuggestion, $trainer1Feedback, $trainer2Feedback), 0, 10),
            ],
            'trainer' => $trainers[0]['scores'],
            'trainer_name' => $trainers[0]['name'],
            'trainer_photo' => $trainers[0]['photo'],
            'trainers' => $trainers
        ];
    }
    public function importJson(Request $request, Training $training)
    {
        try {
            $request->validate([
                'json_data' => 'required|string',
            ]);

            $data = json_decode($request->json_data, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json(['success' => false, 'message' => 'Format JSON tidak valid.'], 400);
            }

            // Ensure we have the required structure or a simplified one
            // If it's the simplified data, we might need to wrap it
            if (!isset($data['trainers']) && isset($data['trainer'])) {
                 // Convert legacy/simple format to new format if needed
            }

            $training->evaluation()->updateOrCreate(
                ['training_id' => $training->id],
                ['data' => $data]
            );

            return response()->json(['success' => true, 'message' => 'Data CSI berhasil diupdate dari Barcode/QR.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function manualInput(Request $request, Training $training)
    {
        try {
            // Check existing Evaluation data
            $evalData = $training->evaluation->data ?? [];

            // Get trainers from request
            $trainersInput = $request->input('trainers', []);
            $processedTrainers = [];

            foreach ($trainersInput as $index => $trainerData) {
                // Ensure scores are properly mapped and cast to float
                $scores = [];
                if (isset($trainerData['scores']) && is_array($trainerData['scores'])) {
                    foreach ($trainerData['scores'] as $key => $val) {
                        $scores[$key] = floatval($val);
                    }
                }

                $impressions = [];
                if (isset($trainerData['impressions'])) {
                    $impArray = is_string($trainerData['impressions']) ? json_decode($trainerData['impressions'], true) : $trainerData['impressions'];
                    if (is_array($impArray)) {
                        $impressions = array_filter(array_map('trim', $impArray));
                    }
                }

                $feedback = [];
                if (isset($trainerData['feedback'])) {
                    $fbArray = is_string($trainerData['feedback']) ? json_decode($trainerData['feedback'], true) : $trainerData['feedback'];
                    if (is_array($fbArray)) {
                        $feedback = array_filter(array_map('trim', $fbArray));
                    }
                }

                $processedTrainers[] = [
                    'name' => $trainerData['name'] ?? 'Trainer ' . ($index + 1),
                    'photo' => $trainerData['photo'] ?? null,
                    'scores' => $scores,
                    'impressions' => array_values($impressions),
                    'feedback' => array_values($feedback),
                ];
            }

            if (empty($processedTrainers)) {
                return back()->with('error', 'Tidak ada data trainer yang diinputkan.');
            }

            // Merge with existing data
            $evalData['trainers'] = $processedTrainers;
            
            // Calculate auto average for trainer
            $avgScores = [];
            for ($i = 25; $i <= 32; $i++) {
                $sum = 0;
                $count = 0;
                foreach ($processedTrainers as $pt) {
                    if (isset($pt['scores'][$i])) {
                        $sum += $pt['scores'][$i];
                        $count++;
                    }
                }
                $avgScores[$i] = $count > 0 ? round($sum / $count, 2) : 0;
            }

            $evalData['trainer'] = $avgScores;
            $evalData['trainer_name'] = $processedTrainers[0]['name'] . (count($processedTrainers) > 1 ? ' & Tim' : '');
            $evalData['trainer_photo'] = $processedTrainers[0]['photo'];

            // Process Subject and Operational
            $subjectInput = $request->input('subject', []);
            $operationalInput = $request->input('operational', []);
            
            if (!empty($subjectInput) && is_array($subjectInput)) {
                $evalData['subject'] = array_map('floatval', $subjectInput);
            }
            if (!empty($operationalInput) && is_array($operationalInput)) {
                $evalData['operational'] = array_map('floatval', $operationalInput);
            }

            // Process Qualitative (voice_subject & voice_operational)
            $voiceSubject = $request->input('voice_subject', []);
            if (is_string($voiceSubject)) {
                $voiceSubject = json_decode($voiceSubject, true) ?? [];
            }
            $voiceSubject = array_filter(array_map('trim', (array)$voiceSubject));

            $voiceOperational = $request->input('voice_operational', []);
            if (is_string($voiceOperational)) {
                $voiceOperational = json_decode($voiceOperational, true) ?? [];
            }
            $voiceOperational = array_filter(array_map('trim', (array)$voiceOperational));

            if (!isset($evalData['qualitative'])) {
                $evalData['qualitative'] = [];
            }
            $evalData['qualitative']['voice_subject'] = array_values($voiceSubject);
            $evalData['qualitative']['voice_operational'] = array_values($voiceOperational);

            $training->evaluation()->updateOrCreate(
                ['training_id' => $training->id],
                ['data' => $evalData]
            );

            return back()->with('success', 'Data CSI berhasil disimpan secara manual.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Manual CSI Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
}