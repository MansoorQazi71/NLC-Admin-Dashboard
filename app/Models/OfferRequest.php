<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfferRequest extends Model
{
    /** @use HasFactory<\Database\Factories\OfferRequestFactory> */
    use HasFactory;

    protected $fillable = ['client_id', 'title', 'status', 'description'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
