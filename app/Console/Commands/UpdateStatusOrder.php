<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Support\Provider;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class UpdateStatusOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:statusOrder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all orders status.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders = Order::with('service.api')->whereIn('status_id', [1, 2, 3])
            ->whereNotNull('order_id')->whereNull('error')->get();
        foreach ($orders as $order) {
            $provider = new Provider($order->service->api->url, $order->service->api->token);
            $provider->statusOrder($order->order_id);
            $provider = $provider->callback();

            if (isset($provider->status)) {
                $order->start_count = $provider->start_count;
                $order->remains = $provider->remains;

                if ($provider->currency == "USD"){
                    $content = Cache::remember('dolar', 600, function () {
                        $client = new Client();
                        $response = $client->request('GET', 'https://economia.awesomeapi.com.br/all/USD-BRL');
                        $content = $response->getBody();

                        return json_decode($content);
                    });

                    $charge = $provider->charge * $content->USD->bid;
                }else{
                    $charge = $provider->charge;
                }

                $order->charge = $charge;
                $order->profit = $order->price - $charge;

                if ($provider->status == "Processing") {
                    $order->status_id = 2;
                    $order->save();
                } elseif ($provider->status == "In progress") {
                    $order->status_id = 3;
                    $order->save();
                } elseif ($provider->status == "Completed") {
                    $order->status_id = 4;
                    $order->completed_at = now();
                    $order->save();
                } elseif ($provider->status == "Partial") {
                    $order->status_id = 5;
                    $order->save();

                    $remains = ($order->price / $order->quantity) * $provider->remains;

                    if ($provider->remains <= $order->quantity) {
                        $user = $order->user()->first();
                        $user->balance = $user->balance + $remains;
                        $user->update();
                    }
                } elseif ($provider->status == "Canceled" || $provider->status == "Refunded") {
                    $order->status_id = 6;
                    $order->save();
                    
                    $user = $order->user()->first();
                    $user->balance = $user->balance + $order->price;
                    $user->update();
                }
            }
        }
    }
}
