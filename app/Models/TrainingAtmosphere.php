<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingAtmosphere extends Model
{
    protected $fillable = [
        'training_id',
        'image_path',
        'title',
        'subtitle',
        'description',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class);
    }
}
