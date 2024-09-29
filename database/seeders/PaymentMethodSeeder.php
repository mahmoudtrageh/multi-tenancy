<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethod::factory()->count(1)->create();

        PaymentMethod::create([
            'name' => 'Paypal',
            'slug' => 'paypal',
            'api_key' => 'AVq8EojXDh1bo4CujVQObW54ROfSxfQyFTZrb9gh-iWmFC--Szv7Yx5mdYBR64TWLyj0R5ZLYV53LOeh',
            'api_secret' => 'ENLKg1PA3aIQACEe7pEc_Wi02ZlrMeZlHmTqtXgPKJS7Be_mRDG_QRibDu4M88pEi4yDdSE50qCkKDSl',
            'user_name' => 'sandbox'
        ]);
    }
}
