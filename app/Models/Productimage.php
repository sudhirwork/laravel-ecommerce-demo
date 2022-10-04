<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productimage extends Model
{
    use HasFactory;

    protected $table = "productimages";

	protected $fillable = [
        'id_project',
        'image',
        'is_deleted',
        'status',
    ];

	protected $hidden = [];

    protected $appends = ['product_image_path'];

    public function getProductImagePathAttribute($value)
    {
        return url('productimages') . '/' . $this->image;
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_project', 'id');
    }
}
