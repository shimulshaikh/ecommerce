<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
    	$page_name = "Index";
    	return view('front.index')->with(compact('page_name'));
    }
}
