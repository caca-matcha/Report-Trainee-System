<?php

namespace App\Imports;

use App\Models\TrainingParticipant;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ObservationImport implements ToCollection
{
    protected $trainingId;

    public function __construct($trainingId)
    {
        $this->trainingId = $trainingId;
    }

    public function collection(Collection $rows)
    {
        // Row 8 (index 7) has NPKs
        // Row 9 (index 8) has Names
        $npks = $rows->get(7);
        $names = $rows->get(8);

        if (!$npks)
            return;

        // Map column index to Name (since NPK was replaced by Subco in the template)
        $participantCols = [];
        foreach ($names as $colIndex => $name) {
            if ($colIndex < 3)
                continue; // Skip A, B, C (labels)
            if (empty($name))
                continue;

            $participantCols[$colIndex] = $name;
        }

        foreach ($participantCols as $colIndex => $name) {
            $participant = TrainingParticipant::where('training_id', $this->trainingId)
                ->where('name', $name)
                ->first();

            if (!$participant)
                continue;

            // Punctuality: Rows 11-15 (indices 10-14)
            $pScore = $this->calculateScore($rows, $colIndex, 10, 14);

            // Activeness: Rows 17-23 (indices 16-22)
            $aScore = $this->calculateScore($rows, $colIndex, 16, 22);

            // Cooperation: Rows 25-30 (indices 24-29)
            $cScore = $this->calculateScore($rows, $colIndex, 24, 29);

            // Attitude: Rows 32-36 (indices 31-35)
            $tScore = $this->calculateScore($rows, $colIndex, 31, 35);

            $participant->update([
                'punctuality_score' => $pScore,
                'activeness_score' => $aScore,
                'cooperation_score' => $cScore,
                'attitude_score' => $tScore,
            ]);
        }
    }

    private function calculateScore($rows, $colIndex, $startIdx, $endIdx)
    {
        $sum = 0;
        $count = ($endIdx - $startIdx) + 1;

        for ($i = $startIdx; $i <= $endIdx; $i++) {
            $val = $rows->get($i)[$colIndex] ?? 0;
            // Treat '1', 'v', 'x' or any non-empty as positive if you want, 
            // but user said "jumlah nilai 1"
            if ($val == 1 || strtolower($val) == 'v' || strtolower($val) == '1') {
                $sum++;
            }
        }

        return round(($sum / $count) * 4, 1);
    }
}
