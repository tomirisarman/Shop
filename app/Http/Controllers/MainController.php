<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function React\Promise\reduce;

class MainController extends Controller
{
    public function shopMenu(){
        $parentCats = Category::where('parent_id', null)->get();
        return view('welcome', compact( 'parentCats'));
    }
    public function viewCart(){
        $cart = session()->get('cart');
        if(!isset($cart)){
            return view('cart');
        }
        $sum = 0;
        foreach($cart as $item){
            $sum += $item['price']*$item['quantity'];
        }
        return view('cart', compact('cart', 'sum'));
    }
    public function addToCart($id){

        $product = Product::find($id);
        if(!$product) {
            abort(404);
        }
        $cart = session()->get('cart');

        // if cart is empty then this the first product
        if(!$cart) {
            $cart = [
                $id => [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,
                ]
            ];
            session()->put('cart_quantity', 1);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }

        $cart_quantity = 1;
        foreach ($cart as $item){
            $cart_quantity += $item['quantity'];
        }
        session()->put('cart_quantity', $cart_quantity);

        // if cart not empty then check if this product exist then increment quantity
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }

        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
        ];

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
    public function removeFromCart($id){
        $product = Product::find($id);
        if(!$product) {
            abort(404);
        }
        $cart = session()->get('cart');

        // if cart not empty then check if this product exist
        if(isset($cart[$id])) {
            $cart[$id]['quantity']--;
            if($cart[$id]['quantity'] <= 0){
                unset($cart[$id]);
            }
            session()->put('cart', $cart);

            $cart_quantity = 0;
            foreach ($cart as $item){
                $cart_quantity += $item['quantity'];
            }
            session()->put('cart_quantity', $cart_quantity);

            return redirect()->back()->with('success', 'Product removed from cart successfully!');
        }

        return redirect()->back()->with('success', 'There is no such product in the cart yet');
    }

    public function createOrder(Request $request, $hasAccount = null){
        if(!Auth::check()){
            session()->put('url.intended', url()->previous());
            return view('auth.login');
        }
        $order = new Order;
        $order->user_id = Auth::id();
        $order->address = $request->address;
        $order->save();

        $cart = session()->get('cart');
        foreach ($cart as $key => $val){
            $item = new Item;
            $item->order_id = $order->id;
            $item->product_id = $key;
            $item->quantity = $val['quantity'];
            $item->save();
        }
        session()->forget('cart');
        return view('home');
    }

    public function redirectLoginRegister($hasAccount){
        if($hasAccount == True){
            session()->put('url.intended', url()->previous());
            return view('auth.login');
        }elseif ($hasAccount == False){
            session()->put('url.intended', url()->previous());
            return view('auth.register');
        }else{
            return redirect()->back();
        }
    }
}
