<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BillingController extends Controller
{
    /**
     * Show the payment list
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function payments()
    {
        $stripKey = config('app.STRIPE_KEY');

        View::share('stripKey', $stripKey);
        return view('billing.payments');
    }
}
