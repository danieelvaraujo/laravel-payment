<?php

namespace App\Http\Controllers;

use App\Models\PaymentPlatform;
use App\Models\Plan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function show()
    {
        $paymentPlatforms = PaymentPlatform::where('subscriptions_enabled', true)->get();
        
        return view('subscribe')
            ->with([
                'plans' => Plan::all(),
                'paymentPlatforms' => PaymentPlatform::all()
            ]);
    }
}
