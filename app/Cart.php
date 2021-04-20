<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Session;

class Cart extends Model
{
    use HasFactory;

    protected $guard = 'carts';

    protected $fillable = [
        'session_id', 'user_id', 'product_id', 'size', 'quantity'
    ];

    

    public static function userCartItems()
    {
    	if(Auth::user()){
    		$userCartItems = Cart::with(['product'=>function($query){
    			$query->select('id','category_id','product_name','product_code','main_image','product_color');
    		}])->where('user_id',Auth::user()->id)->orderBy('id','Desc')->get()->toArray();
    	}else{
    		$userCartItems = Cart::with(['product'=>function($query){
    			$query->select('id','category_id','product_name','product_code','main_image','product_color');
    		}])->where('session_id',Session::get('session_id'))->orderBy('id','Desc')->get()->toArray();
    	}
    	return $userCartItems;
    }

    public function product()
    {
    	return $this->belongsTo('App\Product', 'product_id');
    }

    public static function getProductAttributes($product_id,$size)
    {
    	$attrPrice = ProductsAttribute::select('price')->where(['product_id'=>$product_id,'size'=>$size])->first()->toArray();
    	return $attrPrice['price'];
    }
}
