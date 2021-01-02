<?php

namespace App\Http\Controllers\Front;

use Illuminate\Pagination\Paginator;
use Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\ProductsAttribute;
use Response;

class ProductsController extends Controller
{
    public function listing(Request $request)
    {
        Paginator::useBootstrap();

        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $url = $data['url'];

            $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
            if ($categoryCount>0) {
                $categoryDetails =  Category::catDetails($url);

                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
                // echo "<pre>"; print_r($categoryProducts); die;

                //If Fabric filter is secected
                if(isset($data['fabric']) && !empty($data['fabric'])){
                    $categoryProducts->whereIn('products.fabric', $data['fabric']);
                }
                //If sleeve filter is secected
                if(isset($data['sleeve']) && !empty($data['sleeve'])){
                    $categoryProducts->whereIn('products.sleeve', $data['sleeve']);
                }
                //If pattern filter is secected
                if(isset($data['pattern']) && !empty($data['pattern'])){
                    $categoryProducts->whereIn('products.pattern', $data['pattern']);
                }
                //If fit filter is secected
                if(isset($data['fit']) && !empty($data['fit'])){
                    $categoryProducts->whereIn('products.fit', $data['fit']);
                }
                //If occasion filter is secected
                if(isset($data['occasion']) && !empty($data['occasion'])){
                    $categoryProducts->whereIn('products.occasion', $data['occasion']);
                }


                //If sort option selected by user
                if(isset($data['sort']) && !empty($data['sort']))
                {
                    if($data['sort'] == "product_latest") {
                        $categoryProducts->orderBy('id','Desc');
                    }
                    else if($data['sort'] == "product_name_a_z") {
                        $categoryProducts->orderBy('product_name','Asc');
                    }
                    else if($data['sort'] == "product_name") {
                        $categoryProducts->orderBy('id','Desc');
                    }
                    else if($data['sort'] == "price_lowest") {
                        $categoryProducts->orderBy('product_price','Asc');
                    }
                    else if($data['sort'] == "price_highets") {
                        $categoryProducts->orderBy('product_price','Desc');
                    }
                }
                else{
                    $categoryProducts->orderBy('id','Desc');
                }

                $categoryProducts = $categoryProducts->paginate(30);

                return view('front.products.ajax_products_listing')->with(compact('categoryDetails','categoryProducts','url'));
            }
            else
            {
                abort(404);
            } 

        }else{
           $url = Route::getFacadeRoot()->current()->uri();
           $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
            if ($categoryCount>0) {
                $categoryDetails =  Category::catDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
                // echo "<pre>"; print_r($categoryProducts); die;
                $categoryProducts = $categoryProducts->paginate(30);

                //product brand Filter
                $productFilters = Product::productFilters();
                //echo "<pre>"; print_r($productFilters); die;
                $fabricArray = $productFilters['fabricArray'];
                $sleeveArray = $productFilters['sleeveArray'];
                $patternArray = $productFilters['patternArray'];
                $fitArray = $productFilters['fitArray'];
                $occasionArray = $productFilters['occasionArray'];

                $page_name = "listing";

                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url','fabricArray','sleeveArray','patternArray','fitArray','occasionArray','page_name'));
            }
            else
            {
                abort(404);
            } 
        }

    	
    }


    public function details($id)
    {
        $productDetails = Product::with('category','brand','attributes','images')->find($id)->toArray();
        // dd($productDetails);
        $totalStock = ProductsAttribute::where('product_id',$id)->sum('stock');
        $relatedProducts = Product::where('category_id',$productDetails['category']['id'])->where('id','!=',$id)->limit(2)->inRandomOrder()->get()->toArray();
         // dd($relatedProducts);
        return view('front.products.product_details')->with(compact('productDetails','totalStock','relatedProducts'));
    }

    public function getProductPrice(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getProductPrice = ProductsAttribute::where(['product_id'=>$data['product_id'],'size'=>$data['size']])->first();
            return $getProductPrice->price;
        }
    }

}
