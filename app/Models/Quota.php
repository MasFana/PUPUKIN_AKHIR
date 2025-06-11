<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quota extends Model
{
    protected $table = 'quotas';

    protected $fillable = [
        'customer_id',
        'max_kg_per_month',
        'remaining_kg'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }


}
