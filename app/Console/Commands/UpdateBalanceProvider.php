<?php

namespace App\Console\Commands;

use App\Models\Api;
use App\Support\Provider;
use Illuminate\Console\Command;

class UpdateBalanceProvider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:balanceProvider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update form balance providers.';

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
               $api->balance = $providerCallback->balance;
               $api->update();
            }
        }
    }
}
