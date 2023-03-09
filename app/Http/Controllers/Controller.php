<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function product_search(Request $request)
    {
        $products = [];

        if($request->has('q')){
            $search = $request->q;
            $products =Product::select("id", "name")
            		->where('name', 'LIKE', "%$search%")
            		->get();
        }
        return response()->json($products);
    }

    function category_search(Request $request)
    {
        $category = [];

        if($request->has('q')){
            $search = $request->q;
            $category =Category::select("id", "name")
            		->where('name', 'LIKE', "%$search%")
            		->get();
        }
        return response()->json($category);
    }

    function customer_search(Request $request)
    {
        $customers = [];

        if($request->has('q')){
            $search = $request->q;
            $customers =Customer::select("id", "name")
            		->where('name', 'LIKE', "%$search%")
            		->get();
        }
        return response()->json($customers);
    }
}
