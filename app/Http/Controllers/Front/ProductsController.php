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
use App\Coupon;
use App\User;
use App\Country;
use App\Order;
use App\OrdersProduct;
use App\ProductsAttribute;
use App\DeliveryAddress;
use Response;
use Session;
use Auth;
use DB;

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

    public function applyCoupon(Request $request)
    {
        if ($request->ajax()) {
               $data = $request->all();
               // echo "<pre>"; print_r($data); die;
               $userCartItems = Cart::userCartItems();

               $couponCount = Coupon::where('coupon_code', $data['code'])->count();
               if ($couponCount == 0) {
                    $userCartItems = Cart::userCartItems();
                    $totalCartItems = totalCartItems();

                   return response()->json([
                        'status'=>false,
                        'message'=>'This coupon is not valid!',
                        'totalCartItems'=>$totalCartItems,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                    ]);    
               }
               else{
                    //check for other coupon conditions

                    //Get coupon details
                    $couponDetails = Coupon::where('coupon_code', $data['code'])->first();
                        
                    //Check for coupon code Inactive
                    if ($couponDetails->status == 0) {
                        $message = "This coupon is not active!";
                    }

                    //check if coupon is Expired
                    $expiry_date = $couponDetails->expiry_date;
                    $current_date = date('Y-m-d');
                    if ($expiry_date<$current_date) {
                        $message = "This coupon is Expired!";
                    }

                    //Check if coupon is from selected categories
                    //Get all selected categories fron coupon
                    $carArr = explode(",", $couponDetails->categories);

                    $userCartItems = Cart::userCartItems();

                    //Check if coupon belongs to logged in user
                    //get all selec users of coupon
                    if (!empty($couponDetails->users)) {
                        $usersArr =  explode(",", $couponDetails->users);

                        //Get users ID's of all selected  users
                        foreach ($usersArr as $user) {
                           $getUserId =  User::select('id')->where('email', $user)->first()->toArray();
                           $userId[] = $getUserId['id'];
                        }
                    }


                    //Get cart total Amount
                    $total_amount = 0;

                    foreach ($userCartItems as $item) {
                        //Check if any Item belong to coupon category
                        if (!in_array($item['product']['category_id'], $carArr)) {
                            $message = 'This coupon code is not for one of the selected products!';
                        }

                        if (!empty($couponDetails->users)) {
                            if (!in_array($item['user_id'], $userId)) {
                                $message = "This coupon code is not for you";
                            }
                        }

                        $attPrice = Product::getDiscountAttriPrice($item['product_id'],$item['size']);

                        $total_amount = $total_amount + ($attPrice['discount_price']*$item['quantity']);

                        // echo $total_amount; die;

                    }

                    if (isset($message)) {
                        $userCartItems = Cart::userCartItems();
                        $totalCartItems = totalCartItems();
                        $couponAmount = 0;

                        return response()->json([
                        'status'=>false,
                        'message'=>$message,
                        'totalCartItems'=>$totalCartItems,
                        'couponAmount'=>$couponAmount,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                        ]);  
                    }
                    else{
                        // echo "Coupon can be successfully redeemed"; die;

                        //check if amount type is Fixed or Percentage
                        if ($couponDetails->amount_type == "Fixed") {
                            $couponAmount = $couponDetails->amount;
                        }else{
                            $couponAmount = $total_amount * ($couponDetails->amount/100);
                        }

                        $grand_total = $total_amount - $couponAmount;

                         // echo $grand_total; die;
                        //Add coupon code & Amount is Session Variables
                        Session::put('couponAmount', $couponAmount);
                        Session::put('couponCode', $data['code']);

                        $userCartItems = Cart::userCartItems();
                        $totalCartItems = totalCartItems();

                        $message = "Coupon code successfully applied. You are availing discount!";

                        return response()->json([
                        'status'=>true,
                        'message'=>$message,
                        'totalCartItems'=>$totalCartItems,
                        'couponAmount'=>$couponAmount,
                        'grand_total'=>$grand_total,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                        ]);  
                    }
               }
           }   
    }


    public function checkout(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            if (empty($data['address_id'])) {
                $message = "Please select Delivery Address";
                session::flash('error', $message);
                return redirect()->back();
            }

            if (empty($data['payment_gateway'])) {
                $message = "Please select Payment Method";
                session::flash('error', $message);
                return redirect()->back();
            }

            if ($data['payment_gateway'] == "COD") {
                $payment_method = "COD";
            }else{
                $payment_method = "Prepaid";
            }

            //Get delivary address from address_id
            $deliveryAddresse = DeliveryAddress::where('id',$data['address_id'])->first()->toArray();

            DB::beginTransaction();

            
            //Insert Order details
            $order = new Order;
            $order->user_id = Auth::user()->id;
            $order->name = $deliveryAddresse['name'];
            $order->address = $deliveryAddresse['address'];
            $order->city = $deliveryAddresse['city'];
            $order->state = $deliveryAddresse['state'];
            $order->country = $deliveryAddresse['country'];
            $order->pincode = $deliveryAddresse['pincode'];
            $order->mobile = $deliveryAddresse['mobile'];
            $order->email = Auth::user()->email;
            $order->shipping_charges = 0;
            if (!empty(Session::get('couponCode'))) {
                $order->coupon_code = Session::get('couponCode');
            }else{
                $order->coupon_code = "";
            }

            if (!empty(Session::get('couponAmount'))) {
                $order->coupon_amount = Session::get('couponAmount');
            }else{
                $order->coupon_amount = "";
            }
            $order->order_status = "New";
            $order->payment_method = $payment_method;
            $order->payment_gateway = $data['payment_gateway'];
            $order->grand_total = Session::get('grand_total');
            $order->save();

            //Get last Order Id
            $order_id = DB::getPdo()->lastInsertId();

            //Get user cart Item
            $cartItems = Cart::where('user_id',Auth::user()->id)->get()->toArray();
             foreach ($cartItems as $item) {
                 $cartItem = new OrdersProduct;

                 $cartItem->order_id = $order_id;
                 $cartItem->user_id = Auth::user()->id;

                 $getProductDetails = Product::select('product_code','product_name','product_color')->where('id', $item['product_id'])->first()->toArray();

                 $cartItem->product_id = $item['product_id'];
                 $cartItem->product_code = $getProductDetails['product_code'];
                 $cartItem->product_name = $getProductDetails['product_name'];
                 $cartItem->product_color = $getProductDetails['product_color'];
                 $cartItem->product_size = $item['size'];

                 $proAttriPrice = Product::getDiscountAttriPrice($item['product_id'],$item['size']);

                 $cartItem->product_price = $proAttriPrice['discount_price'];
                 $cartItem->product_qty = $item['quantity'];
                 $cartItem->save();

             }

             //Empty the user cart
             Cart::where('user_id', Auth::user()->id)->delete();

             DB::commit();
             echo "order place"; die;

        }
        $userCartItems = Cart::userCartItems();
        $deliveryAddresse = DeliveryAddress::deliveryAddresses();
        return view('front.products.checkout')->with(compact('userCartItems','deliveryAddresse'));
    }

    public function addEditDeliveryAddress(Request $request,$id=null)
    {
        if ($id=="") {
            //Add delivery address
            $title = "Add Delivery Address";
            $address = new DeliveryAddress;
            $message = "Delivery address added successfully!";
        }else{
            //Edit delivery address
            $title = "Edit Delivery Address";
            $address = DeliveryAddress::find($id);
            $message = "Delivery address updated successfully!";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            //validation customize
            $rule = [
                'name' => 'required',
                'address' => 'required',
                'city' => 'required',
                'country' => 'required',
                'pincode' => 'required',
                'mobile' => 'required'
            ];

            $customMessages = [
                'name.required' => 'Name is required',
                'address.required' => 'Address is reduired',
                'city.required' => 'City is reduired',
                'country.required' => 'Country is reduired',
                'pincode.required' => 'Country is reduired',
                'mobile.required' => 'Mobile is reduired',
            ];

            $this->validate($request, $rule, $customMessages);
            //end validation customize

            $address->name = $data['name'];
            $address->address = $data['address'];
            $address->user_id = Auth()->user()->id;
            $address->city = $data['city'];
            $address->state = $data['state'];
            $address->country = $data['country'];
            $address->pincode = $data['pincode'];
            $address->mobile = $data['mobile'];
            $address->save();
            Session::put('success',$message);
            return redirect()->back();
        }

        $countries = Country::where('status',1)->get()->toArray();
        return view('front.products.add_edit_delivery_address')->with(compact('countries','title','address'));
    }

    public function deleteDeliveryAddress($id)
    {
        $address = DeliveryAddress::find($id);
        $message = "Delivery address deleted successfully!";
        $address->delete();
        Session::put('success',$message);
        return redirect()->back();
    }


}
