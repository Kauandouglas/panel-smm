<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\SupportRequest;
use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function index(Request $request)
    {
        $supports = Auth::user()->supports()->latest('id')->paginate(50);
        if(!empty($request->support)){
            $supportFind = Auth::user()->supports()->findOrFail($request->support);
            $supportMessages = $supportFind->supportMessages()->oldest('id')->get();
        }

        return view('panel.supports.index', [
            'supports' => $supports,
            'supportFind' => $supportFind ?? null,
            'supportMessages' => $supportMessages ?? []
        ]);
    }

    public function store(SupportRequest $request)
    {
        $support = Auth::user()->supports()->create($request->all());
        $support->supportMessages()->create($request->all());

        return redirect()->route('panel.supports.index', ['support' => $support]);
    }
}
