<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\Panel\AddBalance;
use App\Support\PagHiper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use MercadoPago\SDK;
use MercadoPago\MerchantOrder;
use MercadoPago\Payment;

class PaymentController extends Controller
{
    public function notification(Request $request)
    {
        if (config('api.mercado_pago.token_notification') != $request->token) {
            return response([
                'token' => 'Token inválido'
            ], 403);
        }

       SDK::setAccessToken(config('api.mercado_pago.access_token'));

       $merchant_order = null;
       switch ($request->topic) {
           case "payment":
               $payment = Payment::find_by_id($request->id);
               break;
           case "merchant_order":
               $merchant_order = MerchantOrder::find_by_id($request->id);
               break;
       }

       // If the payment's transaction amount is equal (or bigger) than the merchant_order's amount you can release your items
       if (isset($payment->status) && $payment->status == "approved") {
           // The merchant_order has shipments
           $payment = \App\Models\Payment::findOrFail($payment->external_reference);

           if ($payment->status == 0) {
               $payment->status = 1;
               $payment->update();

               $user = $payment->user()->first();
               $user->balance = $user->balance + $payment->price;
               $user->update();

               Mail::to('sociei.com@gmail.com')->send(new AddBalance($user, $payment));

               return response([
                   'status' => 'success'
               ]);
           }
       } else {
           $return = "Not paid yet. Do not release your item.";
       }
    }

    public function notificationStripe(Request $request)
    {
        if (config('api.stripe.token_notification') != $request->token) {
            return response([
                'token' => 'Token inválido'
            ], 403);
        }

        if($request->type == 'payment_intent.succeeded'){
            $payment = \App\Models\Payment::findOrFail($request->data['object']['metadata']['reference']);

            if ($payment->status == 0) {
                $payment->status = 1;
                $payment->update();

                $user = $payment->user()->first();
                $user->balance = $user->balance + $payment->price;
                $user->update();

                return response([
                    'status' => 'success'
                ]);
            }
        }
    }
}
