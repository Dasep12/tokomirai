<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'mst_settings';

    protected $fillable = [
        'key',
        'values',
        'images',
        'remarks',
        'created_by',
        'updated_by'
    ];
}
