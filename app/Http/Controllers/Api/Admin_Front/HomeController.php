<?php

namespace App\Http\Controllers\Api\Admin_Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Subscription;
use Carbon\Carbon;
use App\Http\Controllers\Api\Admin_Front\Checkout\PaypalPaymentController;

class HomeController extends Controller
{
    protected $paypal;
    public function __construct(PaypalPaymentController $paypal)
    {
        $this->paypal = $paypal;
    }
    public function getPackages()
    {
        return Package::with(relations: 'features')->get();
    }

    public function create_tenant(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'package_id' => 'required',
            'subscription_type' => 'required',
        ]);

        $tenant = Tenant::create([
            'id' => $request->name,
        ]);

        $tenant->domains()->create([
            'domain' => $request->name.'.localhost'
        ]);

        $package = Package::find($request->package_id);
        if (!isset($package)) {
            return response()->json('package not available', 400);
        }

        // get start date and end date
        $end_date = '';
        $today = today();
        $total = 0;
        if($request->subscription_type == 'monthly')
        {
            $end_date = $today->addDays(30);
            $total = $package->monthly_price;
        } else {
            $end_date = $today->addYear();
            $total = $package->annual_price;
        }

        $data = $request->all();
        $data['total'] = $total;
        $data['tenant_id'] = $tenant->id;

        $subscription = Subscription::create([
            'tenant_id' => $tenant->id,
            'package_id' => $package->id,
            'start_date' => $today->format('Y-m-d'),
            'end_date' => $end_date->format('Y-m-d'),
            'total' => $total,
            'user_id' => $request->user()->id
        ]);

        $data['subscription'] = $subscription;

        try {
            $pay = $this->paypal->pay($data);
        } catch (\InvalidArgumentException $e) {
            return 'failed';
        }

        return $pay;
    }
}
