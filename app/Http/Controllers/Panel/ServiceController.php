<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $categories = Category::active()->with(['services' => function ($query) {
            $query->active()->with(['userServicePrice' => function ($query) {
                $query->where('user_id', Auth::id());
            }]);
        }])->oldest('sort')->paginate(100);

        return view('panel.services.index', [
            'categories' => $categories
        ]);
    }

    public function list(Request $request)
    {
        $service = Service::active()->with('type')->findOrFail($request->service);
        $userServicePrice = $service->userServicePrice()->where('user_id', Auth::id())->first();

        return response()->json([
            'id' => $service->id,
            'name' => $service->name,
            'description' => $service->description,
            'quantity_min' => $service->quantity_min,
            'quantity_max' => $service->quantity_max,
            'price' => number_format($userServicePrice->price ?? $service->price, 2, '.', '.'),
            'type' => [
                'id' => $service->type->id,
                'name' => $service->type->name
            ]
        ]);
    }
}
