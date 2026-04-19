<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSummary extends Model
{
    /** @use HasFactory<\Database\Factories\TrainingSummaryFactory> */
    protected $fillable = [
        'training_id',
        'barcode_path',
        'prepared_barcode_path',
        'checked_barcode_path',
        'presence_summary',
        'pass_statement',
        'average_score',
        'presence_ratio',
        'comment',
        'prepared_by',
        'prepared_title',
        'prepared_header',
        'checked_by',
        'checked_title',
        'checked_header',
        'confirmed_by',
        'confirmed_title',
        'confirmed_header',
        'additional_field_1',
        'additional_field_2',
        'recommendation',
        'feedback_summary',
        'trainer_feedbacks',
        'trainer_impressions',
    ];

    protected $casts = [
        'trainer_feedbacks' => 'array',
        'trainer_impressions' => 'array',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class);
    }
}
