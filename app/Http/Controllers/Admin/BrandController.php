<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Brand;
use Session;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('page','barnds');

        $barnds = Brand::get();
        // $categories = json_decode(json_encode($categories),true);
        // echo "<pre>"; print_r($categories); die;
        return view('admin.brands.brands')->with(compact('barnds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brands.create');
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
                'brand_name' => 'required'
            ];

            $customMessages = [
                'brand_name.required' => 'Brand Name is required',
            ];

            $this->validate($request, $rule, $customMessages);
            //end validation customize

            $brand = new Brand;

            $brand->name = $data['brand_name'];
            $brand->save();

            Session::flash('success', 'Brand Added Successfully');
            return redirect()->route('brand.index');
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
        $brand = Brand::findorFail($id);

        return view('admin.brands.edit')->with(compact('brand'));
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
                'brand_name' => 'required'
            ];

            $customMessages = [
                'brand_name.required' => 'Brand Name is required',
            ];

            $this->validate($request, $rule, $customMessages);
            //end validation customize

            $brand = Brand::findorFail($id);

            $brand->name = $data['brand_name'];
            $brand->save();

            Session::flash('success', 'Brand Updated Successfully');
            return redirect()->route('brand.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::findorFail($id);
        $brand->delete(); 
        Session::flash('success', 'Brand Deleted Successfully');
            return redirect()->route('brand.index');
    }

    public function updateBrandStatus(Request $request)
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
            Brand::where('id', $data['brand_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'brand_id'=>$data['brand_id']]);
        }
    }
}
