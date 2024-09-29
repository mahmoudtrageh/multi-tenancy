<?php
use App\Models\PaymentMethod;

if (! function_exists('payment_method')) {
    function payment_method($slug)
    {
        $payment_method = PaymentMethod::where('slug', $slug)->where('status', 1)->first();
        return $payment_method;
    }
}
