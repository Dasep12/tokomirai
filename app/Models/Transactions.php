<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    // use HasFactory;
    protected $table = 'transactions';

    protected $fillable = [
        'user_id',
        'invoice',
        'name',
        'phone',
        'email',
        'address',
        'province',
        'city',
        'district',
        'postal_code',
        'total',
        'tax',
        'grand_total',
        'created_at',
        'status',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
    ];
    public function details()
    {
        return $this->hasMany(DetailTransactions::class, 'transaction_id');
    }
}
