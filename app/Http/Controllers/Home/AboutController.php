<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Image;

class AboutController extends Controller
{
    public function aboutPage(){
        $aboutPage = About::find(1);

        return view('admin.about_page.about_page_all', compact('aboutPage'));
    }

    public function updateAbout(Request $request){
        $about_id = $request->id;
        $about = About::findOrFail($about_id);

        if ($request->file('about_image')) {
            if(isset($about->about_image)) {
                @unlink($about->about_image);
            }

            $image = $request->file('about_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(523,605)->save('storage/upload/home_about/'.$name_gen);
            $save_url = 'storage/upload/home_about/'.$name_gen;

            $about->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'about_image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Berhasil mengubah halaman about dengan gambar!',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        } else {

            $about->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
            ]);

            $notification = array(
                'message' => 'Berhasil mengubah halaman about tanpa gambar!',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        }
    }

    public function homeAbout(){
        $aboutPage = About::find(1);

        return view('frontend.about_page', compact('aboutPage'));
    }
}
