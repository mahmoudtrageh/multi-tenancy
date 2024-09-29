<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $connection = 'mysql';
    protected $table = 'subscriptions';

    use HasFactory;
    protected $fillable = [
        'tenant_id',
        'package_id',
        'payment_method',
        'payment_status',
        'start_date',
        'end_date',
        'total',
        'coupon',
        'discount',
        'data',
        'user_id',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
