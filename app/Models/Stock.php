<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';

    protected $fillable = [
        'owner_id',
        'fertilizer_id',
        'quantity_kg',
    ];  

    public function fertilizer()
    {
        return $this->belongsTo(Fertilizer::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function getFormattedQuantityKgAttribute()
    {
        return number_format($this->attributes['quantity_kg'], 0, ',', '.');
    }
}
