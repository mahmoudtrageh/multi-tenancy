<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Setting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $table = 'settings';

    protected $fillable = [
        'name', 'val', 'group', 'created_at', 'updated_at'
    ];

}
