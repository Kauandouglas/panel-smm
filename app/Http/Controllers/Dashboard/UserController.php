<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        $users = User::users()->withSum(['orders' => function ($query) {
            $query->whereIn('status_id', [1, 2, 3, 4]);
        }], 'price')->when(request()->search, function ($query, $search) {
            $query->where('email', 'LIKE', "%$search%")->orWhere('phone', 'LIKE', "%$search%");
        })->withCount('userServicePrices')->latest('id')->paginate(100);

        return view('dashboard.users.index', [
            'users' => $users
        ]);
    }

    public function status(User $user)
    {
        $user->status = !$user->status;
        $user->update();

        return redirect()->back();
    }

    public function edit(User $user)
    {
        return view('dashboard.users.edit', [
            'user' => $user
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $user->fill($request->all());
        $user->setImage($request->file('image'));
        $user->update();

        return response()->json([
            'message' => "Perfil salvo com sucesso!"
        ], 201);
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
