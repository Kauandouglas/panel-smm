<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\OrderEditLinkRequest;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $statues = Status::withCount('orders')->whereNotIn('id', [7])->get();
        $orders = Order::when(request()->status, function ($query, $status) {
            if ($status == "error") {
                $query->where('status_id', 2)->whereNotNull('error');
            } else {
                $query->where('status_id', $status);
            }
        })->when(request()->search, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('id', $search)->orWhere('link', 'LIKE', "%$search%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%$search%")
                            ->orWhere('email', 'LIKE', "%$search%");
                    });
            });
        })->with('service')->with('status')->with('user')->with(['refill' => function ($query) {
            $query->latest('id');
        }])->latest('id')->paginate(15);
        $ordersFailCount = Order::where('status_id', 2)->whereNotNull('error')->count();

        return view('dashboard.orders.index', [
            'orders' => $orders,
            'statues' => $statues,
            'ordersFailCount' => $ordersFailCount
        ]);
    }

    public function editLink(Order $order, OrderEditLinkRequest $request)
    {
        $order->link = $request->link;
        $order->update();

        return redirect()->back();
    }

    public function repay(Request $request)
    {
        $order = Order::whereNotIn('status_id', [5, 6])->findOrFail($request->order);
        $order->status_id = 6;
        $order->update();

        $user = $order->user()->first();
        $user->balance = $user->balance + $order->price;
        $user->update();

        return redirect()->back();
    }

    public function finish(Request $request)
    {
        $order = Order::whereNotIn('status_id', [4])->findOrFail($request->order);
        $order->status_id = 4;
        $order->update();

        return redirect()->back();
    }

    public function resend()
    {
        $order = Order::where('status_id', 2)->whereNotNull('error')->update([
            'status_id' => 1,
            'error' => null
        ]);

        return redirect()->back();
    }
}
