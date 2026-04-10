<?php

namespace App\Imports;

use App\Models\TrainingParticipant;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TrainingImport implements ToModel, WithHeadingRow
{
    protected $trainingId;

    public function __construct($trainingId)
    {
        $this->trainingId = $trainingId;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Slugified keys from headings: e.g., 'BAGIAN' becomes 'bagian', 'PRE' becomes 'pre'
        $npk = $row['npk'] ?? null;
        $name = $row['nama'] ?? ($row['name'] ?? null);

        if (!$npk || !$name) {
            return null;
        }

        // Auto-fetch user_id by NPK from master data if possible
        $user = User::where('npk', (string)$npk)->first();

        // Use updateOrCreate to allow updating existing participant scores via import
        return TrainingParticipant::updateOrCreate(
            [
                'training_id' => $this->trainingId,
                'npk' => (string)$npk,
            ],
            [
                'user_id' => $user ? $user->id : null,
                'name' => $name,
                'department' => $row['bagian'] ?? ($row['department'] ?? ($row['division'] ?? null)),
                'subco' => $row['subco'] ?? null,
                'pre_test_score' => $row['pre'] ?? ($row['pre_test'] ?? null),
                'post_test_score' => $row['post'] ?? ($row['post_test'] ?? null),
                'punctuality_score' => $row['punctuality'] ?? null,
                'activeness_score' => $row['activeness'] ?? null,
                'cooperation_score' => $row['cooperation'] ?? null,
                'attitude_score' => $row['attitude'] ?? null,
                'is_present' => true,
            ]
        );
    }
}
