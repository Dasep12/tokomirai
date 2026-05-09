<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $fillable = [
        'google_id',
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'provider',
        'provider_token',
        'status',
        'is_admin',
        'last_login_at',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'provider_token'
    ];
}
