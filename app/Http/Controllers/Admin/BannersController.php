<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use Response;
use Session;
use Image;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BannersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('page','banners');

        $banners = Banner::get();
        //dd($banners);
        return view('admin.banners.banners')->with(compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banners.create');
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
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp'
            ];

            $customMessages = [
                'image.required' => 'Image is required',
                'image.image' => 'Valid Image is required',
            ];

            $this->validate($request, $rule, $customMessages);
            //end validation customize

            $banner = new Banner;

            if(empty($data['title'])){
                $data['title'] = "";   
            }

            if(empty($data['link'])){
                $data['link'] = "";   
            }

            if(empty($data['alt'])){
                $data['alt'] = "";   
            }


            $image = $request->file('image');

                if(isset($image)){

                    //make unique name for image
                    $currentDate = Carbon::now()->toDateString();

                    $imageName = $currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

                    //check banner image dir is exists
                    if (!Storage::disk('public')->exists('banner')) 
                    {
                        Storage::disk('public')->makeDirectory('banner');
                    }

                    //resize image for banner image and upload
                    $img = Image::make($image)->resize(1170,480)->save(storage_path('app/public/banner').'/'.$imageName);
                    Storage::disk('public')->put('banner/'.$imageName,$img);

                }

            $banner->title = $data['title'];
            $banner->link = $data['link'];
            $banner->alt = $data['alt'];
            $banner->image = $imageName;
            $banner->save();

            Session::flash('success', 'Banner Added Successfully');
            return redirect()->route('banner.index');    
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
        $banner = Banner::findorFail($id);

        return view('admin.banners.edit')->with(compact('banner'));
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
            //dd($data);

            //validation customize
            $rule = [
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp'
            ];

            $customMessages = [
                'image.image' => 'Valid Image is required',
            ];

            $this->validate($request, $rule, $customMessages);
            //end validation customize

            $banner = Banner::findorFail($id);

            if(empty($data['title'])){
                $data['title'] = "";   
            }

            if(empty($data['link'])){
                $data['link'] = "";   
            }

            if(empty($data['alt'])){
                $data['alt'] = "";   
            }


            $image = $request->file('image');

                if(isset($image)){

                    //make unique name for image
                    $currentDate = Carbon::now()->toDateString();

                    $imageName = $currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

                    //check banner image dir is exists
                    if (!Storage::disk('public')->exists('banner')) 
                    {
                        Storage::disk('public')->makeDirectory('banner');
                    }

                    //delete old image
                    if (Storage::disk('public')->exists('banner/'.$banner->image))
                    {
                        Storage::disk('public')->delete('banner/'.$banner->image);
                    }

                    //resize image for banner image and upload
                    $img = Image::make($image)->resize(1170,480)->save(storage_path('app/public/banner').'/'.$imageName);
                    Storage::disk('public')->put('banner/'.$imageName,$img);

                }else{
                    $imageName = $banner->image;
                }

            $banner->title = $data['title'];
            $banner->link = $data['link'];
            $banner->alt = $data['alt'];
            $banner->image = $imageName;
            $banner->save();

            Session::flash('success', 'Banner Updated Successfully');
            return redirect()->route('banner.index');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::findorFail($id);

        if (Storage::disk('public')->exists('banner/'.$banner->image))
            {
                Storage::disk('public')->delete('banner/'.$banner->image);
            }

        $banner->delete();    

        Session::flash('success', 'Banner Deleted Successfully');
        return redirect()->route('banner.index');
    }

    public function updateBannerStatus(Request $request)
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
            Banner::where('id', $data['banner_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'banner_id'=>$data['banner_id']]);
        }   
    }


}
