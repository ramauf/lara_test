<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'client_email',
        'partner_id',
        'status'
    ];
    public function partners()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products', 'order_id', 'product_id')
            ->withPivot(['quantity', 'price']);
    }
}
