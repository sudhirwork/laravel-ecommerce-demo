<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = "carts";

	protected $fillable = [
        'id_customer',
        'id_product',
        'name',
        'brand',
        'code',
        'price',
        'quantity',
        'subtotal',
        'is_deleted',
        'status',
    ];

	protected $hidden = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id');
    }
}
