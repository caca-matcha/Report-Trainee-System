<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingEvaluation extends Model
{
    protected $fillable = [
        'training_id',
        'google_sheets_url',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class);
    }
}
