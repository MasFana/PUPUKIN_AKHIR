<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quota extends Model
{
    protected $table = 'quotas';

    protected $fillable = [
        'customer_id',
        'fertilizer_id',
        'quantity_kg',
        'year',
    ];

    public function fertilizer()
    {
        return $this->belongsTo(Fertilizer::class, 'fertilizer_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function getQuantityKgAttribute($value)
    {
        return number_format($value, 0, ',', '.');
    }
}
