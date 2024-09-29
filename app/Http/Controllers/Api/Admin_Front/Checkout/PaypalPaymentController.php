<?php

namespace App\Http\Controllers\Api\Admin_Front\Checkout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Support\Facades\Hash;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Log;

class PaypalPaymentController extends Controller
{
    public function __construct()
    {
        $payment_method = payment_method('paypal');
        $config = [
            'mode'    => $payment_method->user_name,
            $payment_method->user_name => [
                'client_id' => $payment_method->api_key,
                'client_secret' => $payment_method->api_secret,
            ],
            'payment_action' => 'sale',
            'locale' => 'en_US',
            'validate_ssl' => true,
            'notify_url' => '',
            'currency' => 'USD',
        ];

        \Illuminate\Support\Facades\Config::set('paypal', $config);
    }

    public function pay($data)
    {
        $payment_method = payment_method('paypal');
        if (!isset($payment_method)) {
            return response()->json('payment method not available', 400);
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success'),
                "cancel_url" => route('paypal.cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => 'USD',
                        "value" => $data['total']
                    ]
                ]
            ]
        ]);

        if(isset($response['id']) && $response['id'] != null) {
            foreach($response['links'] as $link) {
                if($link['rel'] == 'approve') {

                    $subscription = $data['subscription'];
                    $subscription_data = [
                        'paypal_id' => $response['id'],
                        'tenant_id' => $data['tenant_id'],
                    ];

                    $subscription->update(['data' => json_encode($subscription_data)]);

                    return response()->json(['url' => $link['href']]);
                }
            }
        } else {
            return 'payment failed';
        }
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);

        if(isset($response['status']) && $response['status'] == 'COMPLETED') {

            $subscription = Subscription::where('data->paypal_id', $request->token)->first();

            $tenant = Tenant::on('mysql')->find(json_decode($subscription->data)->tenant_id);
            $tenant->update(['status' => 'active']);
            $tenant->status = 'active';
            $tenant->save();

            tenancy()->initialize($tenant);

            $user = User::on('mysql')->find(id: $subscription->user_id);

            $user_data = $user->toArray();
            $user_data['password'] = Hash::make('123456');
            User::on('tenant')->create($user_data);

            $subscription->update([
                'payment_method' => 'paypal',
                'payment_status' => 'paid',
                'data' => json_encode($response['payment_source'])
            ]);

            return redirect('http://localhost:5173/');

        } else {
            return false;
        }

    }

    public function cancel()
    {
        return false;
    }
}
