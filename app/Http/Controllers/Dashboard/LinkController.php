<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    public function index()
    {
        $links = Link::latest('id')->paginate(30);

        return view('dashboard.links.index', [
            'links' => $links
        ]);
    }

    public function store(Request $request)
    {
        $link = new Link();
        $link->slug = Str::slug($request->name);
        $link->save();

        return redirect()->back();
    }
}
