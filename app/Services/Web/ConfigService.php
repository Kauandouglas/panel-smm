<?php

namespace App\Services\Web;

use App\Models\Config;

class ConfigService
{
    public function config()
    {
        return Config::first();
    }
}
