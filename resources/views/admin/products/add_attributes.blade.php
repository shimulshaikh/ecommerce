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
              <li class="breadcrumb-item active">Product Attributes</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

              @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                  {{ Session::get('error') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              @endif

              @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                  {{ Session::get('success') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              @endif

              @if ($errors->any())
                  <div class="alert alert-danger" style="margin-top: 10px;">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif

      <form name="attributeForm" id="attributeForm" action="{{route('addAttributes',$productData->id)}}" method="post" enctype="multipart/form-data">
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
                    <label for="product_name">Product Name:</label>&nbsp;{{$productData->product_name}}
                </div>
              
                <div class="form-group">
                    <label for="product_code">Product Code:</label>&nbsp; {{$productData->product_code}}
                </div>
                <div class="form-group">
                    <label for="product_color">Product Color:</label>&nbsp; {{$productData->product_color}}
                </div>

              <!-- /.col -->
            </div>
            <div class="col-md-6">
              <div class="form-group">
                    <div class="input-group">
                      @if(!empty($productData->main_image))
                        <img style="width: 120px;" src="{{ asset('/storage/product/small') }}/{{ $productData->main_image  }}">
                      @else
                        <img style="width: 120px;" src="{{asset('backend/dist/img/No_Image.jpg')}}">
                      @endif  
                    </div>
                </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                  <div class="field_wrapper">
                      <div>
                          <input id="size" name="size[]" type="text" name="size[]" value="" placeholder="Size" step="" style="width: 100px;" required="" />
                          <input id="sku" name="sku[]" type="text" value="" placeholder="sku" style="width: 100px;" required="" />
                          <input id="price" name="price[]" type="number" min="0" value="" placeholder="price" style="width: 100px;" required="" />
                          <input id="stock" name="stock[]" type="number" min="0" value="" placeholder="stock" style="width: 100px;" required="" />
                          <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                      </div>
                  </div>
              </div>
            </div>
            <!-- /.row -->
            <!-- /.row -->
          </div>


          <!-- /.card-body -->
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </form>
        

      <div class="card">
              <div class="card-header">
                <h3 class="card-title">Added Product Attributs</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="products" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Size</th>
                    <th>SKU</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($productData['attributes'] as $attribute)  
                  <tr>
                    <td>{{ $attribute->id }}</td>
                    <td>{{ $attribute->size }}</td>
                    <td>{{ $attribute->sku }}</td>
                    <td>{{ $attribute->price }}</td>
                    <td>{{ $attribute->stock }}</td>
                    <td></td>
                  </tr>
                  @endforeach  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
        

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection  