<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // use HasFactory;
    protected $table = 'mst_product';
    public $timestamps = false; // Karena tabel aslimu tidak punya created_at/updated_at

    protected $fillable = [
        'name',
        'spesification',
        'description',
        'price',
        'discount',
        'category',
        'images',
        'badge',
        'rating',
        'sold'
    ];

    // Otomatis ubah JSON di DB menjadi Array di Laravel
    protected $casts = [
        'spesification' => 'array',
        'price' => 'decimal:0',
        'discount' => 'decimal:0',
    ];

    public function gallery()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
