<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $guard = 'products';

    protected $fillable = [
        'category_id', 'section_id', 'product_name', 'product_code', 'product_color', 'product_price', 'product_discount','product_weight','product_video','main_image','description','wash_care','fabric','pattern','sleeve','fit','occasion','meta_title','meta_description','meta_keywords','is_featured','status'
    ];


    public function category()
    {
    	return $this->belongsTo('App\Category', 'category_id');
    }

    public function section()
    {
    	return $this->belongsTo('App\Section', 'section_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand', 'brand_id');
    }

    public function attributes()
    {
    	return $this->hasMany('App\ProductsAttribute', 'product_id');
    }

    public function images()
    {
        return $this->hasMany('App\ProductsImage', 'product_id');
    }

    public function scopeIsfeatured($query)
    {
        return $query->where('is_featured', 'Yes');
    }

    public function scopeStatus($query)
    {
        return $query->where('status', 1);
    }

    public static function productFilters()
    {
        //product brand Filter
        $productFilters['fabricArray'] = array('Cotton','Polyester','Wool');
        $productFilters['sleeveArray'] = array('Full Sleeve','Half Sleeve','Short Sleeve','Sleeveless');
        $productFilters['patternArray'] = array('Checked','Plain','Printed','Self','Solid');
        $productFilters['fitArray'] = array('Regular','Slim');
        $productFilters['occasionArray'] = array('Casual','Formal');

        return $productFilters;
    }

    public static function getDiscountPrice($product_id)
    {
        $proDetails = Product::select('product_price','product_discount','category_id')->where('id',$product_id)->first()->toArray();
        // echo "<pre>"; print_r($proDetails); die;
        $catDetails = Category::select('category_discount')->where('id',$proDetails['category_id'])->first()->toArray();

        if($proDetails['product_discount']>0){
            //if product discount is added from admin panel
            $discount_price = $proDetails['product_price'] - ($proDetails['product_price']*$proDetails['product_discount']/100);
        }else if($catDetails['category_discount']>0){
            //if product discount is not added and category discount is added from admin panel
            $discount_price = $proDetails['product_price'] - ($proDetails['product_price']*$catDetails['category_discount']/100);
        }else{
            $discount_price = 0;
        }
        return $discount_price;
    }

    public static function getDiscountAttriPrice($product_id,$size)
    {
        $proAttriPrice = ProductsAttribute::where(['product_id'=>$product_id,'size'=>$size])->first()->toArray();

        $proDetails = Product::select('product_discount','category_id')->where('id',$product_id)->first()->toArray();
        // echo "<pre>"; print_r($proDetails); die;
        $catDetails = Category::select('category_discount')->where('id',$proDetails['category_id'])->first()->toArray();

        if($proDetails['product_discount']>0){
            //if product discount is added from admin panel
            $discount_price = $proAttriPrice['price'] - ($proAttriPrice['price']*$proDetails['product_discount']/100);
            $discount = $proAttriPrice['price'] - $discount_price;
        }else if($catDetails['category_discount']>0){
            //if product discount is not added and category discount is added from admin panel
            $discount_price = $proAttriPrice['price'] - ($proAttriPrice['price']*$catDetails['category_discount']/100);
            $discount = $proAttriPrice['price'] - $discount_price;
        }else{
            $discount_price = $proAttriPrice['price'];
            $discount = 0;
        }

        return array('product_price'=>$proAttriPrice['price'], 'discount_price'=>$discount_price,'discount'=>$discount);
    }


    public static function getProductImage($product_id)
    {
        $getProductImage = Product::select('main_image')->where('id', $product_id)->first()->toArray();
        return $getProductImage['main_image'];
    } 

}
