<?php

namespace App\Exports;

use App\Models\Training;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CsiTemplateExport implements FromCollection, WithHeadings
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
        $rows = [];
        foreach ($this->training->participants as $participant) {
            $rows[] = [
                'ID' => '',
                'Start time' => '',
                'Completion time' => '',
                'Email' => '',
                'Name' => $participant->name,
                'Last modified time' => '',
                'Subject Training' => '',
                'Nama Training Managerial' => '',
                'Nama Training Teknikal' => '',
                'Nama Training Refreshment' => '',
                'Batch' => '',
                'Relevansi' => '',
                'Manfaat' => '',
                'Kesiapan' => '',
                'Sistematika' => '',
                'Saran Subject' => '',
                'Tempat' => '',
                'Fasilitas' => '',
                'Konsumsi' => '',
                'Suasana' => '',
                'Pengendalian Waktu' => '',
                'Saran Operasional' => '',
                'Subject Training2' => '',
                'Nama Trainer Managerial' => '',
                'Nama Trainer Teknikal' => '',
                'Sikap' => '',
                'Penguasaan Materi' => '',
                'Penyajian Materi' => '',
                'Antusiasme' => '',
                'Pengendalian Waktu2' => '',
                'Penguasaan Kelas' => '',
                'Penampilan' => '',
                'Kemampuan Penyimpulan' => '',
                'Kesan Trainer' => '',
                'Usulan Trainer' => '',
                'Apakah Trainer Lebih Dari 1 ?' => 'Tidak',
                'Subject Training3' => '',
                'Nama Trainer Managerial2' => '',
                'Nama Trainer Teknikal2' => '',
                'Sikap2' => '',
                'Penguasaan Materi2' => '',
                'Penyajian Materi2' => '',
                'Antusiasme2' => '',
                'Pengendalian Waktu3' => '',
                'Penguasaan Kelas2' => '',
                'Penampilan2' => '',
                'Kemampuan Penyimpulan2' => '',
                'Kesan Trainer2' => '',
                'Usulan Trainer2' => '',
                'Total Score' => '',
            ];
        }

        return collect($rows);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Start time',
            'Completion time',
            'Email',
            'Name',
            'Last modified time',
            'Subject Training',
            'Nama Training Managerial',
            'Nama Training Teknikal',
            'Nama Training Refreshment',
            'Batch',
            'Relevansi materi terhadap tujuan pelatihan',
            'Manfaat penjelasan materi',
            'Kesiapan penyampaian materi',
            'Sistematika penyampaian materi',
            'Saran anda terkait subject training',
            'Tempat Pelaksanaan pelatihan',
            'Fasilitas Mengajar',
            'Konsumsi',
            'Suasana',
            'Pengendalian Waktu',
            'Saran anda terkait operasional pelaksanaan training',
            'Subject Training2',
            'Nama Trainer Managerial',
            'Nama Trainer Teknikal',
            'Sikap / perilaku',
            'Penguasaan Materi',
            'Penyajian Materi',
            'Antusiasme & suara',
            'Pengendalian waktu2',
            'Penguasaan kelas',
            'Penampilan Instruktur',
            'Kemampuan Penyimpulan',
            'Sebutkan 2 hal tentang trainer yang paling berkesan bagi anda?',
            'Apa usulan anda tentang trainer',
            'Apakah Trainer Lebih Dari 1 ?',
            'Subject Training3',
            'Nama Trainer Managerial2',
            'Nama Trainer Teknikal2',
            'Sikap / perilaku2',
            'Penguasaan Materi2',
            'Penyajian Materi2',
            'Antusiasme & suara2',
            'Pengendalian waktu3',
            'Penguasaan kelas2',
            'Penampilan Instruktur2',
            'Kemampuan Penyimpulan2',
            'Sebutkan 2 hal tentang trainer yang paling berkesan bagi anda?2',
            'Apa usulan anda tentang trainer2',
            'Secara keseluruhan bagaimanakah program training yang kami sajikan?',
        ];
    }
}
