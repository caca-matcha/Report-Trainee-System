<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingParticipant extends Model
{
    /** @use HasFactory<\Database\Factories\TrainingParticipantFactory> */
    protected $fillable = [
        'training_id',
        'user_id',
        'name',
        'npk',
        'department',
        'subco',
        'photo_path',
        'pre_test_score',
        'pre_test_target',
        'post_test_score',
        'post_test_target',
        'punctuality_score',
        'punctuality_target',
        'activeness_score',
        'activeness_target',
        'cooperation_score',
        'cooperation_target',
        'attitude_score',
        'attitude_target',
        'observation_score',
        'negotiation_score',
        'is_present',
        'signature_path',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
