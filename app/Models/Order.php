<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";

	protected $fillable = [
        'id_customer',
        'id_product',
        'order_no',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'country',
        'zipcode',
        'name',
        'brand',
        'code',
        'price',
        'quantity',
        'subtotal',
        'track_status',
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

    public function paymentdetail()
    {
        return $this->hasMany(Paymentdetail::class, 'id_order', 'id');
    }
}
