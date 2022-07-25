<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        return view('cart');
    }



    public function addCart(Request $request)
    {
        $product_id = $request->input('product_id');
        $jumlah_product = $request->input('jumlah_product');

        if (Auth::check()) {
            $product = Product::where('id', $product_id)->first();
            if ($product) {
                if (Cart::where('product_id', $product_id)->where('user_id', Auth::id())->exists()) {
                    return response()->json(['status' => $product->nama." Already Add To Cart"]);
                }
                else {
                    $cart = new Cart();
                    $cart->product_id = $product_id;
                    $cart->user_id = Auth::id();
                    $cart->jumlah_product = $jumlah_product;
                    $cart->save();
                    return response()->json(['status' => $product->nama." Add To Cart"]);
                }
            }
        }
        else {
            return response()->json(['status' => "Login to Continue"]);
            
        }
    }
}
