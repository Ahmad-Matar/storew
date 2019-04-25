<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use App\Http\Traits\BrandAllTrait;
use App\Http\Traits\CategoryTrait;
use App\Http\Traits\CartTrait;


class QueryController extends Controller {

    use BrandAllTrait, CategoryTrait, CartTrait;


    /**
     * Search for items in our e-commerce store
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search() {

       
       
        $categories = $this->categoryAll();

       
       
        $brands = $this->brandsAll();

       
       
        $cart_count = $this->countProductsInCart();

       
        $query = Input::get('search');

       
       
        $search = Product::where('product_name', 'LIKE', '%' . $query . '%')->paginate(200);

       
        if ($search->isEmpty()) {
            flash()->info('Not Found', 'No search results found.');
            return redirect('/');
        }

       
        return view('pages.search', compact('search', 'query', 'categories', 'brands', 'cart_count'));
    }


}