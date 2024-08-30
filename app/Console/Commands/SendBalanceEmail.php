<?php

namespace App\Console\Commands;

use App\Mail\Dashboard\ApiNotBalance;
use App\Models\Api;
use App\Support\Provider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SendBalanceEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:balanceEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Balance Email';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $apis = Api::all();
        foreach ($apis as $api) {
            $provider = new Provider($api->url, $api->token);
            $provider->balance();
            $providerCallback = $provider->callback();

            if (isset($providerCallback->balance)) {
                if ($providerCallback->balance < 10) {
                    if(!Cache::has('apis.' . $api->id)) {
                        Cache::rememberForever('apis.' . $api->id, function () use ($api) {
                            return Mail::to('sociei.com@gmail.com')->send(new ApiNotBalance($api));
                        });
                    }
                } else {
                    Cache::forget('apis.' . $api->id);
                    echo 'cache apagado' . $api->id;
                }
            }
        }
    }
}
