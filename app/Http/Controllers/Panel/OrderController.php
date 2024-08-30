<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\OrderRequest;
use App\Models\Category;
use App\Models\Service;
use App\Models\Status;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index()
    {
        $statues = Status::withCount(['orders' => function ($query) {
            $query->where('user_id', Auth::id());
        }])->whereNotIn('id', [7])->get();
        $orders = Auth::user()->orders()->when(request()->status, function ($query, $status) {
            $query->where('status_id', $status);
        })->when(request()->order, function ($query, $order) {
            $query->where(function ($query) use ($order) {
                return $query->where('id', $order)->orWhere('link', 'like', '%' . $order . '%');
            });
        })->when(request()->search, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('id', $search)->orWhere('link', 'LIKE', "%$search%");
            });
        })->with('service')->with('status')->with(['refill' => function ($query) {
            $query->latest('id');
        }])->latest('id')->paginate(15);

        return view('panel.orders.index', [
            'orders' => $orders,
            'statues' => $statues
        ]);
    }

    public function create()
    {
        $categories = Category::active()->oldest('sort')->get();

        return view('panel.orders.create', [
            'categories' => $categories
        ]);
    }

    public function store(OrderRequest $request)
    {
        $service = Service::whereHas('category', function ($query) {
            $query->active();
        })->active()->find($request->service_id);
        $userServicePrice = $service->userServicePrice()->where('user_id', Auth::id())->first();
        $orderCount = Auth::user()->orders()->where('link', $request->link)->whereIn('status_id', [1, 2, 3])->count();

        if ($service->type_id == 3) {
            $quantity = (empty(trim($request->comments)) ? 0 :
                count(preg_split('/\r\n|\r|\n/', trim($request->comments))));
        } else {
            $quantity = $request->quantity;
        }

        $user = Auth::user();
        $price = ($userServicePrice->price ?? $service->price) / 1000 * $quantity;

        $order = new OrderService();
        $order = $order->store($user, $service, $quantity, $orderCount, $price, $request);

        if ($order == 'insufficient_funds') {
            return response()->json([
                'errors' => [
                    'quantity' => 'Saldo insuficiente'
                ]
            ], 422);
        }

        if ($order == 'invalid_quantity') {
            return response()->json([
                'errors' => [
                    'quantity' => 'Quantidade inválida'
                ]
            ], 422);
        }

        if ($order == 'order_exist') {
            return response()->json([
                'errors' => [
                    'quantity' => 'Já existe uma ordem pendente para esse link'
                ]
            ], 422);
        }

        $message = "Seu Pedido foi Recebido <br>
        ID: $order->id<br>
        Link: $request->link<br>
        Quantidade: $quantity<br>
        Valor: R$ $price<br>
        Saldo: R$ $user->convert_balance";

        Session::flash('success', $message);

        return response()->json([
            'success' => true
        ], 201);
    }

    public function mass()
    {
        return view('panel.orders.order_mass');
    }

    public function massDo(Request $request)
    {
        $user = Auth::user();
        $orders = preg_split('/\r\n|\r|\n/', trim($request->orders));

        $success = 0;
        $error = 0;
        $priceSum = 0.00;

        foreach ($orders as $order) {
            $orderMass = explode("|", $order);

            $service_id = trim($orderMass[0]);
            $link = trim($orderMass[1]) ?? '';
            $quantity = trim($orderMass[2]) ?? '';

            $service = Service::active()->find($service_id);
            $orderCount = Auth::user()->orders()->where('link', $link)->whereIn('status_id', [1, 2, 3])->count();

            if (empty(trim($service_id)) || empty(trim($link)) || empty(trim($quantity)) || !$service
                || $quantity < $service->quantity_min || $quantity > $service->quantity_max) {
                $error += 1;
                continue;
            }

            $userServicePrice = $service->userServicePrice()->where('user_id', Auth::id())->first();

            $request['service_id'] = $service_id;
            $request['link'] = $link;

            $price = ($userServicePrice->price ?? $service->price) / 1000 * $quantity;

            $order = new OrderService();
            $order = $order->store($user, $service, $quantity, $orderCount, $price, $request);

            if ($order == "insufficient_funds" || $order == "invalid_quantity" || $order == "order_exist") {
                $error += 1;
                continue;
            }

            $priceSum += $service->price * $quantity;
            $success += 1;
        }

        $message = "Seu Pedido foi Recebido <br>
        Sucesso: $success<br>
        Erro: $error<br>
        Valor: R$ $priceSum<br>
        Saldo: R$ $user->convert_balance";

        Session::flash('success', $message);

        return response()->json([
            'success' => true
        ], 201);
    }
}
