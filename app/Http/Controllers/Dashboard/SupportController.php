<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index(Request $request)
    {
        $supports = Support::latest('id')->paginate(50);
        if(!empty($request->support)){
            $supportFind = Support::findOrFail($request->support);
            $supportMessages = $supportFind->supportMessages()->oldest('id')->get();
        }

        return view('dashboard.supports.index', [
            'supports' => $supports,
            'supportFind' => $supportFind ?? null,
            'supportMessages' => $supportMessages ?? []
        ]);
    }

    public function finish(Support $support)
    {
        $support->status = 2;
        $support->update();

        return redirect()->back();
    }
}
