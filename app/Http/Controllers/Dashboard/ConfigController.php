<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function edit()
    {
        $config = Config::first();

        return view('dashboard.configs.edit', [
            'config' => $config
        ]);
    }

    public function update(Request $request)
    {
        $config = Config::first();

        if (!$config) {
            $config = new Config();
        }

        $config->color = $request->color;
        $config->save();

        return response()->json([
            'message' => 'Editado com sucesso!'
        ]);
    }
}
