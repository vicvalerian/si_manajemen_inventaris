<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function allBlogCategory()
    {
        $blogCategory = BlogCategory::latest()->get();

        return view('admin.blog_category.blog_category_all', compact('blogCategory'));
    }

    public function addBlogCategory()
    {
        return view('admin.blog_category.blog_category_add');
    }

    public function storeBlogCategory(Request $request)
    {
        $request->validate([
            'blog_category' => 'required'
        ], [
            'blog_category.required' => 'Nama kategori blog tidak boleh kosong!',
        ]);

        BlogCategory::insert([
            'blog_category' => $request->blog_category,

        ]);

        $notification = array(
            'message' => 'Berhasil menambahkan kategori blog!',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.category')->with($notification);
    }

    public function editBlogCategory($id)
    {
        $blogCategory = BlogCategory::findOrFail($id);

        return view('admin.blog_category.blog_category_edit', compact('blogCategory'));
    }


    public function updateBlogCategory(Request $request, $id)
    {
        BlogCategory::findOrFail($id)->update([
            'blog_category' => $request->blog_category,
        ]);

        $notification = array(
            'message' => 'Berhasil mengubah kategori blog!',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.category')->with($notification);
    }

    public function deleteBlogCategory($id)
    {
        BlogCategory::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Berhasil menghapus kategori blog!',
            'alert-type' => 'success'
        );
        
        return redirect()->back()->with($notification);
    }
}
