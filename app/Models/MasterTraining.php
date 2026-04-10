<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class MasterTraining extends Model
{
    use HasFactory;

    protected $table = 'master_trainings';

    protected $fillable = [
        'event_no',
        'category',
        'training_course',
        'training_topic',
        'provider_type',
        'provider',
        'trainer_name',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'passing_grade',
        'status',
        'description',
        'participants',
        'trainers',
        'pics',
        'training_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'participants' => 'array',
        'trainers' => 'array',
        'pics' => 'array',
    ];

    /**
     * Generate event number otomatis berdasarkan kategori
     */
    public static function generateNextEventNo(string $category): string
    {
        $acronyms = [
            'Mandatory' => 'MDT',
            'Managerial' => 'MNG',
            'Technical' => 'TKT',
            'Awareness' => 'ARS',
            'Certification' => 'CER',
            'Others' => 'OT'
        ];

        $prefix = $acronyms[$category] ?? 'TRN';

        if ($category === 'Others') {
            // Logic: OT[Index]_02[Sequence]
            // Misal: OT1_02999 -> OT2_02001
            $last = static::where('category', 'Others')
                ->where('event_no', 'like', 'OT%_02%')
                ->orderByDesc('event_no')
                ->first();

            if (!$last) {
                return "OT1_02001";
            }

            // Parse: OT{index}_02{seq}
            if (preg_match('/OT(\d+)_02(\d+)/', $last->event_no, $matches)) {
                $index = (int)$matches[1];
                $seq = (int)$matches[2];

                if ($seq >= 999) {
                    $index++;
                    $seq = 1;
                } else {
                    $seq++;
                }

                return "OT{$index}_02" . str_pad($seq, 3, '0', STR_PAD_LEFT);
            }

            return "OT1_02001";
        } else {
            // Logic: [ACRONYM]_01[Sequence]
            // Misal: MDT_01001
            $fullPrefix = $prefix . '_01';
            $last = static::where('category', $category)
                ->where('event_no', 'like', $fullPrefix . '%')
                ->orderByDesc('event_no')
                ->first();

            if (!$last) {
                return $fullPrefix . "001";
            }

            $lastSeq = (int) substr($last->event_no, -3);
            $nextSeq = $lastSeq + 1;

            return $fullPrefix . str_pad($nextSeq, 3, '0', STR_PAD_LEFT);
        }
    }

    public function trainings()
    {
        return $this->hasMany(Training::class, 'master_training_id');
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'Selesai' => 'bg-purple-100 text-purple-700',
            'Sedang Berlangsung' => 'bg-blue-100 text-blue-700',
            'Open Registration' => 'bg-green-100 text-green-700',
            'Dibatalkan' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }
}
