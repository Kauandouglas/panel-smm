<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\PaymentRequest;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('user')->latest('id')->paginate(15);
        return view('dashboard.payments.index', [
            'payments' => $payments
        ]);
    }

    public function store(PaymentRequest $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();
        $user->balance = $user->balance + $request->balance;
        $user->update();

        $payment = new Payment();
        $payment->user_id = $user->id;
        $payment->price = $request->balance;
        $payment->memo = $request->memo;
        $payment->status = 1;
        $payment->save();

        return redirect()->back()->withSuccess('Saldo adicionado com sucesso!');
    }
}
