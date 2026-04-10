<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    /** @use HasFactory<\Database\Factories\TrainingFactory> */
    protected $fillable = [
        'user_id',
        'master_training_id',
        'title',
        'training_topic',
        'description',
        'organizer',
        'start_date',
        'end_date',
        'training_type',
        'passing_grade',
        'status',
        'trainers',
        'pics',
    ];

    protected $casts = [
        'trainers' => 'array',
        'pics' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function masterTraining()
    {
        return $this->belongsTo(MasterTraining::class, 'master_training_id');
    }

    public function participants()
    {
        return $this->hasMany(TrainingParticipant::class);
    }

    public function approvals()
    {
        return $this->hasMany(TrainingApproval::class);
    }

    public function summary()
    {
        return $this->hasOne(TrainingSummary::class);
    }

    public function evaluation()
    {
        return $this->hasOne(TrainingEvaluation::class);
    }

    public function atmospheres()
    {
        return $this->hasMany(TrainingAtmosphere::class);
    }
}
