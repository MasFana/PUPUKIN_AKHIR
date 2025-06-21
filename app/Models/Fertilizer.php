<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fertilizer extends Model
{
    protected $table = 'fertilizers';

    protected $fillable = [
        'name',
        'subsidized',
        'price_per_kg',
    ];


    public function stockRequests()
    {
        return $this->hasMany(StockRequest::class);
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }


    public function getFormattedPricePerKgAttribute($value)
    {
        return number_format($value, 0, ',', '.');
    }

}
