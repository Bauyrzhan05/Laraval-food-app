<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Food extends Model
{
    protected $table = 'foods';

    protected $fillable = [
        'title',
        'description',
        'price',
        'quantity',
        'image',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
