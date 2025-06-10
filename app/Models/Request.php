<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';

    protected $fillable = [
        'owner_id',
        'fertilizer_id',
        'quantity_kg',
        'status',
        'admin_notes',
        'processed_at'
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    public function fertilizer()
    {
        return $this->belongsTo(Fertilizer::class, 'fertilizer_id');
    }

    public function getQuantityKgAttribute($value)
    {
        return number_format($value, 0, ',', '.');
    }
}
