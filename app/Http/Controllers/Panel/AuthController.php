<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index()
    {
        $ordersGraphic = Auth::user()->orders()
            ->select(DB::raw("COUNT(*) as count"),
                DB::raw("DATE_FORMAT(orders.created_at,'%Y-%m-%d') as date_format"))
            ->completed()
            ->whereMonth('created_at', date('m'))
            ->oldest('id')
            ->groupBy('date_format')
            ->get();

        $spend = Auth::user()->orders()->whereIn('status_id', [1, 2, 3, 4])->sum('price');
        $orders = Auth::user()->orders()->count();
        $supports = Auth::user()->supports()->count();

        $count = [];
        $date = [];

        foreach ($ordersGraphic as $order) {
            $count[] = $order->count;
            $date[] = date('d/m/Y', strtotime($order->date_format));
        }

        $totalDay = cal_days_in_month(0, date('m'), date('Y'));

        for ($i = 1; $i <= $totalDay; $i++) {
            $totalDays = date('d/m/Y', strtotime(date('Y') . '-' . date('m') . '-' . $i));
            if (in_array($totalDays, $date)){
                $countArray[] = $count[array_search($totalDays, $date)];
                $dateArray[] = $date[array_search($totalDays, $date)];
            }else{
                $countArray[] = 0;
                $dateArray[] = $totalDays;
            }
        }

        return view('panel.index', [
            'spend' => $spend,
            'orders' => $orders,
            'supports' => $supports,
            'ordersCount' => json_encode($countArray),
            'ordersDate' => json_encode($dateArray),
        ]);
    }

    public function formLogin()
    {
        if (Auth::check() && Auth::user()->role == 1 && Auth::user()->status) {
            return redirect()->route('panel.index');
        }

        return view('panel.auth.form_login');
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials, true)) {
            return response()->json([
                'error' => 'Email ou senha inválidos'
            ], 401);
        }

        if (!$this->verifyLevel()) {
            return response()->json([
                'error' => 'Não é possivel usar essa conta para realizar o login.'
            ], 401);
        }

        if (!Auth::user()->status) {
            Auth::logout();

            return response()->json([
                'error' => 'Sua conta foi bloqueada.'
            ], 401);
        }

        $request->session()->regenerate();

        $user = Auth::user();
        $user->latest_login_at = now();
        $user->update();

        return response()->json([
            'success' => true
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('web.home');
    }

    private function verifyLevel()
    {
        if (Auth::user()->role != 1) {
            Auth::logout();
            return false;
        }

        return true;
    }
}
