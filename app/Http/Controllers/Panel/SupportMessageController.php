<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\SupportMessageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportMessageController extends Controller
{
    public function store(SupportMessageRequest $request)
    {
        $support = Auth::user()->supports()->active()->findOrFail($request->support);
        $support->supportMessages()->create($request->all());

        if($support->status == 1){
            $support->status = 0;
            $support->update();
        }

        return response()->json([
           'success' => true
        ]);
    }
}
