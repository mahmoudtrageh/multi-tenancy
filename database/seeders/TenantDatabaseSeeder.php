<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            BrandSeeder::class,
            CategorySeeder::class,
            SubCategorySeeder::class,
            SubSubCategorySeeder::class,
            ProductSeeder::class,
            VariantSeeder::class,
        ]);
    }
}
