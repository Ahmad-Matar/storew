<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use App\Http\Controllers\Controller;

use App\Http\Traits\BrandAllTrait;
use App\Http\Traits\CategoryTrait;
use App\Http\Traits\SearchTrait;
use App\Http\Traits\CartTrait;


class ProfileController extends Controller {


    use BrandAllTrait, CategoryTrait, SearchTrait, CartTrait;


    /* This page uses the Auth Middleware */
    public function __construct() {
        $this->middleware('auth');
       
        parent::__construct();
    }


    /**
     * Display Profile contents
     *
     * @return mixed
     */
    public function index() {

       
       
        $categories = $this->categoryAll();

       
       
        $brands = $this->brandsAll();

       
       
        $search = $this->search();

       
       
        $cart_count = $this->countProductsInCart();

       
        $username = \Auth::user();

       
        $user_id = $username->id;

       
        $orders = Order::where('user_id', '=', $user_id)->get();

        return view('profile.index', compact('categories', 'brands', 'search', 'cart_count', 'username', 'orders'));
    }
    

}