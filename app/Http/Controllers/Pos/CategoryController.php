<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class CategoryController extends Controller
{
    public function categoryAll()
    {
        $categoris = Category::latest()->get();
        return view('backend.category.category_all', compact('categoris'));
    }

    public function categoryAdd()
    {
        return view('backend.category.category_add');
    }

    public function categoryStore(Request $request)
    {
        Category::insert([
            'name' => $request->name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Category Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('category.all')->with($notification);
    }

    public function categoryEdit($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.category.category_edit', compact('category'));
    }

    public function categoryUpdate(Request $request)
    {
        $category_id = $request->id;

        Category::findOrFail($category_id)->update([
            'name' => $request->name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Category Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('category.all')->with($notification);
    }

    public function categoryDelete($id)
    {
        Category::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
