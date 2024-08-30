<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserServicePriceRequest;
use App\Models\Service;
use App\Models\User;
use App\Models\UserServicePrice;
use Illuminate\Http\Request;

class UserServicePriceController extends Controller
{
    public function index(Request $request)
    {
        $user = User::users()->findOrFail($request->user);
        $userServicePrices = $user->userServicePrices()->with('service')->latest('id')->get();
        $services = Service::active()->oldest('id')->get();

        return view('dashboard.userServicePrices.index', [
            'user' => $user,
            'userServicePrices' => $userServicePrices,
            'services' => $services
        ]);
    }

    public function store(UserServicePriceRequest $request)
    {
        $user = User::users()->findOrFail($request->user);
        $userServicePrice = $user->userServicePrices()->create($request->all());

        return redirect()->back()->withSuccess('Cadastrado com sucesso!');
    }

    public function destroy(UserServicePrice $userServicePrice)
    {
        $userServicePrice->delete();

        return redirect()->back()->withSuccess('Removido com sucesso!');
    }
}
