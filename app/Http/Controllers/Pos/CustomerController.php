<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Image;
use Auth;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function customerAll()
    {
        $customers = Customer::latest()->get();
        return view('backend.customer.customer_all', compact('customers'));
    }

    public function customerAdd()
    {
        return view('backend.customer.customer_add');
    }

    public function customerStore(Request $request)
    {
        $image = $request->file('customer_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 343434.png
        Image::make($image)->resize(200, 200)->save('storage/upload/customer/' . $name_gen);
        $save_url = 'storage/upload/customer/' . $name_gen;

        Customer::insert([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'customer_image' => $save_url,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Customer Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('customer.all')->with($notification);
    }

    public function customerEdit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('backend.customer.customer_edit', compact('customer'));
    }


    public function customerUpdate(Request $request)
    {
        $customer_id = $request->id;
        $customer = Customer::findOrFail($customer_id);
        if ($request->file('customer_image')) {
            @unlink($customer->customer_image);

            $image = $request->file('customer_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 343434.png
            Image::make($image)->resize(200, 200)->save('storage/upload/customer/' . $name_gen);
            $save_url = 'storage/upload/customer/' . $name_gen;

            $customer->update([
                'name' => $request->name,
                'mobile_no' => $request->mobile_no,
                'email' => $request->email,
                'address' => $request->address,
                'customer_image' => $save_url,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Customer Updated with Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('customer.all')->with($notification);
        } else {

            $customer->update([
                'name' => $request->name,
                'mobile_no' => $request->mobile_no,
                'email' => $request->email,
                'address' => $request->address,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Customer Updated without Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('customer.all')->with($notification);
        }
    }

    public function customerDelete($id)
    {
        $customers = Customer::findOrFail($id);
        $img = $customers->customer_image;
        unlink($img);

        Customer::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Customer Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
