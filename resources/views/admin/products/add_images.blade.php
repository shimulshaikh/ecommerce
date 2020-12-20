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
              <li class="breadcrumb-item active">Product Images</li>
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

      <form name="imageForm" id="imageForm" action="{{route('addImage',$productData->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Add Product Image</h3>

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
                          <input multiple="" type="file" value="" name="images[]" id="images" required="">
                      </div>
                  </div>
              </div>
            </div>
            <!-- /.row -->
            <!-- /.row -->
          </div>
        </div>


          <!-- /.card-body -->
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Add Images</button>
          </div>
      </div>
      </form>
        
      <form name="editAttributeForm" id="editAttributeForm" method="post" action="{{route('editAttributes',$productData->id)}}">
        @csrf
          <div class="card">
              <div class="card-header">
                <h3 class="card-title">Added Product Images</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="products" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Image</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($productData['images'] as $images)  
                  <input style="display: none;" type="text" name="attrId[]" value="{{ $images->id }}">
                  <tr>
                    <td>{{ $images->id }}</td>
                    <td>
                      <img style="width: 120px;" src="{{ asset('/storage/product/small') }}/{{ $images->image  }}">
                    </td>
                    <td>
                      @if($images->status == 1) 
                        <a class="updateImageStatus" id="images-{{ $images->id }}" images_id="{{ $images->id }}" href="javascript:void(0)">Active</a>
                      @else
                        <a class="updateImageStatus" id="images-{{ $images->id }}" images_id="{{ $images->id }}" href="javascript:void(0)">Inactive</a>
                      @endif
                      &nbsp;
                      <a title="Delete" onclick="return confirm('Are You sure want to delete !')" href="{{route('destroyImage',$images->id)}}"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                  @endforeach  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <!-- <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update Attributes</button>
              </div> -->
          </div>
      </form>  

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection  