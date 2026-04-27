<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MissionStatusHistory extends Model
{
    /** @use HasFactory<\Database\Factories\MissionStatusHistoryFactory> */
    use HasFactory;

    protected $fillable = ['mission_id', 'changed_by', 'old_status', 'new_status'];

    public function mission(): BelongsTo
    {
        return $this->belongsTo(Mission::class);
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
