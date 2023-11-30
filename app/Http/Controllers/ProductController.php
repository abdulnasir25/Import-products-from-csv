<?php

namespace App\Http\Controllers;

use App\Facades\ProductFacade;
use App\Jobs\ImportProductsJob;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function importProducts(Request $request) {
        // $request->validate([
        //     'csv_file' => 'required|mimes:csv'
        // ]);

        $csvFilePath = $request->file('csv_file')->storeAs('csv-imports', 'products.csv');

        ProductFacade::checkAndDispatch($csvFilePath);

        return redirect()->back()->with('success', 'Products import job dispatched successfully!');
    }
}
