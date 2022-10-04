<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    protected $guard = 'customer';

    protected $dates = ['deleted_at'];
    protected $table = "customers";

	protected $fillable = [
        'profile_image',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'password',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'country',
        'zipcode',
        'status',
    ];

	protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['customer_profile_image_path'];

    public function getCustomerProfileImagePathAttribute($value)
    {
        return url('customerprofile') . '/' . $this->profile_image;
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'id_customer', 'id');
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'id_customer', 'id');
    }

    public function paymentdetail()
    {
        return $this->hasMany(Paymentdetail::class, 'id_customer', 'id');
    }
}
