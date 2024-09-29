<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $connection = 'mysql';
    protected $table = 'payment_methods';

    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'api_key',
        'api_secret',
        'merchant_id',
        'status',
        'type',
        'user_name',
    ];
}
