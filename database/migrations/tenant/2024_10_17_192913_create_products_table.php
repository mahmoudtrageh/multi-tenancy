<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('unit_price', 10, 2);
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_sub_category_id')->constrained()->onDelete('cascade');
            $table->integer('current_stock')->nullable();
            $table->string('slug');
            $table->string('product_type')->nullable();
            $table->boolean('featured')->default(0);
            $table->boolean('flash_deal')->default(0);
            $table->boolean('published')->default(1);
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->decimal('tax', 10, 2)->nullable();
            $table->string('tax_type')->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->string('discount_type')->nullable();
            $table->boolean(column: 'status')->default(1);
            $table->string(column: 'meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->boolean('most_selling')->default(0);
            $table->text('code')->nullable();
            $table->integer('views')->nullable();
            $table->integer('review_count')->nullable();
            $table->boolean(column: 'latest_products')->default(1);
            $table->boolean(column: 'new_arrivals')->default(1);
            $table->string(column: 'currency')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
