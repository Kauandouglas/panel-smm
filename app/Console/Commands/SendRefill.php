<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Refill;
use App\Support\Provider;
use Illuminate\Console\Command;

class SendRefill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:refill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Refill Provider';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $refills = Refill::whereNull('refill_id')->inProgress()->with('order.service.api')->get();

        foreach ($refills as $refill) {
            $provider = new Provider($refill->order->service->api->url, $refill->order->service->api->token);
            $provider->refill($refill->order->order_id);
            $providerCallback = $provider->callback();

            if (isset($providerCallback->refill)) {
                $refill->refill_id = $providerCallback->refill;
            } else {
                $refill->error = json_encode($providerCallback);
                $refill->status_id = 7;
            }
            $refill->update();
        }
    }
}
