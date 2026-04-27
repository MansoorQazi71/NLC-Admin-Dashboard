<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientFiliation extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFiliationFactory> */
    use HasFactory;

    protected $fillable = ['client_id', 'related_client_id', 'relation_type', 'label'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function relatedClient(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'related_client_id');
    }
}
