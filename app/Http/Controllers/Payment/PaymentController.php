<?php

namespace App\Http\Controllers\Payment;

use App\Services\BraintreeService;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $braintree;

    public function __construct(BraintreeService $braintree)
    {
        $this->braintree = $braintree;
    }

    public function createToken()
    {
        $clientToken = $this->braintree->gateway()->clientToken()->generate();
        return response()->json(['token' => $clientToken]);
    }

    public function processPayment(Request $request)
    {
        $amount = $request->amount;
        $nonce = $request->payment_method_nonce;

        $result = $this->braintree->gateway()->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            return response()->json(['success' => true, 'transaction' => $result->transaction]);
        } else {
            return response()->json(['success' => false, 'error' => $result->message]);
        }
    }
}
