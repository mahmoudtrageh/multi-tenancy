<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $connection = 'mysql';
    protected $table = 'packages';

    use HasFactory;
    protected $fillable = [
        'name',
        'annual_price',
        'monthly_price',
        'status',
        'type',
        'is_forever',
        'trial_period'
    ];

    public function features()
    {
        return $this->hasMany(Feature::class);
    }
}
