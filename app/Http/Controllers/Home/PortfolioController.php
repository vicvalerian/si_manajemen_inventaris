<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Image;

class PortfolioController extends Controller
{
    public function allPortfolio()
    {
        $portfolio = Portfolio::latest()->get();
        return view('admin.portfolio.portfolio_all', compact('portfolio'));
    }

    public function addPortfolio()
    {
        return view('admin.portfolio.portfolio_add');
    }


    public function storePortfolio(Request $request)
    {
        $request->validate([
            'portfolio_name' => 'required',
            'portfolio_title' => 'required',
            'portfolio_description' => 'required',
            'portfolio_image' => 'required',

        ], [
            'portfolio_name.required' => 'Nama portofolio tidak boleh kosong!',
            'portfolio_title.required' => 'Judul portofolio tidak boleh kosong!',
            'portfolio_description.required' => 'Deskripsi portofolio tidak boleh kosong!',
            'portfolio_image.required' => 'Thumbnail portofolio tidak boleh kosong!',
        ]);

        $image = $request->file('portfolio_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

        Image::make($image)->resize(1020, 519)->save('storage/upload/portfolio/' . $name_gen);
        $save_url = 'storage/upload/portfolio/' . $name_gen;

        Portfolio::insert([
            'portfolio_name' => $request->portfolio_name,
            'portfolio_title' => $request->portfolio_title,
            'portfolio_description' => $request->portfolio_description,
            'portfolio_image' => $save_url,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Berhasil menambahkan portofolio!',
            'alert-type' => 'success'
        );

        return redirect()->route('all.portfolio')->with($notification);
    }

    public function editPortfolio($id)
    {

        $portfolio = Portfolio::findOrFail($id);
        return view('admin.portfolio.portfolio_edit', compact('portfolio'));
    }


    public function updatePortfolio(Request $request)
    {
        $portfolio_id = $request->id;
        $portfolio = Portfolio::findOrFail($portfolio_id);
        if ($request->file('portfolio_image')) {
            $image = $request->file('portfolio_image');
            @unlink($portfolio->portfolio_image);

            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(1020, 519)->save('storage/upload/portfolio/' . $name_gen);
            $save_url = 'storage/upload/portfolio/' . $name_gen;

            $portfolio->update([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
                'portfolio_image' => $save_url,

            ]);
            $notification = array(
                'message' => 'Berhasil mengubah portofolio dengan gambar!',
                'alert-type' => 'success'
            );

            return redirect()->route('all.portfolio')->with($notification);
        } else {
            $portfolio->update([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,


            ]);
            $notification = array(
                'message' => 'Berhasil mengubah portofolio tanpa gambar!',
                'alert-type' => 'success'
            );

            return redirect()->route('all.portfolio')->with($notification);
        }
    }

    public function deletePortfolio($id)
    {

        $portfolio = Portfolio::findOrFail($id);
        $img = $portfolio->portfolio_image;
        unlink($img);

        Portfolio::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Berhasil menghapus portofolio!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function PortfolioDetails($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        return view('frontend.portfolio_details', compact('portfolio'));
    }
}
