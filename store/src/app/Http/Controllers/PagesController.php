<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Brand;
use App\Product;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use App\Http\Traits\BrandAllTrait;
use App\Http\Traits\CategoryTrait;
use App\Http\Traits\SearchTrait;
use App\Http\Traits\CartTrait;


class PagesController extends Controller {

    use BrandAllTrait, CategoryTrait, SearchTrait, CartTrait;


    /**
     * Display things for main index home page.
     *
     * @return $this
     */
    public function index() {

        $categories = $this->categoryAll();

       
       
        $brands = $this->brandsAll();

       
       
        $search = $this->search();

       
       
        $cart_count = $this->countProductsInCart();

       
       
        $products = Product::where('featured', '=', 1)->orderByRaw('RAND()')->take(4)->get();

        $rand_brands = Brand::orderByRaw('RAND()')->take(6)->get();

       
       
        $new = Product::orderBy('created_at', 'desc')->where('featured', '=', 0)->orderByRaw('RAND()')->take(4)->get();


        return view('pages.index', compact('products', 'brands', 'search', 'new', 'cart_count', 'rand_brands'))->with('categories', $categories);
    }


    /**
     * Display Products by Category.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function displayProducts($id) {

       
        $categories = Category::where('id', '=', $id)->get();

        $categories_find = Category::where('id', '=', $id)->find($id);

       
        if (!$categories_find) {
            return redirect('/');
        }

       
       
        $category = $this->categoryAll();

       
       
        $brands = $this->brandsAll();

       
       
        $search = $this->search();

       
        $products = Product::where('cat_id','=', $id)->get();

       
        $count = $products->count();

       
       
        $cart_count = $this->countProductsInCart();

        return view('category.show', compact('products', 'categories','brands', 'category', 'search', 'cart_count'))->with('count', $count);
    }


    /** Display Products by Brand
     *
     * @param $id
     * @return $this
     */
    public function displayProductsByBrand($id) {

       
        $brands = Brand::where('id', '=', $id)->get();

        $brands_find = Brand::where('id', '=', $id)->find($id);

       
        if (!$brands_find) {
            return redirect('/');
        }

       
       
        $categories  = $this->categoryAll();

       
       
        $brand = $this->brandsAll();

       
       
        $search = $this->search();

       
        $products = Product::where('brand_id', '=', $id)->get();

       
        $count = $products->count();

       
       
        $cart_count = $this->countProductsInCart();

        return view('brand.show', compact('products', 'brands', 'brand', 'categories', 'search', 'cart_count'))->with('count', $count);
    }

}