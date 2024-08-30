<?php

namespace App\Services;

use App\Models\Refill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefillService
{
    public function store(int $orderId, User $user)
    {
        $order = $user->orders()->find($orderId);
        if (!$order) {
            return 'incorrect_order';
        }

        $service = $order->service()->first();
        if (!$service->refill) {
            return 'disabled';
        }

        if ($order->status_id != 4) {
            return 'not_completed';
        }

        $refill = $order->refill()->deadline()->latest('id')->first();

        if ($refill || strtotime($order->completed_at) >
            strtotime(date('Y-m-d H:i:s', strtotime("-24 hours")))) {
            return 'refill_deadline';
        }

        $refill = new Refill();
        $refill->order_id = $order->id;
        $refill->user_id = $user->id;
        $refill->status_id = 3;
        $refill->completed_at = now();
        $refill->save();

        return $refill;
    }
}
