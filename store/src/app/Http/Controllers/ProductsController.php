<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductEditRequest;

use App\Http\Traits\BrandAllTrait;
use App\Http\Traits\CategoryTrait;
use App\Http\Traits\SearchTrait;
use App\Http\Traits\CartTrait;


class ProductsController extends Controller {

    use BrandAllTrait, CategoryTrait, SearchTrait, CartTrait;


    /**
     * Show all products
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProducts() {

       
        $product = Product::latest('created_at')->paginate(10);

       
        $productCount = Product::all()->count();

       
       
        $cart_count = $this->countProductsInCart();

        return view('admin.product.show', compact('productCount', 'product', 'cart_count'));
    }


    /**
     * Return the view for add new product
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addProduct() {
       
       
        $categories = $this->parentCategory();

       
       
        $brands = $this->brandsAll();

       
       
        $cart_count = $this->countProductsInCart();

        return view('admin.product.add', compact('categories', 'brands', 'cart_count'));
    }


    /**
     * Add a new product into the Database.
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addPostProduct(ProductRequest $request) {

       
        $featured = Input::has('featured') ? true : false;

       
        $product_name =  str_replace("/", " " ,$request->input('product_name'));


      
           
       
      
           
            $product = Product::create([
                'product_name' => $product_name,
                'product_qty' => $request->input('product_qty'),
                'product_sku' => $request->input('product_sku'),
                'price' => $request->input('price'),
                'reduced_price' => $request->input('reduced_price'),
                'cat_id' => $request->input('cat_id'),
                'brand_id' => $request->input('brand_id'),
                'featured' => $featured,
                'description' => $request->input('description'),
                'product_spec' => $request->input('product_spec'),
            ]);

           
            $product->save();

           
            flash()->success('Success', 'Product created successfully!');
      


       
        return redirect()->route('admin.product.show');
    }


    /**
     * This method will fire off when a admin chooses a parent category.
     * It will get the option and check all the children of that parent category,
     * and then list them in the sub-category drop-down.
     *
     * @return \Illuminate\Http\Response
     */
    public function categoryAPI() {
       
        $input = Input::get('option');

       
        $category = Category::find($input);

       
       
        $subcategory = $category->children();

       
        return \Response::make($subcategory->get(['id', 'category']));
    }


    /**
     * Return the view to edit & Update the Products
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editProduct($id) {

       
        $product = Product::where('id', '=', $id)->find($id);

       
        if (!$product) {
            return redirect('admin/products');
        }

       
       
        $categories = $this->parentCategory();

       
       
        $brands = $this->BrandsAll();

       
       
        $cart_count = $this->countProductsInCart();

       
        return view('admin.product.edit', compact('product', 'categories', 'brands', 'cart_count'));

    }


    /**
     * Update a Product
     *
     * @param $id
     * @param ProductEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProduct($id, ProductEditRequest $request) {

       
        $featured = Input::has('featured') ? true : false;

       
        $product = Product::findOrFail($id);


        if (Auth::user()->id == 2) {
           
            flash()->error('Error', 'Cannot edit Product because you are signed in as a test user.');
        } else {
           
            $product->update(array(
                'product_name' => $request->input('product_name'),
                'product_qty' => $request->input('product_qty'),
                'product_sku' => $request->input('product_sku'),
                'price' => $request->input('price'),
                'reduced_price' => $request->input('reduced_price'),
                'cat_id' => $request->input('cat_id'),
                'brand_id' => $request->input('brand_id'),
                'featured' => $featured,
                'description' => $request->input('description'),
                'product_spec' => $request->input('product_spec'),
            ));


           
            $product->update($request->all());

           
            flash()->success('Success', 'Product updated successfully!');
        }

       
        return redirect()->route('admin.product.show');
    }


    /**
     * Delete a Product
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteProduct($id) {

        if (Auth::user()->id == 2) {
           
            flash()->error('Error', 'Cannot delete Product because you are signed in as a test user.');
        } else {
           
            Product::findOrFail($id)->delete();
        }

       
        return redirect()->back();
    }


    /**
     * Display the form for uploading images for each Product
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function displayImageUploadPage($id) {

       
        $product = Product::where('id', '=', $id)->get();

       
       
        $cart_count = $this->countProductsInCart();

        return view('admin.product.upload', compact('product', 'cart_count'));
    }


    /**
     * Show a Product in detail
     *
     * @param $product_name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($product_name) {

       
        $product = Product::ProductLocatedAt($product_name);

       
       
        $search = $this->search();

       
       
        $categories = $this->categoryAll();

       
        $brands = $this->BrandsAll();

       
       
        $cart_count = $this->countProductsInCart();


        $similar_product = Product::where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                $query->where('brand_id', '=', $product->brand_id)
                    ->orWhere('cat_id', '=', $product->cat_id);
            })->get();

        return view('pages.show_product', compact('product', 'search', 'brands', 'categories', 'similar_product', 'cart_count'));
    }


}