<?php use App\Product;?>
@extends('layouts.admin_layouts.admin_layout')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            @if(Session::has('success'))
              <div class="col-sm-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                  {{ Session::get('success') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>  
                {{ Session::forget('success') }}
            @endif
          <div class="col-sm-6">
            <h1>Orders</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Order #{{ $orderDetails['id'] }} Detail</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Order Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                 
                  <tbody>
                    <tr>
                      <td>Order Date</td>
                      <td>{{ date('d-m-Y', strtotime($orderDetails['created_at'])) }}</td>
                    </tr>
                    <tr>
                      <td>Order Status</td>
                      <td>{{ $orderDetails['order_status'] }}</td>
                    </tr>
                    <tr>
                      <td>Order Total</td>
                      <td>{{ $orderDetails['grand_total'] }}</td>
                    </tr>
                    <tr>
                      <td>Shipping Changes</td>
                      <td>{{ $orderDetails['shipping_charges'] }}</td>
                    </tr>
                    <tr>
                      <td>Coupon Code</td>
                      <td>{{ $orderDetails['coupon_code'] }}</td>
                    </tr>
                    <tr>
                      <td>Coupon Amount</td>
                      <td>{{ $orderDetails['coupon_amount'] }}</td>
                    </tr>
                    <tr>
                      <td>Payment Method</td>
                      <td>{{ $orderDetails['payment_method'] }}</td>
                    </tr>
                    <tr>
                      <td>Payment Gateway</td>
                      <td>{{ $orderDetails['payment_gateway'] }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Details Address</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>Name</td>
                      <td>{{ $orderDetails['name'] }}</td>
                    </tr>
                    <tr>
                      <td>Address</td>
                      <td>{{ $orderDetails['address'] }}</td>
                    </tr>
                    <tr>
                      <td>City</td>
                      <td>{{ $orderDetails['city'] }}</td>
                    </tr>
                    <tr>
                      <td>State</td>
                      <td>{{ $orderDetails['state'] }}</td>
                    </tr>
                    <tr>
                      <td>Country</td>
                      <td>{{ $orderDetails['country'] }}</td>
                    </tr>
                    <tr>
                      <td>Mobile</td>
                      <td>{{ $orderDetails['mobile'] }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Customer Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>Name</td>
                      <td>{{ $userDetails['name'] }}</td>
                    </tr>
                    <tr>
                      <td>Email</td>
                      <td>{{ $userDetails['email'] }}</td>
                    </tr>
                    <tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Billing Address</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>Name</td>
                      <td>{{ $userDetails['name'] }}</td>
                    </tr>
                    <tr>
                      <td>Address</td>
                      <td>{{ $userDetails['address'] }}</td>
                    </tr>
                    <tr>
                      <td>City</td>
                      <td>{{ $userDetails['city'] }}</td>
                    </tr>
                    <tr>
                      <td>State</td>
                      <td>{{ $userDetails['state'] }}</td>
                    </tr>
                    <tr>
                      <td>Country</td>
                      <td>{{ $userDetails['country'] }}</td>
                    </tr>
                    <tr>
                      <td>Mobile</td>
                      <td>{{ $userDetails['mobile'] }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>


            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Update Order Status</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td colspan="2">
                        <form action="{{ url('admin/update-order-status') }}" method="post">
                          @csrf
                        <input type="hidden" name="order_id" value="{{$orderDetails['id']}}">  
                        <select name="order_status" required="">
                          @foreach($orderStatus as $status)
                            <option value="{{ $status['name'] }}" @if(isset($orderDetails['order_status']) && $orderDetails['order_status']==$status['name']) selected="" @endif>{{ $status['name'] }}</option>
                          @endforeach
                        </select>&nbsp;&nbsp;
                        <button type="submit" >Update</button>
                        </form>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Order Products</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Product Image</th>
                      <th>Product Code</th>
                      <th>Product Name</th>
                      <th>Product Size</th>
                      <th>Product Color</th>
                      <th>Product Qty</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($orderDetails['orders_product'] as $product)
                      <tr>
                        <td><?php $getProductImage = Product::getProductImage($product['product_id'])?>
                        
                        <a target="_blank" href="{{ url('product/'.$product['product_id']) }}">
                          <img style="width: 88px;" src="{{ asset('/storage/product/small/'.$getProductImage) }}">
                        </a>  
                        </td>
                        <td>{{ $product['product_code'] }}</td>
                        <td>{{ $product['product_name'] }}</td>
                        <td>{{ $product['product_size'] }}</td>
                        <td>{{ $product['product_color'] }}</td>
                        <td>{{ $product['product_qty'] }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->

        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>  

  </div>
  <!-- /.content-wrapper -->

@endsection  