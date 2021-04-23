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
              <li class="breadcrumb-item active">Shipping Charges</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
              @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                  {{ Session::get('success') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              @endif

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Shipping Charges</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="shipping_charges" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Order Id</th>
                    <th>Country</th>
                    <th>Shipping Charges</th>
                    <th>Status</th>
                    <th>Update at</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($shipping_charges as $shipping)	 
                  <tr>
                    <td>{{ $shipping['id'] }}</td>
                    <td>{{ $shipping['country'] }}</td>
                    <td>{{ $shipping['shipping_charges'] }}</td>
                    <td>
                    	@if($shipping['status'] == 1) 
                    		<a class="updateShippingStatus" id="shipping-{{ $shipping['id'] }}" shipping_id="{{ $shipping['id'] }}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                    	@else
                    		<a class="updateShippingStatus" id="shipping-{{ $shipping['id'] }}" shipping_id="{{ $shipping['id'] }}" href="javascript:void(0)"><i class="fa fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                    	@endif		
                    </td>
                    <td>{{ date('d-m-Y', strtotime($shipping['updated_at'])) }}</td>
                    <td>
                    	<a title="Update Shipping Charges" href="{{ url('admin/edit-shipping-charges/'.$shipping['id']) }}"><i class="fas fa-edit"></i></a>
                    </td>
                  </tr>
                  @endforeach  
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
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection  