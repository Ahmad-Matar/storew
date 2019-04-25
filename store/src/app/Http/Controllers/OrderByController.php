<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Traits\BrandAllTrait;
use App\Http\Traits\CategoryTrait;
use App\Http\Traits\SearchTrait;
use App\Http\Traits\CartTrait;


class OrderByController extends ProductsController {

    use BrandAllTrait, CategoryTrait, SearchTrait, CartTrait;


    /****************** Order By for Category Section *****************************************************************/


    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsPriceHighest($id, Product $product) {

       
        $categories = Category::where('id', '=', $id)->get();

       
       
        $category = $this->categoryAll();

       
       
        $brands = $this->brandsAll();

       
       
        $search = $this->search();

       
        $products = Product::orderBy('price', 'desc')->where('cat_id', '=', $id)->paginate(15);

       
        $count = $products->count();

       
       
        $cart_count = $this->countProductsInCart();

        return view('category.show', ['products' => $products], compact('categories', 'category', 'brands', 'search', 'count', 'cart_count'));
    }


    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsPriceLowest($id, Product $product) {

       
        $categories = Category::where('id', '=', $id)->get();

       
       
        $category = $this->categoryAll();

       
       
        $brands = $this->brandsAll();

       
       
        $search = $this->search();

       
        $products = Product::orderBy('price', 'asc')->where('cat_id', '=', $id)->paginate(15);

       
        $count = $products->count();

       
       
        $cart_count = $this->countProductsInCart();

        return view('category.show', ['products' => $products], compact('categories', 'category', 'brands', 'search', 'count', 'cart_count'));
    }



    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsAlphaHighest($id, Product $product) {

       
        $categories = Category::where('id', '=', $id)->get();

       
       
        $category = $this->categoryAll();

       
       
        $brands = $this->brandsAll();

       
       
        $search = $this->search();

       
        $products = Product::orderBy('product_name', 'desc')->where('cat_id', '=', $id)->paginate(15);

       
        $count = $products->count();

       
       
        $cart_count = $this->countProductsInCart();

        return view('category.show', ['products' => $products], compact('categories', 'category', 'brands', 'search', 'count', 'cart_count'));
    }


    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsAlphaLowest($id, Product $product) {

       
        $categories = Category::where('id', '=', $id)->get();

       
       
        $category = $this->categoryAll();

       
       
        $brands = $this->brandsAll();

       
       
        $search = $this->search();

       
        $products = Product::orderBy('product_name', 'asc')->where('cat_id', '=', $id)->paginate(15);

       
        $count = $products->count();

       
       
        $cart_count = $this->countProductsInCart();

        return view('category.show', ['products' => $products], compact('categories', 'category', 'brands','search', 'count', 'cart_count'));
    }


    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsNewest($id, Product $product) {

       
        $categories = Category::where('id', '=', $id)->get();

       
       
        $category = $this->categoryAll();

       
       
        $brands = $this->brandsAll();

       
       
        $search = $this->search();

       
        $products = Product::orderBy('created_at', 'desc')->where('cat_id', '=', $id)->paginate(15);

       
        $count = $products->count();

       
       
        $cart_count = $this->countProductsInCart();

        return view('category.show', ['products' => $products], compact('categories', 'category', 'brands', 'search', 'count', 'cart_count'));
    }




    /****************** Order By for Brands Section *******************************************************************/


    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsPriceHighestBrand($id, Product $product) {

       
        $brands = Brand::where('id', '=', $id)->get();

       
       
        $categories = $this->categoryAll();

       
       
        $brand = $this->brandsAll();

       
       
        $search = $this->search();

        $products = Product::orderBy('price', 'desc')->where('brand_id', '=', $id)->paginate(15);

       
        $count = $products->count();

       
       
        $cart_count = $this->countProductsInCart();

        return view('brand.show', ['products' => $products], compact('brands', 'brand', 'categories', 'search', 'count', 'cart_count'));
    }


    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsPriceLowestBrand($id, Product $product) {


       
        $brands = Brand::where('id', '=', $id)->get();

       
       
        $categories = $this->categoryAll();

       
       
        $brand = $this->brandsAll();

       
       
        $search = $this->search();

        $products = Product::orderBy('price', 'asc')->where('brand_id', '=', $id)->paginate(15);

       
        $count = $products->count();

       
       
        $cart_count = $this->countProductsInCart();

        return view('brand.show', ['products' => $products], compact('brands', 'categories', 'brand', 'search', 'count', 'cart_count'));
    }



    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsAlphaHighestBrand($id, Product $product) {

       
        $brands = Brand::where('id', '=', $id)->get();

       
       
        $categories = $this->categoryAll();

       
       
        $brand = $this->brandsAll();

       
       
        $search = $this->search();

        $products = Product::orderBy('product_name', 'desc')->where('brand_id', '=', $id)->paginate(15);

       
        $count = $products->count();

       
       
        $cart_count = $this->countProductsInCart();

        return view('brand.show', ['products' => $products], compact('brands', 'categories', 'brand', 'search', 'count', 'cart_count'));
    }


    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsAlphaLowestBrand($id, Product $product) {

       
        $brands = Brand::where('id', '=', $id)->get();

       
       
        $categories = $this->categoryAll();

       
       
        $brand = $this->brandsAll();

       
       
        $search = $this->search();

        $products = Product::orderBy('product_name', 'asc')->where('brand_id', '=', $id)->paginate(15);

       
        $count = $products->count();

       
       
        $cart_count = $this->countProductsInCart();

        return view('brand.show', ['products' => $products], compact('brands', 'categories', 'brand', 'search', 'count', 'cart_count'));
    }


    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function productsNewestBrand($id, Product $product) {

       
        $brands = Brand::where('id', '=', $id)->get();

       
       
        $categories = $this->categoryAll();

       
       
        $brand = $this->brandsAll();

       
       
        $search = $this->search();

        $products = Product::orderBy('created_at', 'desc')->where('brand_id', '=', $id)->paginate(15);

       
        $count = $products->count();

       
       
        $cart_count = $this->countProductsInCart();

        return view('brand.show', ['products' => $products], compact('brands', 'category', 'brand', 'search', 'count', 'cart_count'));
    }


}