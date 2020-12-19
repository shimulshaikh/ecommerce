<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Section;
use App\Category;
use Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Image;
use Carbon\Carbon;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('page','products');

        $products = Product::with(['category'=>function($query){
            $query->select('id','category_name');
        },'section'=>function($query){
            $query->select('id','name');
        }])->get();
        // $products = json_decode(json_encode($products),true);
        // echo "<pre>"; print_r($products); die;
        return view('admin.products.products')->with(compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Filter Array
        $fabricArray = array('Cotton','Polyester','Wool');
        $sleeveArray = array('Full Sleeve','Half Sleeve','Short Sleeve','Sleeveless');
        $patternArray = array('Checked','Plain','Printed','Self','Solid');
        $fitArray = array('Regular','Slim');
        $occasionArray = array('Casual','Formal');

        $categories = Section::with('categories')->get();
        // $categories = json_decode(json_encode($categories),true);
        // echo "<pre>"; print_r($categories); die;

        return view('admin.products.create_product')->with(compact('fabricArray','sleeveArray','patternArray','fitArray','occasionArray','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        //dd($data);
        //validation customize
            $rule = [
                'category_id' => 'required',
                'product_name' => 'required',
                'product_code' => 'required',
                'product_price' => 'required|numeric',
                'product_color' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp'
            ];

            $customMessages = [
                'category_id.required' => 'Category is required',
                'product_name.required' => 'Product Name is reduired',
                'product_code.required' => 'Product Code is reduired',
                'product_price.required' => 'Product Price is reduired',
                'product_price.numeric' => 'Valid Product Price is reduired',
                'product_color.required' => 'Product Color is required',
                'image.image' => 'Valid Image is required',
            ];

            $this->validate($request, $rule, $customMessages);
            //end validation customize

            //save product datails in product table
            $product = new Product;

            if(empty($data['is_featured'])){
                $is_featured = "No";
            }else{
                $is_featured = "Yes";
            }


            if(empty($data['fabric'])){
                $data['fabric'] = "";
            }

            if(empty($data['pattern'])){
                $data['pattern'] = "";
            }

            if(empty($data['sleeve'])){
                $data['sleeve'] = "";
            }

            if(empty($data['fit'])){
                $data['fit'] = "";
            }

            if(empty($data['occasion'])){
                $data['occasion'] = "";
            }

            if(empty($data['meta_title'])){
                $data['meta_title'] = "";
            }

            if(empty($data['meta_description'])){
                $data['meta_description'] = "";
            }

            if(empty($data['meta_keywords'])){
                $data['meta_keywords'] = "";
            }

            if(empty($data['description'])){
                $data['description'] = "";
            }

            if(empty($data['product_video'])){
                $data['product_video'] = "";
            }

            if(empty($data['product_discount'])){
                $data['product_discount'] = 0;
            }

            if(empty($data['product_weight'])){
                $data['product_weight'] = 0;
            }

            if(empty($data['wash_care'])){
                $data['wash_care'] = "";
            }

            //upload product Image
            $image = $request->file('image');

        if(isset($image)){

            //make unique nake for image
            $currentDate = Carbon::now()->toDateString();

            $imageName = '-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            //check product large image dir is exists
            if (!Storage::disk('public')->exists('product/large')) 
            {
                Storage::disk('public')->makeDirectory('product/large');
            }

            //resize for product large image and upload
            $img = Image::make($image)->resize(1040,1200)->save(storage_path('app/public/product/large').'/'.$imageName);
            Storage::disk('public')->put('product/large/'.$imageName,$img);

            //check product medium image dir is exists
            if (!Storage::disk('public')->exists('product/medium')) 
            {
                Storage::disk('public')->makeDirectory('product/medium');
            }

            //resize for product medium image and upload
            $medium = Image::make($image)->resize(520,600)->save(storage_path('app/public/product/medium').'/'.$imageName);
            Storage::disk('public')->put('product/medium/'.$imageName,$medium);

            //check product small image dir is exists
            if (!Storage::disk('public')->exists('product/small')) 
            {
                Storage::disk('public')->makeDirectory('product/small');
            }

            //resize for product small image and upload
            $small = Image::make($image)->resize(260,300)->save(storage_path('app/public/product/small').'/'.$imageName);
            Storage::disk('public')->put('product/small/'.$imageName,$small);

        }
        else{
            $imageName = "";
        }

        //upload product video
        // $product_video = $request->file('product_video');

        // if(isset($product_video)){
        //     {
        //          //make unique nake for product video
        //     $currentDate = Carbon::now()->toDateString();

        //     $videoName = '-'.$currentDate.'-'.uniqid().'.'.$product_video->getClientOriginalExtension();

        //     //check product video dir is exists
        //     if (!Storage::disk('public')->exists('product/video')) 
        //     {
        //         Storage::disk('public')->makeDirectory('product/video');
        //     }

        //     //resize for product  video and upload
        //     $video = Image::make($product_video)->resize(1040,1200)->save(storage_path('app/public/product/video').'/'.$videoName);
        //     Storage::disk('public')->put('product/video/'.$videoName,$video);
        //     }

        // }else{
        //     $videoName = "";
        // }


            $categoryDetails = Category::find($data['category_id']);

            $product->category_id = $data['category_id'];
            $product->section_id = $categoryDetails['section_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->product_video = $data['product_video'];
            $product->main_image = $imageName;
            $product->description = $data['description'];
            $product->wash_care = $data['wash_care'];
            $product->fabric = $data['fabric'];
            $product->pattern = $data['pattern'];
            $product->sleeve = $data['sleeve'];
            $product->fit = $data['fit'];
            $product->occasion = $data['occasion'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            $product->is_featured = $is_featured;
            $product->status = 1;
            //dd($product);
            $product->save();

            Session::flash('success', 'Product Added Successfully');
            return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Filter Array
        $fabricArray = array('Cotton','Polyester','Wool');
        $sleeveArray = array('Full Sleeve','Half Sleeve','Short Sleeve','Sleeveless');
        $patternArray = array('Checked','Plain','Printed','Self','Solid');
        $fitArray = array('Regular','Slim');
        $occasionArray = array('Casual','Formal');

        $categories = Section::with('categories')->get();
        $productData = Product::findorFail($id);
        // $productData = json_decode(json_encode($productData),true);
        // echo "<pre>"; print_r($productData); die;

        return view('admin.products.edit_product')->with(compact('productData','categories','fabricArray','sleeveArray','patternArray','fitArray','occasionArray'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = $request->all();

        $product = Product::findorFail($id);

        if(empty($data['is_featured'])){
                $is_featured = "No";
            }else{
                $is_featured = "Yes";
            }


            if(empty($data['fabric'])){
                $data['fabric'] = "";
            }

            if(empty($data['pattern'])){
                $data['pattern'] = "";
            }

            if(empty($data['sleeve'])){
                $data['sleeve'] = "";
            }

            if(empty($data['fit'])){
                $data['fit'] = "";
            }

            if(empty($data['occasion'])){
                $data['occasion'] = "";
            }

            if(empty($data['meta_title'])){
                $data['meta_title'] = "";
            }

            if(empty($data['meta_description'])){
                $data['meta_description'] = "";
            }

            if(empty($data['meta_keywords'])){
                $data['meta_keywords'] = "";
            }

            if(empty($data['description'])){
                $data['description'] = "";
            }

            if(empty($data['product_video'])){
                $data['product_video'] = "";
            }

            if(empty($data['product_discount'])){
                $data['product_discount'] = 0;
            }

            if(empty($data['product_weight'])){
                $data['product_weight'] = 0;
            }

            if(empty($data['wash_care'])){
                $data['wash_care'] = "";
            }

            //upload product Image
            $image = $request->file('image');

        if(isset($image)){

            //make unique nake for image
            $currentDate = Carbon::now()->toDateString();

            $imageName = '-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            //check product large image dir is exists
            if (!Storage::disk('public')->exists('product/large')) 
            {
                Storage::disk('public')->makeDirectory('product/large');
            }

            //delete old image
            if (Storage::disk('public')->exists('product/large/'.$product->main_image))
                    {
                Storage::disk('public')->delete('product/large/'.$product->main_image);
            }

            //resize for product large image and upload
            $img = Image::make($image)->resize(1040,1200)->save(storage_path('app/public/product/large').'/'.$imageName);
            Storage::disk('public')->put('product/large/'.$imageName,$img);

            //check product medium image dir is exists
            if (!Storage::disk('public')->exists('product/medium')) 
            {
                Storage::disk('public')->makeDirectory('product/medium');
            }

            //delete old image
            if (Storage::disk('public')->exists('product/medium/'.$product->main_image))
                    {
                Storage::disk('public')->delete('product/medium/'.$product->main_image);
            }

            //resize for product medium image and upload
            $medium = Image::make($image)->resize(520,600)->save(storage_path('app/public/product/medium').'/'.$imageName);
            Storage::disk('public')->put('product/medium/'.$imageName,$medium);

            //check product small image dir is exists
            if (!Storage::disk('public')->exists('product/small')) 
            {
                Storage::disk('public')->makeDirectory('product/small');
            }

            //delete old image
            if (Storage::disk('public')->exists('product/small/'.$product->main_image))
                    {
                Storage::disk('public')->delete('product/small/'.$product->main_image);
            }

            //resize for product small image and upload
            $small = Image::make($image)->resize(260,300)->save(storage_path('app/public/product/small').'/'.$imageName);
            Storage::disk('public')->put('product/small/'.$imageName,$small);

        }
        else{
            $imageName = $product->main_image;
        }

        //upload product video
        // $product_video = $request->file('product_video');

        // if(isset($product_video)){
        //     {
        //          //make unique nake for product video
        //     $currentDate = Carbon::now()->toDateString();

        //     $videoName = '-'.$currentDate.'-'.uniqid().'.'.$product_video->getClientOriginalExtension();

        //     //check product video dir is exists
        //     if (!Storage::disk('public')->exists('product/video')) 
        //     {
        //         Storage::disk('public')->makeDirectory('product/video');
        //     }

        //     //resize for product  video and upload
        //     $video = Image::make($product_video)->resize(1040,1200)->save(storage_path('app/public/product/video').'/'.$videoName);
        //     Storage::disk('public')->put('product/video/'.$videoName,$video);
        //     }

        // }else{
        //     $videoName = "";
        // }


            $categoryDetails = Category::find($data['category_id']);
            // $categoryDetails = json_decode(json_encode($categoryDetails),true);
            // echo "<pre>"; print_r($categoryDetails); die;

            $product->category_id = $data['category_id'];
            $product->section_id = $categoryDetails['section_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->product_video = $data['product_video'];
            $product->main_image = $imageName;
            $product->description = $data['description'];
            $product->wash_care = $data['wash_care'];
            $product->fabric = $data['fabric'];
            $product->pattern = $data['pattern'];
            $product->sleeve = $data['sleeve'];
            $product->fit = $data['fit'];
            $product->occasion = $data['occasion'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            $product->is_featured = $is_featured;
            $product->status = 1;
            //dd($product);
            $product->save();

            Session::flash('success', 'Product Updated Successfully');
            return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findorFail($id);

        if (Storage::disk('public')->exists('product/large/'.$product->main_image))
                    {
                Storage::disk('public')->delete('product/large/'.$product->main_image);
            }

        if (Storage::disk('public')->exists('product/medium/'.$product->main_image))
                    {
                Storage::disk('public')->delete('product/medium/'.$product->main_image);
            }    

        if (!Storage::disk('public')->exists('product/small')) 
            {
                Storage::disk('public')->makeDirectory('product/small');
            }
            
        $product->delete();    

        Session::flash('success', 'Product Deleted Successfully');
        return redirect()->back();        
    }

    public function updateProductStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if($data['status'] == "Active"){
                $status = 0;
            }
            else{
                $status = 1;   
            }
            Product::where('id', $data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'product_id'=>$data['product_id']]);
        }   
    }
}
