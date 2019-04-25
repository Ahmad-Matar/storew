<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\SubCategoryRequest;

use App\Http\Traits\CartTrait;
use App\Http\Traits\BrandAllTrait;
use App\Http\Traits\CategoryTrait;
use Illuminate\Support\Facades\Auth;


class CategoriesController extends Controller {

    use BrandAllTrait, CategoryTrait, CartTrait;


    /**
     * Return all categories with their sub-categories
     *
     * @return $this
     */
    public function showCategories() {

       
       
        $categories = $this->categoryAll();

       
       
        $cart_count = $this->countProductsInCart();

        return view('admin.category.show', compact('cart_count'))->with('categories', $categories);
    }


    /**
     * Return all Products under sub-categories
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProductsForSubCategory($id) {

       
        $categories = Category::where('id', '=', $id)->get();

       
        $products = Product::where('cat_id', '=', $id)->get();

       
        $count = Product::where('cat_id', '=', $id)->count();

       
       
        $cart_count = $this->countProductsInCart();

        return view('admin.category.show_products', compact('categories', 'products', 'count', 'cart_count'));
    }


    /**
     * Return the view for add new category
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addCategories() {

       
       
        $cart_count = $this->countProductsInCart();

        return view('admin.category.add', compact('cart_count'));
    }


    /**
     * Add a new category to database
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function addPostCategories(CategoryRequest $request) {
       
        $category = new Category($request->all());


        if (Auth::user()->id == 2) {
           
            flash()->error('Error', 'Cannot create Category because you are signed in as a test user.');
        } else {
           
            $category->save();

           
            flash()->success('Success', 'Category added successfully!');
        }

       
        return redirect()->route('admin.category.show');
    }


    /**
     * Get the view ot edit a category
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editCategories($id) {
       
        $category = Category::where('id', '=', $id)->find($id);

       
        if (!$category) {
            return redirect('admin/categories');
        }

       
       
        $cart_count = $this->countProductsInCart();

        return view('admin.category.edit', compact('category', 'cart_count'));
    }


    /**
     * Update a Category.
     *
     * @param $id
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateCategories($id, CategoryRequest $request) {
       
        $category = Category::findOrFail($id);

        if (Auth::user()->id == 2) {
           
            flash()->error('Error', 'Cannot edit Category because you are signed in as a test user.');
        } else {
           
            $category->update($request->all());
           
            flash()->success('Success', 'Category updated successfully!');
        }

       
        return redirect()->route('admin.category.show');
    }


    /**
     * Delete a Category
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCategories($id) {
       
        $delete = Category::findOrFail($id);

       
        $sub_category = Category::where('parent_id', '=', $id)->count();

       
       
       
        if ($sub_category > 0) {
           
            flash()->customErrorOverlay('Error', 'There are sub-categories under this parent category. Cannot delete this category until all sub-categories under this parent category are deleted');
        } elseif (Auth::user()->id == 2) {
           
            flash()->error('Error', 'Cannot delete Category because you are signed in as a test user.');
        } else {
            $delete->delete();
        }

       
        return redirect()->back();
    }


    /************************************ ****Sub-Categories below ****************************************************/


    /**
     * Return the view for add new sub category
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addSubCategories($id) {

        $category = Category::findOrFail($id);

       
       
        $cart_count = $this->countProductsInCart();

        return view('admin.category.addsub', compact('category', 'cart_count'));
    }


    /**
     * Add a sub category to a parent category
     *
     * @param $id
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addPostSubCategories($id, SubCategoryRequest $request) {

       
        $category = Category::findOrFail($id);

       
        $subcategory = new Category($request->all());

        if (Auth::user()->id == 2) {
           
            flash()->error('Error', 'Cannot create Sub-Category because you are signed in as a test user.');
        } else {
           
            $category->children()->save($subcategory);

           
            flash()->success('Success', 'Sub-Category added successfully!');
        }

       
        return redirect()->route('admin.category.show');
    }


    /**
     * Get the view ot edit a sub-category
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editSubCategories($id) {
       
        $category = Category::where('id', '=', $id)->find($id);

       
        if (!$category) {
            return redirect('admin/categories');
        }

       
       
        $cart_count = $this->countProductsInCart();

        return view('admin.category.editsub', compact('category', 'cart_count'));
    }


    /**
     * Update a Sub-Category.
     *
     * @param $id
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateSubCategories($id, SubCategoryRequest $request) {
       
        $category = Category::findOrFail($id);

        if (Auth::user()->id == 2) {
           
            flash()->error('Error', 'Cannot edit Sub-Category because you are signed in as a test user.');
        } else {
           
            $category->update($request->all());

           
            flash()->success('Success', 'Sub-Category updated successfully!');
        }

       
        return redirect()->route('admin.category.show');
    }

    /**
     * Delete a Sub-Category
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteSubCategories($id) {

       
        $delete_sub = Category::findOrFail($id);

       
        $products = Product::where('cat_id', '=', $id)->count();


       
       
       
        if ($products > 0) {
           
            flash()->customErrorOverlay('Error', 'There are products under this sub-category. Cannot delete this sub-category until all products under this sub-category are deleted');
        } elseif (Auth::user()->id == 2) {
           
            flash()->error('Error', 'Cannot delete Sub-Category because you are signed in as a test user.');
        } else {
            $delete_sub->delete();
        }


       
        return redirect()->back();
    }

}