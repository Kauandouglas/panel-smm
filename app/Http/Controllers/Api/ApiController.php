<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApiRequest;
use App\Models\Service;
use App\Services\OrderService;
use App\Services\RefillService;

class ApiController extends Controller
{
    public function index(ApiRequest $request)
    {
        $user = $request->get('user');

        if (!$user->status) {
            return response()->json([
                'error' => 'Your account has been suspended.'
            ], 401);
        }

        switch ($request->action) {
            case "services":
                $services = Service::whereHas('category', function ($query) {
                    $query->active();
                })->with(['userServicePrice' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                }])->active()->get();

                $arrayServices = [];
                foreach ($services as $service) {
                    $arrayServices[] = [
                        'service' => $service->id,
                        'name' => $service->name,
                        'type' => ($service->type_id == 3 ? 'Custom Comments' : 'Default'),
                        'rate' => floatval($service->userServicePrice->price ?? $service->price),
                        'min' => $service->quantity_min,
                        'max' => $service->quantity_max,
                        'dripfeed' => false,
                        'refill' => boolval($service->refill),
                        'cancel' => false,
                        'category' => $service->category->name
                    ];
                }

                return response()->json($arrayServices);

            case "add":
                $service = Service::whereHas('category', function ($query) {
                    $query->active();
                })->active()->find($request->service);
                $orderCount = $user->orders()->where('link', $request->link)->whereIn('status_id', [1, 2, 3])
                    ->count();

                if (!$service) {
                    return response()->json([
                        'error' => 'Incorrect service ID'
                    ], 422);
                }

                if ($service->type_id == 3) {
                    $quantity = (empty(trim($request->comments)) ? 0 :
                        count(preg_split('/\r\n|\r|\n/', trim($request->comments))));
                } else {
                    $quantity = $request->quantity;
                }

                if (empty(trim($request->link))) {
                    return response()->json([
                        'error' => 'Bad link'
                    ], 422);
                }

                $userServicePrice = $service->userServicePrice()->where('user_id', $user->id)->first();

                $price = ($userServicePrice->price ?? $service->price) / 1000 * $quantity;

                $order = new OrderService();
                $order = $order->store($user, $service, $quantity, $orderCount, $price, $request);

                if ($order == 'invalid_quantity') {
                    $errorQuantity = ($quantity < $service->quantity_min ?
                        'Quantity less than minimal ' . $service->quantity_min :
                        'Quantity more than maximum ' . $service->quantity_max);

                    return response()->json([
                        'error' => $errorQuantity
                    ], 422);
                }

                if ($order == 'insufficient_funds') {
                    return response()->json([
                        'error' => 'Not enough funds on balance'
                    ], 422);
                }

                if ($order == 'order_exist') {
                    return response()->json([
                        'error' => 'You have active order with this link. Please wait until order being completed.'
                    ], 422);
                }

                return response([
                    'order' => $order->id
                ], 201);

            case "status":
                if ($request->order) {
                    $ids = [$request->order];
                } else {
                    $ids = array_unique(explode(',', $request->orders));
                }

                $orders = $user->orders()->with('status')->whereIn('id', $ids)->get();

                $orderId = [];
                foreach ($orders as $order) {
                    $orderId[] = $order->id;
                }

                $arrayOrders = [];
                $i = 0;

                foreach ($ids as $id) {
                    if (in_array($id, $orderId)) {
                        $array = [
                            'charge' => $orders[$i]->price,
                            'start_count' => $orders[$i]->start_count,
                            'status' => $orders[$i]->status->name_api,
                            'remains' => intval($orders[$i]->remains),
                            'currency' => 'BRL'
                        ];

                        if ($request->order) {
                            $arrayOrders = $array;
                        } else {
                            $arrayOrders[] = $array;
                        }

                        $i++;
                    } else {
                        $arrayOrders [] = [
                            'error' => 'Incorrect order ID'
                        ];
                    }
                }

                return response($arrayOrders);
            case  "refill":
                $refillService = new RefillService();
                $refillService = $refillService->store($request->order, $user);

                if ($refillService == 'incorrect_order') {
                    return response()->json([
                        'error' => 'Incorrect order ID'
                    ], 422);
                }

                if ($refillService == 'disabled') {
                    return response()->json([
                        'error' => 'Refill is disabled for this service'
                    ], 422);
                }

                if ($refillService == 'not_completed') {
                    return response()->json([
                        'error' => 'The order is not completed'
                    ], 422);
                }

                if ($refillService == 'refill_deadline') {
                    return response()->json([
                        'error' => 'The order was completed or refill was requested less than 24 hours ago'
                    ], 422);
                }

                return response()->json([
                    'refill' => $refillService->id
                ], 201);
            case  "refill_status":
                $refill = $user->refills()->find($request->refill);

                if (!$refill) {
                    return response()->json([
                        'error' => 'Refill not found'
                    ], 422);
                }

                $status = $refill->status()->first();

                return response()->json([
                    'status' => $status->name_api,
                ]);

            case "balance":
                return response([
                    'balance' => $user->balance,
                    'currency' => 'BRL'
                ]);
        }
    }
}
