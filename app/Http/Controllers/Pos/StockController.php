<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function stockReport()
    {
        $allData = Product::orderBy('supplier_id', 'asc')->orderBy('category_id', 'asc')->get();
        return view('backend.stock.stock_report', compact('allData'));
    }

    public function stockReportPdf()
    {
        $allData = Product::orderBy('supplier_id', 'asc')->orderBy('category_id', 'asc')->get();
        return view('backend.pdf.stock_report_pdf', compact('allData'));
    }

    public function stockSupplierWise()
    {
        $supppliers = Supplier::all();
        $category = Category::all();
        return view('backend.stock.supplier_product_wise_report', compact('supppliers', 'category'));
    }

    public function supplierWisePdf(Request $request)
    {
        $supplier = Supplier::where('id', $request->supplier_id)->first();
        $allData = Product::orderBy('supplier_id', 'asc')->orderBy('category_id', 'asc')->where('supplier_id', $request->supplier_id)->get();
        return view('backend.pdf.supplier_wise_report_pdf', compact('allData', 'supplier'));
    }
}
