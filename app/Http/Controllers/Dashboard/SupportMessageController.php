<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\SupportMessageRequest;
use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportMessageController extends Controller
{
    public function store(SupportMessageRequest $request)
    {
        $support = Support::active()->findOrFail($request->support);
        $supportMessage = $support->supportMessages()->create($request->all());
        $supportMessage->send_admin = 1;
        $supportMessage->update();

        if($support->status == 0){
            $support->status = 1;
            $support->update();
        }

        return response()->json([
            'success' => true
        ]);
    }
}
