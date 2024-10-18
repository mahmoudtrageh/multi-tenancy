<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'unit_price',
        'category_id',
        'brand_id',
        'sub_category_id',
        'sub_sub_category_id',
        'current_stock',
        'product_type',
        'featured',
        'flash_deal',
        'published',
        'purchase_price',
        'tax',
        'tax_type',
        'discount',
        'discount_type',
        'status',
        'meta_title',
        'meta_description',
        'most_selling',
        'code',
        'views',
        'review_count',
        'latest_products',
        'new_arrivals',
        'currency',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function sub_sub_category()
    {
        return $this->belongsTo(SubSubCategory::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
