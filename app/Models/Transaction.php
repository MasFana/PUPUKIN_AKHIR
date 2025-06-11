<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'customer_id',
        'owner_id',
        'fertilizer_id',
        'quantity_kg',
        'total_price',
        'status',
        'completed_at'
    ];

    public function customer()
    {
        return $this->belongsTo( Customer::class, 'customer_id');
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    public function fertilizer()
    {
        return $this->belongsTo(Fertilizer::class, 'fertilizer_id');
    }

    public function getFormatedTotalPriceAttribute()
    {
        return number_format($this->attributes['total_price'], 0, ',', '.');
    }

}
