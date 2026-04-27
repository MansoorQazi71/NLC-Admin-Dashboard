<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaEvent extends Model
{
    /** @use HasFactory<\Database\Factories\AgendaEventFactory> */
    use HasFactory;

    protected $fillable = ['title', 'event_date', 'color', 'label'];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
        ];
    }
}
