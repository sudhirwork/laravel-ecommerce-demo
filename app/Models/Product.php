<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

	protected $fillable = [
        'id_category',
        'thumbnail',
        'brand',
        'code',
        'name',
        'description',
        'price',
        'stock_quantity',
        'is_deleted',
        'status',
    ];

	protected $hidden = [];

    protected $appends = ['product_thumbnail_path'];

    public function getProductThumbnailPathAttribute($value)
    {
        return url('productthumbnail') . '/' . $this->thumbnail;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id');
    }

    public function productimage()
    {
        return $this->hasMany(Productimage::class, 'id_project', 'id');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'id_product', 'id');
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'id_product', 'id');
    }
}
