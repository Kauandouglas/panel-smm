<?php

namespace App\Http\Controllers\Forgot;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotController extends Controller
{
    public function passwordRequest()
    {
        return view('forgot.passwordRequest');
    }

    public function passwordEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->withSuccess(__($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function passwordReset($token)
    {
        return view('forgot.resetPassword', [
            'token' => $token
        ]);
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('panel.auth.formLogin')->withSuccess(__($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
