<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'price'
    ];
    public function vendors()
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }
}
