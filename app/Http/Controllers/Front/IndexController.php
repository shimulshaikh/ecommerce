<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;

class IndexController extends Controller
{
    public function index()
    {
    	$page_name = "Index";

    	$sections = Section::with('categories')->where('status',1)->get();
    	// $sections = json_decode(json_encode($sections),true);
     //    echo "<pre>"; print_r($sections); die;

    	return view('front.index')->with(compact('page_name','sections'));
    }
}
