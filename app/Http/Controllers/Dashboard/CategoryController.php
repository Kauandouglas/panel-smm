<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return redirect()->back();
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->back();
    }

    public function disabled(Category $category)
    {
        $category->status = !$category->status;
        $category->update();

        return redirect()->back();
    }

    public function sort(Request $request)
    {
        $order = 1;
        foreach ($request->categories as $category) {
            Category::where('id', $category)->update(['sort' => $order]);
            $order++;
        }

        return response()->json([
            'success' => true
        ]);
    }
}
