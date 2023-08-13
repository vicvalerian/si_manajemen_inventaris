<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Image;

class BlogController extends Controller
{
    public function allBlog()
    {
        $blogs = Blog::latest()->get();

        return view('admin.blogs.blogs_all', compact('blogs'));
    }

    public function addBlog()
    {
        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();

        return view('admin.blogs.blogs_add', compact('categories'));
    }

    public function storeBlog(Request $request)
    {

        $image = $request->file('blog_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::make($image)->resize(430, 327)->save('storage/upload/blog/' . $name_gen);
        $save_url = 'storage/upload/blog/' . $name_gen;

        Blog::insert([
            'blog_category_id' => $request->blog_category_id,
            'blog_title' => $request->blog_title,
            'blog_tags' => $request->blog_tags,
            'blog_description' => $request->blog_description,
            'blog_image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Berhasil menambahkan blog!',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog')->with($notification);
    }

    public function editBlog($id)
    {
        $blogs = Blog::findOrFail($id);
        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();
        return view('admin.blogs.blogs_edit', compact('blogs', 'categories'));
    }

    public function updateBlog(Request $request)
    {
        $blog_id = $request->id;
        $blog = Blog::findOrFail($blog_id);
        if ($request->file('blog_image')) {
            $image = $request->file('blog_image');
            @unlink($blog->blog_image);
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();  // 3434343443.jpg

            Image::make($image)->resize(430, 327)->save('storage/upload/blog/' . $name_gen);
            $save_url = 'storage/upload/blog/' . $name_gen;

            $blog->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
                'blog_image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Berhasil mengubah blog dengan gambar!',
                'alert-type' => 'success'
            );

            return redirect()->route('all.blog')->with($notification);
        } else {
            $blog->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
            ]);

            $notification = array(
                'message' => 'Berhasil mengubah blog tanpa gambar!',
                'alert-type' => 'success'
            );

            return redirect()->route('all.blog')->with($notification);
        }
    }

    public function deleteBlog($id)
    {
        $blogs = Blog::findOrFail($id);
        $img = $blogs->blog_image;
        unlink($img);

        Blog::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Berhasil menghapus blog!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function blogDetails($id)
    {
        $allblogs = Blog::latest()->limit(5)->get();
        $blogs = Blog::findOrFail($id);
        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();

        return view('frontend.blog_details', compact('blogs', 'allblogs', 'categories'));
    }

    public function categoryBlog($id)
    {
        $blogpost = Blog::where('blog_category_id', $id)->orderBy('id', 'DESC')->get();
        $allblogs = Blog::latest()->limit(5)->get();
        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();
        $categoryname = BlogCategory::findOrFail($id);

        return view('frontend.cat_blog_details', compact('blogpost', 'allblogs', 'categories', 'categoryname'));
    }

    public function homeBlog()
    {
        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();
        $allblogs = Blog::latest()->get();
        
        return view('frontend.blog', compact('allblogs', 'categories'));
    }
}
