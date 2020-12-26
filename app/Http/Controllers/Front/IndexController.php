<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;
use App\Product;

class IndexController extends Controller
{
    public function index()
    {
    	$page_name = "Index";

    	//get all Feature Items
    	$featureItemsCount = Product::where('is_featured','Yes')->count();
    	$featureItems = Product::where('is_featured','Yes')->get()->toArray();
    	$featureItemsChunk = array_chunk($featureItems, 4);
    	// echo "<pre>"; print_r($featureItemsChunk); die;

    	$sections = Section::with('categories')->where('status',1)->get();
    	// $sections = json_decode(json_encode($sections),true);
     	//echo "<pre>"; print_r($sections); die;

    	return view('front.index')->with(compact('page_name','sections','featureItemsChunk'));
    }
}
