<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = 'categories';

    protected $fillable = ['category'];

 


    /**
     * One sub category, belongs to a Main Category ( Or Parent Category ).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent() {
        return $this->belongsTo('App\Category', 'parent_id');
    }


    /**
     * A Parent Category has many sub categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children() {
        return $this->hasMany('App\Category', 'parent_id');
    }


    /**
     * One Category can have many Products.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product() {
        return $this->hasMany('App\Product', 'id');
    }


    /**
     * Delete all sub categories when Main (Parent) category is deleted.
     */
    public static function boot() {
       
        parent::boot();

      
       
       
       
       

        Category::deleting(function($category) {
            foreach($category->children as $subcategory){
                $subcategory->delete();
            }
        });
    }


}