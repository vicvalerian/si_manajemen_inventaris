<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function destroy(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'Berhasil keluar dari Sistem Informasi Manajemen Inventaris!',
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
    }

    public function profile(){
        $id = Auth::user()->id;
        $admin = User::find($id);

        return view('admin.admin_profile_view', compact('admin'));
    }

    public function edit(){
        $id = Auth::user()->id;
        $editData = User::find($id);

        return view('admin.admin_profile_edit',compact('editData'));
    }

    public function storeProfile(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id);

        $data->name = $request->name;
        $data->email = $request->email;

        if($request->file('profile_image')) {
            if(isset($data->profile_image)){
                Storage::delete("public/".$data->profile_image);
            }
           $file = $request->file('profile_image');
           $filename = date('YmdHi').$file->getClientOriginalName();

           $uploadDoc = $file->storeAs(
                'upload/admin_images',
                $filename,
                ['disk' => 'public']
            );

           $data['profile_image'] = $uploadDoc;
        }

        $data->save();

        $notification = array(
            'message' => 'Berhasil mengubah profil admin!', 
            'alert-type' => 'info'
        );

        return redirect()->route('admin.profile')->with($notification);
    }

    public function changePassword(){
        return view('admin.admin_change_password');
    }

    public function updatePassword(Request $request){
        $validateData = $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'confirm_password' => 'required|same:newpassword',
        ], [
            'oldpassword.required' => 'Kata sandi lama tidak boleh kosong!',
            'newpassword.required' => 'Kata sandi baru tidak boleh kosong!',
            'confirm_password.required' => 'Konfirmasi kata sandi baru tidak boleh kosong!',
            'confirm_password.same' => 'Kata sandi baru tidak sama!',
        ]);

        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->oldpassword, $hashedPassword )) {
            $users = User::find(Auth::id());
            $users->password = bcrypt($request->newpassword);
            $users->save();

            session()->flash('message', 'Berhasil mengubah kata sandi!');
            return redirect()->back();
        } else{
            session()->flash('message', 'Kata sandi lama salah!');
            return redirect()->back();
        }
    }
}
