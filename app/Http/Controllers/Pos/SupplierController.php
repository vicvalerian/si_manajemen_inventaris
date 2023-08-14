<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class SupplierController extends Controller
{
    public function supplierAll()
    {
        $suppliers = Supplier::latest()->get();

        return view('backend.supplier.supplier_all', compact('suppliers'));
    }

    public function supplierAdd()
    {
        return view('backend.supplier.supplier_add');
    }

    public function supplierStore(Request $request)
    {
        Supplier::insert([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Supplier Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.all')->with($notification);
    }

    public function supplierEdit($id)
    {
        $supplier = Supplier::findOrFail($id);

        return view('backend.supplier.supplier_edit', compact('supplier'));
    }

    public function supplierUpdate(Request $request)
    {
        $sullier_id = $request->id;

        Supplier::findOrFail($sullier_id)->update([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Supplier Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.all')->with($notification);
    }

    public function supplierDelete($id)
    {
        Supplier::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Supplier Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
