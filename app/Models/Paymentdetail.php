<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymentdetail extends Model
{
    use HasFactory;

    protected $table = "paymentdetails";

	protected $fillable = [
        'id_customer',
        'id_order',
        'ref_no',
        'payment_method',
        'total',
        'payment_status',
        'is_deleted',
    ];

	protected $hidden = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id');
    }
}
