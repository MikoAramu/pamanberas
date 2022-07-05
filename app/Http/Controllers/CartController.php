<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $carts = Cart::with(['product.galleries', 'user'])
                        ->where('users_id', Auth::user()
                        ->id_user)->get();

        $user = Auth::user();
        
        return view('pages.cart',[
            'carts' => $carts,
            'user' => $user,
        ]);
    }

    public function update(Request $request, $id){
        $cart = Cart::where('id_cart', $id);
        $cart->update([
            'quantity' => $request->quantity
        ]);
    }

    public function delete(Request $request, $id)
    {
        Cart::where('id_cart', $id)->delete();

        return redirect()->route('cart');
    }

    public function success()
    {
        return view('pages.success');
    }
}
