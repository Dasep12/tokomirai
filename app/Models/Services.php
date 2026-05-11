<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;
    protected $table = 'mst_services';
    protected $fillable = [
        'icon',
        'name',
        'description',
        'price',
        'is_active',
    ];

    // Otomatis ubah JSON di DB menjadi Array di Laravel
    protected $casts = [
        'price' => 'decimal:0',
        'is_active' => 'boolean',
    ];
}
