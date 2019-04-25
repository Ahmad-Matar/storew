<?php 

namespace App\Http\Controllers;

use App\Product;
use App\ProductPhoto;
use App\AddPhotoToProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\ProductPhotoRequest;

class ProductPhotosController extends Controller {


    /**
     * @param $id
     * @param ProductPhotoRequest $request
     */
    public function store($id, ProductPhotoRequest $request) {
       
       
        $product = Product::LocatedAt($id);

       
       
        $photo = $request->file('photo');

       
        (new AddPhotoToProduct($product, $photo))->save();
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id) {
       
        ProductPhoto::findOrFail($id)->delete();
       
        return back();
    }


    /**
     * Store and update the featured photo for a product
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeFeaturedPhoto($id, Request $request) {
       
        $this->validate($request, [
            'featured' => 'required|exists:product_images,id'
        ]);

       
        $featured = Input::get('featured');

       
        ProductPhoto::where('product_id', '=', $id)->update(['featured' => 0]);

       
        ProductPhoto::findOrFail($featured)->update(['featured' => 1]);


       
        return redirect()->back();
    }


}