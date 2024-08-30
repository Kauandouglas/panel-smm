<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\PaymentRequest;
use App\Mail\Panel\AddBalance;
use App\Support\MercadoPago;
use App\Support\PagHiper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Auth::user()->payments()->latest('id')->paginate(15);

        return view('panel.payments.index', [
            'payments' => $payments
        ]);
    }

    public function show(Request $request)
    {
        $payment = Auth::user()->payments()->findOrFail($request->payment);

        return response()->json([
            'status' => $payment->status
        ]);
    }

    public function store(PaymentRequest $request)
    {
        $payment = Auth::user()->payments()->create($request->all());
        $payment->memo = 'Pix';
        $payment->update();

        $pix = new MercadoPago(config('api.mercado_pago.access_token'));
        $pix->pix($request->price, $payment->id, Auth::user()->email, explode(" ", Auth::user()->name)[0],
            explode(" ", Auth::user()->name)[1] ?? "");
        $pix = $pix->callback();

        return response()->json([
            'qr_code' => $pix->point_of_interaction->transaction_data->qr_code,
            'qr_code_base64' => $pix->point_of_interaction->transaction_data->qr_code_base64,
            'url' => route('panel.payments.show', ['payment' => $payment])
        ]);
    }

    public function stripeStore(PaymentRequest $request)
    {
        $payment = Auth::user()->payments()->create($request->all());
        $payment->memo = 'Cartão';
        $payment->update();

        \Stripe\Stripe::setApiKey(config('api.stripe.api_key'));
        try {
            $paymentIntent = \Stripe\PaymentIntent::create([
                'receipt_email' => Auth::user()->email,
                'amount' => $request->price * 100,
                'currency' => 'brl',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ], 'metadata' => [
                    'reference' => $payment->id,
                ],
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Error $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
