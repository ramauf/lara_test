<?php

namespace App\Http\Controllers;


use App\Order;
use App\Partner;
use App\Product;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function catalog(Request $request){
        $products = Product::with('vendors')->orderBy('name', 'asc')->paginate(25);
        $data = [];
        foreach ($products->items() as $product){
            $data[] = $product->toArray();
        }
        return view('main', [
            'products' => $data,
            'template' => 'products',
            'page' => $products->currentPage(),
            'pages' => ceil($products->total()/25)
        ]);
    }

    public function update(Request $request, $id){
        $product = Product::query()->where('id', $id)->first();
        $product->update([
            'price' => $request->post('price')
        ]);
    }
}
