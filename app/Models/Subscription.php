<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'type',
        'is_verified',
        'verification_token',
        'verified_at',
        'unsubscribed_at',
    ];
}
