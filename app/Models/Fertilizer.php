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


    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function quota()
    {
        return $this->hasMany(Quota::class);
    }

    public function request()
    {
        return $this->hasMany(Request::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    public function getPricePerKgAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }
}
