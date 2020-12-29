<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;
use App\Product;
use App\Banner;

class IndexController extends Controller
{
    public function index()
    {
    	$page_name = "Index";

    	//get all Feature Items
    	$featureItemsCount = Product::isfeatured()->status()->count();
    	$featureItems = Product::isfeatured()->status()->get()->toArray();
    	$featureItemsChunk = array_chunk($featureItems, 4);
    	// echo "<pre>"; print_r($featureItemsChunk); die;

    	//$sections = Section::with('categories')->where('status',1)->get();
    	// $sections = json_decode(json_encode($sections),true);
     	//echo "<pre>"; print_r($sections); die;

     	//Get new product
     	$newProducts = Product::status()->orderBy('id','Desc')->limit(6)->get();
     	// dd($newProducts);

        //Get banner
        $getBanner = Banner::where('status',1)->get();

    	return view('front.index')->with(compact('page_name','featureItemsChunk','featureItemsCount','newProducts','getBanner'));
    }
}
