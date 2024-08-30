<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function listService(Request $request)
    {
        $category = Category::active()->findOrFail($request->category);
        $services = $category->services()->active()->get();

        return response()->json($services);
    }
}
