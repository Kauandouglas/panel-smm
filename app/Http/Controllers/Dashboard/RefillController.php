<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Refill;
use App\Models\Status;
use App\Models\User;
use App\Services\RefillService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefillController extends Controller
{
    public function index()
    {
        $statues = Status::withCount('refills')->whereIn('id', [3, 4, 7])->get();
        $refills = Refill::when(request()->status, function ($query, $status) {
            $query->where('status_id', $status);
        })->with('order.service')->with('status')->latest('id')->paginate(15);

        return view('dashboard.refills.index', [
            'statues' => $statues,
            'refills' => $refills
        ]);
    }

    public function store(Request $request)
    {
        $user = User::users()->findOrFail($request->user);

        $refillService = new RefillService();
        $refillService = $refillService->store($request->order, $user);

        if ($refillService == "incorrect_order") {
            return response()->json([
                'error' => 'Ordem não encontrada'
            ], 422);
        }

        if ($refillService == "not_completed") {
            return response()->json([
                'error' => 'Ordem não completada'
            ], 422);
        }

        if ($refillService == "refill_deadline") {
            return response()->json([
                'error' => 'Refil ainda no prazo'
            ], 422);
        }

        return response()->json([
            'refill' => $refillService->id
        ], 201);
    }
}
