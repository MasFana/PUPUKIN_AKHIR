<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quota extends Model
{
    protected $table = 'quotas';

    protected $fillable = [
        'customer_id',
        'fertilizer_id',
        'max_kg_per_month',
        'remaining_kg'
    ];

    public function fertilizer()
    {
        return $this->belongsTo(Fertilizer::class, 'fertilizer_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }


}
