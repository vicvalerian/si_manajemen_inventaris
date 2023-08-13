<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function Contact()
    {
        return view('frontend.contact');
    }

    public function StoreMessage(Request $request)
    {
        Contact::insert([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'phone' => $request->phone,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Berhasil menambahkan pesan, silahkan menunggu balasan!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function contactMessage()
    {
        $contacts = Contact::latest()->get();

        return view('admin.contact.allcontact', compact('contacts'));
    }

    public function deleteMessage($id)
    {
        Contact::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Berhasil menghapus pesan!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
