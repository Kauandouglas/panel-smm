<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Support\Provider;
use Illuminate\Console\Command;

class SendOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Order Provider';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders = Order::whereNull('order_id')->pending()->with('service.api')->get();

        foreach ($orders as $order) {
            $provider = new Provider($order->service->api->url, $order->service->api->token);
            $provider->addOrder($order->service->api_service, $order->link, $order->quantity, $order->comments);
            $providerCallback = $provider->callback();

            if (isset($providerCallback->order)) {
                $order->order_id = $providerCallback->order;
            } else {
                $order->error = json_encode($providerCallback);
                $order->status_id = 2;
            }
            $order->update();
        }
    }
}
