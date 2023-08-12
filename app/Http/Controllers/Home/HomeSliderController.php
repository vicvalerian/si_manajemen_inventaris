<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\HomeSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

class HomeSliderController extends Controller
{
    public function homeSlider(){
        $homeSlide = HomeSlide::find(1);

        return view('admin.home_slide.home_slide_all', compact('homeSlide'));
    }

    public function updateSlider(Request $request){
        $slide_id = $request->id;
        $homeSlide = HomeSlide::findOrFail($slide_id);

        if ($request->file('home_slide')) {
            if (isset($homeSlide->home_slide)) {
                Storage::delete("public/" . $homeSlide->home_slide);
            }

            $image = $request->file('home_slide');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(636,852)->save('storage/upload/home_slide/'.$name_gen);
            $save_url = 'storage/upload/home_slide/'.$name_gen;

            $homeSlide->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'video_url' => $request->video_url,
                'home_slide' => $save_url,

            ]);
            $notification = array(
                'message' => 'Berhasil mengubah home slide dengan gambar!',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        } else {
            $homeSlide->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'video_url' => $request->video_url,
            ]);

            $notification = array(
                'message' => 'Berhasil mengubah home slide tanpa gambar!',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
    }
}
