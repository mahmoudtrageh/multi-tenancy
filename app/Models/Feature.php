<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'package_id',
        'status'
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
