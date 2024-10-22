<?php

namespace App\Http\Controllers\Api\Tenant\Front;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getProducts()
    {
        return Product::with(relations: ['category', 'sub_category', 'sub_sub_category', 'brand', 'variants'])->get();
    }

    public function getCategories()
    {
        return Category::with(relations: ['sub_category', 'sub_sub_category', 'products'])->get();
    }

    public function getBrands()
    {
        return Brand::with(relations: ['products'])->get();
    }
}
