<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class SubSubCategory extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
        'sub_category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
