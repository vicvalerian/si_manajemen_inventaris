<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Image;
use App\Models\MultiImage;
use Illuminate\Support\Carbon;

class AboutController extends Controller
{
    public function aboutPage()
    {
        $aboutPage = About::find(1);

        return view('admin.about_page.about_page_all', compact('aboutPage'));
    }

    public function updateAbout(Request $request)
    {
        $about_id = $request->id;
        $about = About::findOrFail($about_id);

        if ($request->file('about_image')) {
            if (isset($about->about_image)) {
                @unlink($about->about_image);
            }

            $image = $request->file('about_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(523, 605)->save('storage/upload/home_about/' . $name_gen);
            $save_url = 'storage/upload/home_about/' . $name_gen;

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

    public function homeAbout()
    {
        $aboutPage = About::find(1);

        return view('frontend.about_page', compact('aboutPage'));
    }

    public function aboutMultiImage()
    {
        return view('admin.about_page.multi_image');
    }


    public function storeMultiImage(Request $request)
    {
        $image = $request->file('multi_image');

        foreach ($image as $multi_image) {
            $name_gen = hexdec(uniqid()) . '.' . $multi_image->getClientOriginalExtension();

            Image::make($multi_image)->resize(220, 220)->save('storage/upload/multi/' . $name_gen);
            $save_url = 'storage/upload/multi/' . $name_gen;

            MultiImage::insert([
                'multi_image' => $save_url,
                'created_at' => Carbon::now()
            ]);
        }

        $notification = array(
            'message' => 'Berhasil menambahkan gambar halaman info!',
            'alert-type' => 'success'
        );

        return redirect()->route('all.multi.image')->with($notification);
    }

    public function allMultiImage()
    {
        $allMultiImage = MultiImage::all();

        return view('admin.about_page.all_multi_image', compact('allMultiImage'));
    }

    public function editMultiImage($id)
    {
        $multiImage = MultiImage::findOrFail($id);

        return view('admin.about_page.edit_multi_image', compact('multiImage'));
    }


    public function updateMultiImage(Request $request)
    {
        $multi_image_id = $request->id;

        if ($request->file('multi_image')) {
            $multiImg = MultiImage::findOrFail($multi_image_id);
            @unlink($multiImg->multi_image);

            $image = $request->file('multi_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(220, 220)->save('storage/upload/multi/' . $name_gen);
            $save_url = 'storage/upload/multi/' . $name_gen;

            $multiImg->update([
                'multi_image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Berhasil mengubah gambar halaman info!',
                'alert-type' => 'success'
            );

            return redirect()->route('all.multi.image')->with($notification);
        }
    }

    public function deleteMultiImage($id)
    {
        $multi = MultiImage::findOrFail($id);
        $img = $multi->multi_image;
        unlink($img);

        MultiImage::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Berhasil menghapus gambar halaman info!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
