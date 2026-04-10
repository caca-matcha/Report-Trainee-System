<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingApproval extends Model
{
    /** @use HasFactory<\Database\Factories\TrainingApprovalFactory> */
    protected $fillable = [
        'training_id',
        'user_id',
        'level',
        'status',
        'note',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
