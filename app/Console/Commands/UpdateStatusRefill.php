<?php

namespace App\Console\Commands;

use App\Models\Refill;
use App\Support\Provider;
use Illuminate\Console\Command;

class UpdateStatusRefill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:statusRefill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status refill.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $refills = Refill::with('order.service.api')->whereNotNull('refill_id')
           ->inProgress()->get();
        foreach ($refills as $refill){
            $provider = new Provider($refill->order->service->api->url, $refill->order->service->api->token);
            $provider->refillStatus($refill->refill_id);
            $provider = $provider->callback();

            if($provider->status == "Completed"){
                $refill->status_id = 4;
                $refill->completed_at = now();
                $refill->update();
            }elseif($provider->status == "Rejected"){
                $refill->status_id = 7;
                $refill->completed_at = now();
                $refill->update();
            }
        }
    }
}
