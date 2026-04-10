<?php

namespace App\Exports;

use App\Models\Training;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ParticipantTemplateExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $training;

    public function __construct(Training $training)
    {
        $this->training = $training;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Get all participants currently in the training
        return $this->training->participants()->orderBy('name')->get();
    }

    public function map($participant): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $participant->npk,
            $participant->name,
            $participant->department,
            $participant->subco,
            $participant->pre_test_score,
            $participant->post_test_score,
            $participant->punctuality_score,
            $participant->activeness_score,
            $participant->cooperation_score,
            $participant->attitude_score,
        ];
    }

    public function headings(): array
    {
        return [
            'NO',
            'NPK',
            'NAMA',
            'BAGIAN', // Previously department
            'SUBCO',
            'PRE',    // Previously pre_test
            'POST',   // Previously post_test
            'PUNCTUALITY',
            'ACTIVENESS',
            'COOPERATION',
            'ATTITUDE',
        ];
    }
}
