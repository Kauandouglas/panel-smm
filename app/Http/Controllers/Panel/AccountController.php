<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\AccountRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function edit()
    {
        return view('panel.accounts.edit');
    }

    public function update(AccountRequest $request)
    {
        $user = Auth::user();
        $user->fill($request->all());
        $user->setImage($request->file('image'));
        $user->update();

        return response()->json([
           'message' => "Perfil salvo com sucesso!"
        ], 201);
    }

    public function create()
    {
        return view('panel.accounts.create');
    }

    public function store(AccountRequest $request)
    {
        $user = User::create($request->all());
        $user->api_key = md5(uniqid($user->id));
        $user->phone = $request->phone;
        $user->latest_login_at = now();
        $user->update();

        Auth::login($user);

        return response()->json('success', 201);
    }

    public function token()
    {
        $user = Auth::user();
        $user->api_key = md5(uniqid($user->id));
        $user->update();

        return redirect()->back()->withSuccess('Chave gerada com sucesso!');
    }
}
