@extends('layouts.admin_layouts.admin_layout')
@section('content')

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Catalogues</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Coupons</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

              @if ($errors->any())
                  <div class="alert alert-danger" style="margin-top: 10px;">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif

      <form name="couponForm" id="couponForm" @if(!empty($coupon['id'])) action="{{ url('admin/add-edit-coupon') }}" @else action="{{ url('admin/add-edit-coupon/'.$coupon['id']) }} @endif" method="post">
        @csrf
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label for="coupon_option">Coupon Option</label><br>
                    <span>
                      <input type="radio" id="AutomaticCoupon" name="coupon_option" value="Automatic" checked="">&nbsp;Automatic
                      &nbsp;&nbsp;
                      <input type="radio" id="ManualCoupon" name="coupon_option" value="Manual">&nbsp;Manual
                      &nbsp;&nbsp;
                    </span>
                </div>

                <div class="form-group" style="display: none;" id="couponField">
                    <label for="coupon_code">Coupon Code</label>
                    <input type="text" name="coupon_code" class="form-control" id="coupon_code" placeholder="Enter Coupon Code" value="{{old('coupon_code')}}">
                </div>

                <div class="form-group">
                    <label for="coupon_type">Coupon Type</label><br>
                    <span>
                      <input type="radio" name="coupon_type" value="Multiple Time" checked="">&nbsp;Multiple Time
                      &nbsp;&nbsp;
                      <input type="radio" name="coupon_type" value="Single Time">&nbsp;Single Time
                      &nbsp;&nbsp;
                    </span>
                </div>

                <div class="form-group">
                    <label for="amount_type">Amount Type</label><br>
                    <span>
                      <input type="radio" name="amount_type" value="Percentage" checked="">&nbsp;Percentage
                      &nbsp;(in %)&nbsp;
                      <input type="radio" name="amount_type" value="Fixed">&nbsp;Fixed
                      &nbsp;(in INR or USD)&nbsp;
                    </span>
                </div>

                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" name="amount" class="form-control" id="amount" placeholder="Enter Amount" value="{{old('amount')}}" required="">
                </div>
               </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label for="categories">Select Categories</label>
                    <select name="categories[]" class="form-control select2" multiple="" required="">
                    <option value="">Select</option>
                    @foreach($categories as $section)
                      <optgroup label="{{$section->name}}"></optgroup>
                      @foreach($section['categories'] as $category)
                        <option value="{{$category->id}}" @if(!empty(@old('category_id')) && $category-> id == @old('category_id')) selected=""  @elseif(!empty($productData['category_id']) && $productData['category_id']==$category->id) selected="" @endif>&nbsp;&nbsp;&nbsp;--{{$category->category_name}}</option>
                          @foreach($category['subcategories'] as $subcategory)
                            <option value="{{$subcategory->id}}" @if(!empty(@old('category_id')) && $subcategory->id == @old('category_id')) selected="" @elseif(!empty($productData['category_id']) && $productData['category_id']==$subcategory->id) selected="" @endif>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--{{$subcategory->category_name}}</option>
                          @endforeach
                      @endforeach
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                    <label for="users">Select Users</label>
                    <select name="users[]" class="form-control select2" multiple="">
                    <option value="">Select</option>
                    @foreach($users as $user)
                      <option value="{{ $user['email'] }}">{{ $user['email'] }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                    <label for="expiry_date">Expiry Date</label>
                    <input type="text" name="expiry_date" class="form-control" id="expiry_date" placeholder="Enter Expiry Date" value="{{old('expiry_date')}}" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy/mm/dd" data-mask required="">
                </div>
              </div> 
              <!-- /.col -->
           
              <!-- /.col -->
            </div>
            <!-- /.row -->

            
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </form>
        <!-- /.card -->

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection  