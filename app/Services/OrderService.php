<?php

namespace App\Services;

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class OrderService
{
    public function store(User $user, Service $service, $quantity, int $orderCount, float $price, Request $request)
    {
        if ($quantity < $service->quantity_min || $quantity > $service->quantity_max) {
            return 'invalid_quantity';
        }

        if ($user->balance < $price) {
            return 'insufficient_funds';
        }

        if ($orderCount != 0) {
            return 'order_exist';
        }

        $user->balance = $user->balance - $price;
        $user->update();

        $request['service_id'] = $service->id;
        $request['quantity'] = $quantity;
        $request['price'] = $price;

        return $user->orders()->create($request->all());
    }
}
