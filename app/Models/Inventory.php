<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';

    protected $fillable = [
        'item_name',
        'unit',
        'quantity',
        'minimum_stock_level',
    ];

    public function getStatusAttribute()
    {
        return $this->quantity <= $this->minimum_stock_level ? 'Low Stock' : 'Available';
    }
}
