<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Section;
use Response;
use Session;
use Image;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('page','categories');

        $categories = Category::with(['section','parentCategory'])->get();
        // $categories = json_decode(json_encode($categories),true);
        // echo "<pre>"; print_r($categories); die;
        return view('admin.categories.categories')->with(compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::get();
        return view('admin.categories.create')->with(compact('sections'));
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
                'category_name' => 'required|string',
                'section_id' => 'required',
                'url' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp'
            ];

            $customMessages = [
                'category_name.required' => 'Category Name is required',
                'category_name.string' => 'Category Name must be string',
                'section_id.required' => 'Section is reduired',
                'url.required' => 'Category URL is required',
                'image.image' => 'Valid Image is required',
            ];

            $this->validate($request, $rule, $customMessages);
            //end validation customize

            $category = new Category;

            if(empty($data['category_discount'])){
                $data['category_discount'] = "0.00";   
            }

            if(empty($data['description'])){
                $data['description'] = "";   
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

             $image = $request->file('image');

                if(isset($image)){

                    //make unique name for image
                    $currentDate = Carbon::now()->toDateString();

                    $imageName = $currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

                    //check category image dir is exists
                    if (!Storage::disk('public')->exists('category_image')) 
                    {
                        Storage::disk('public')->makeDirectory('category_image');
                    }

                    //resize image for category image and upload
                    $img = Image::make($image)->resize(400,400)->save(storage_path('app/public/category_image').'/'.$imageName);
                    Storage::disk('public')->put('category_image/'.$imageName,$img);

                }
                else{
                    $imageName = "default.png";
                }

            $category->parent_id = $data['parent_id'];
            $category->section_id = $data['section_id'];
            $category->category_name = $data['category_name'];
            $category->category_image = $imageName;
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();

            Session::flash('success', 'Category Added Successfully');
            return redirect()->route('category.index');
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
        $sections = Section::get();
        $categories = Category::findorFail($id);
        // $categories = json_decode(json_encode($categories),true);
        // echo "<pre>"; print_r($categories); die;
        $getCategories = Category::with('subcategories')->where(['parent_id'=>0, 'section_id'=>$categories['section_id']])->get();
        // $getCategories = json_decode(json_encode($getCategories),true);
        // echo "<pre>"; print_r($getCategories); die;
        return view('admin.categories.edit_category')->with(compact('sections','categories','getCategories'));
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
        $category = Category::findorFail($id);

        $data = $request->all();
            //dd($data);

            //validation customize
            $rule = [
                'category_name' => 'required|string',
                'section_id' => 'required',
                'url' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp'
            ];

            $customMessages = [
                'category_name.required' => 'Category Name is required',
                'category_name.string' => 'Category Name must be string',
                'section_id.required' => 'Section is reduired',
                'url.required' => 'Category URL is required',
                'image.image' => 'Valid Image is required',
            ];

            $this->validate($request, $rule, $customMessages);
            //end validation customize

            if(empty($data['category_discount'])){
                $data['category_discount'] = "0.00";   
            }

            if(empty($data['description'])){
                $data['description'] = "";   
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

             $image = $request->file('image');

                if(isset($image)){

                    //make unique name for image
                    $currentDate = Carbon::now()->toDateString();

                    $imageName = $currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

                    //check category image dir is exists
                    if (!Storage::disk('public')->exists('category_image')) 
                    {
                        Storage::disk('public')->makeDirectory('category_image');
                    }

                    //delete old image
                    if (Storage::disk('public')->exists('category_image/'.$category->category_image))
                    {
                        Storage::disk('public')->delete('category_image/'.$category->category_image);
                    }


                    //resize image for category image and upload
                    $img = Image::make($image)->resize(400,400)->save(storage_path('app/public/category_image').'/'.$imageName);
                    Storage::disk('public')->put('category_image/'.$imageName,$img);

                }
                else{
                    $imageName = $category->category_image;
                }

            $category->parent_id = $data['parent_id'];
            $category->section_id = $data['section_id'];
            $category->category_name = $data['category_name'];
            $category->category_image = $imageName;
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();

            Session::flash('success', 'Category Updated Successfully');
            return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findorFail($id);

        if (Storage::disk('public')->exists('category_image/'.$category->category_image))
            {
                Storage::disk('public')->delete('category_image/'.$category->category_image);
            }

        $category->delete();    

        Session::flash('success', 'Category Deleted Successfully');
        return redirect()->route('category.index');
    }

    public function updateCategoryStatus(Request $request)
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
            Category::where('id', $data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'category_id'=>$data['category_id']]);
        }
    }

    public function appendCategoriesLevel(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getCategories = Category::with('subcategories')->where(['section_id'=> $data['section_id'], 'parent_id'=>0, 'status'=>1])->get();
             
            $getCategories = json_decode(json_encode($getCategories),true);
              //echo "<pre>"; print_r($getCategories); die;
            return view('admin.categories.append_categoris_level')->with(compact('getCategories'));
        }
    }

    public function deleteCategoryImage($id)
    {
        $categoryImage = Category::select('category_image')->where('id',$id)->first();

        if (Storage::disk('public')->exists('category_image/'.$categoryImage->category_image))
            {
                Storage::disk('public')->delete('category_image/'.$categoryImage->category_image);
            }

        Category::where('id',$id)->update(['category_image'=>'default.png']); 
        
        Session::flash('success', 'Category Image Successfully Deleted');
            return redirect()->back();   
    }

}
