<?php

namespace App\Http\Controllers\Front;

use Route;
use View;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Cart;
use App\ProductsAttribute;
use Response;
use Session;
use Auth;

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
        $productDetails = Product::with(['category','brand','attributes'=>function($query){
                    $query->where('status',1);
                },'images'])->find($id)->toArray();
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
            // $getProductPrice = ProductsAttribute::where(['product_id'=>$data['product_id'],'size'=>$data['size']])->first();

            $getDiscountAttriPrice = Product::getDiscountAttriPrice($data['product_id'],$data['size']);

            //return $getProductPrice->price;
            return $getDiscountAttriPrice;
        }
    }

    public function addToCart(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            //Check product stock is available or not
            $getProductStock = ProductsAttribute::where(['product_id'=>$data['product_id'],'size'=>$data['size']])->first()->toArray();
            if($getProductStock['stock']<$data['quantity']){
                Session::flash('error', 'Required Quantity is not available');
                return redirect()->back();
            }

            //Category session ID is not exists
            $session_id = Session::get('session_id');
            if (empty($session_id)) {
                $session_id = Session::getId();
                Session::put('session_id',$session_id);
            }

            //Check product is already exists in user cart
            if(Auth::check()){
                //user in logged in 
                $countProduct = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'user_id'=>Auth::user()->id])->count();
            }else{
                //user in not logged in
                $countProduct = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'session_id'=>Session::get('session_id')])->count();
            }

            if($countProduct>0){
                Session::flash('error', 'Product already exists in a cart');
                return redirect()->back();
            }

            if (Auth::check()) {
                $user_id = Auth::user()->id;
            }else{
                $user_id = 0;
            }

            //Save product in cart
            $cart = new Cart;
            $cart->session_id = $session_id;
            if(empty($data['user_id'])){
                $cart->user_id = $user_id;   
            }else{
                $cart->user_id = $data['user_id'];
            }
            $cart->product_id = $data['product_id'];
            $cart->size = $data['size'];
            $cart->quantity = $data['quantity'];
            $cart->save();

            Session::flash('success', 'Product has been added in cart');
            return redirect('cart');
        }
    }

    public function cart()
    {
        $userCartItems = Cart::userCartItems();
        // echo "<pre>"; print_r($userCartItems); die;
        return view('front.products.cart')->with(compact('userCartItems'));
    }

    public function updateCartItemQty(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            //get cart details for stock check
            $cartDetails = Cart::find($data['cartid']);

            //Get Available product stock
            $availableStock = ProductsAttribute::select('stock')->where(['product_id'=>$cartDetails['product_id'], 'size'=>$cartDetails['size']])->first()->toArray();

            // echo "Demanded stock: ".$data['qty'];
            // echo "<br>";
            // echo "Available stock: ".$availableStock['stock']; die;

            //check stock is available or not
            if ($data['qty']>$availableStock['stock']) {
                $userCartItems = Cart::userCartItems();
                return response()->json([
                'status'=>false,
                'message'=>'Product Stock is not available',
                'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                ]);
            }

            //check size is available
            $availableSize = ProductsAttribute::where(['product_id'=>$cartDetails['product_id'], 'size'=>$cartDetails['size'],'status'=>1])->count();

            if ($availableSize==0) {
                $userCartItems = Cart::userCartItems();
                return response()->json([
                'status'=>false,
                'message'=>'Product Size is not available',
                'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                ]);
            }

            Cart::where('id',$data['cartid'])->update(['quantity'=>$data['qty']]);

            $userCartItems = Cart::userCartItems();
            $totalCartItems = totalCartItems();

            return response()->json([
                'status'=>true,
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
            ]);
        }
    }


    public function deleteCartItem(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            Cart::where('id',$data['cartid'])->delete();
            $totalCartItems = totalCartItems();

            $userCartItems = Cart::userCartItems();
                return response()->json([
                    'totalCartItems'=>$totalCartItems,    
                    'message'=>'Product Stock is not available',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                ]);
        }
    }


}
