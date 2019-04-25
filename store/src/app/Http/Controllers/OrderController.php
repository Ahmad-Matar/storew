<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Order;
use Validator;
use App\Product;
use Stripe\Stripe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller as BaseController;

use App\Http\Traits\BrandAllTrait;
use App\Http\Traits\CategoryTrait;
use App\Http\Traits\SearchTrait;
use App\Http\Traits\CartTrait;


class OrderController extends Controller {

    
    use BrandAllTrait, CategoryTrait, SearchTrait, CartTrait;


    /**
     * Show products in Order view
     * 
     * @return mixed
     */
    public function index() {

       
       
        $search = $this->search();

       
       
        $categories = $this->categoryAll();

       
        $brands = $this->BrandsAll();

       
       
        $cart_count = $this->countProductsInCart();

       
        $user_id = Auth::user()->id;

       
        $check_cart = Cart::with('products')->where('user_id', '=', $user_id)->count();

       
        $count = Cart::where('user_id', '=', $user_id)->count();

       
       
        if (!$check_cart) {
            return redirect()->route('cart');
        }

       
       
        $cart_products = Cart::with('products')->where('user_id', '=', $user_id)->get();

       
        $cart_total = Cart::with('products')->where('user_id', '=', $user_id)->sum('total');

        return view('cart.checkout', compact('search', 'categories', 'brands', 'cart_count', 'count'))
            ->with('cart_products', $cart_products)
            ->with('cart_total', $cart_total);
    }


    /**
     * Make the order when user enters all credentials
     * 
     * @param Request $request
     * @return mixed
     */
    public function postOrder(Request $request) {

       
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:30|min:2',
            'last_name'  => 'required|max:30|min:2',
            'address'    => 'required|max:50|min:4',
            'address_2'  => 'max:50|min:4',
            'city'       => 'required|max:50|min:3',
            'state'      => 'required|',
            'zip'        => 'required|max:11|min:4',
            'full_name'  => 'required|max:30|min:2',
        ]);


       
        if ($validator->fails()) {
            return redirect('/checkout')
                ->withErrors($validator)
                ->withInput();
        }

       
        Stripe::setApiKey('sk_test_GCg39sQwY20Pbp3b81v3hr91');

       
        $first_name = Input::get('first_name');
        $last_name = Input::get('last_name');
        $address = Input::get('address');
        $address_2 = Input::get('address_2');
        $city = Input::get('city');
        $state = Input::get('state');
        $zip = Input::get('zip');
        $full_name = Input::get('full_name');

       
        $user_id = Auth::user()->id;

       
       
        $cart_products = Cart::with('products')->where('user_id', '=', $user_id)->get();

       
       
       
        $cart_total = Cart::with('products')->where('user_id', '=', $user_id)->sum('total');

       
        $charge_amount = number_format($cart_total, 2) * 100;

        
       
        try {
            $charge = \Stripe\Charge::create(array(
                'source' => "tok_visa",
                'amount' => $charge_amount,
                'currency' => 'usd',
            ));

        } catch(\Stripe\Error\Card $e) {
           
            echo $e;
        }


       
        $order = Order::create (
            array(
                'user_id'    => $user_id,
                'first_name' => $first_name,
                'last_name'  => $last_name,
                'address'    => $address,
                'address_2'  => $address_2,
                'city'       => $city,
                'state'      => $state,
                'zip'        => $zip,
                'total'      => $cart_total,
                'full_name'  => $full_name,
            ));

       
        foreach ($cart_products as $order_products) {
            $order->orderItems()->attach($order_products->product_id, array(
                'qty'    => $order_products->qty,
                'price'  => $order_products->products->price,
                'reduced_price'  => $order_products->products->reduced_price,
                'total'  => $order_products->products->price * $order_products->qty,
                'total_reduced'  => $order_products->products->reduced_price * $order_products->qty,
            ));
        }


       
        \DB::table('products')->decrement('product_qty', $order_products->qty);

        
       
        Cart::where('user_id', '=', $user_id)->delete();
        
       
        flash()->success('Success', 'Your order was processed successfully.');

        return redirect()->route('cart');

    }
    

}