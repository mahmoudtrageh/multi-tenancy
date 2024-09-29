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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('annual_price', total: 8, places: 2)->default(0);
            $table->decimal('monthly_price', total: 8, places: 2)->default(0);
            $table->boolean('status')->default(true);
            $table->boolean('is_forever')->default(false);
            $table->string('type')->nullable();
            $table->integer('trial_period')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
