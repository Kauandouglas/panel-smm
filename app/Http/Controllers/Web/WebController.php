<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebController extends Controller
{
    public function home()
    {
        return view('web.index');
    }

    public function service()
    {
        $categories = Category::active()->with(['services' => function ($query) {
            $query->active();
        }])->oldest('sort')->get();

        return view('web.service', [
            'categories' => $categories
        ]);
    }
}
