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
              <li class="breadcrumb-item active">Products</li>
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

      <form name="categoryForm" id="categoryForm" action="{{route('product.update',$productData->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Edit product</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Select Category</label>
                  <select name="category_id" id="category_id" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach($categories as $section)
                      <optgroup label="{{$section->name}}"></optgroup>
                      @foreach($section['categories'] as $category)
                        <option value="{{$category->id}}" @if(!empty(@old('category_id')) && $category->id == @old('category_id')) selected="" @elseif(!empty($productData->category_id) && $productData->category_id==$category->id) selected="" @endif>&nbsp;&nbsp;&nbsp;--{{$category->category_name}}</option>
                          @foreach($category['subcategories'] as $subcategory)
                            <option value="{{$subcategory->id}}" @if(!empty(@old('category_id')) && $subcategory->id == @old('category_id')) selected="" @elseif(!empty($productData->category_id) && $productData->category_id==$subcategory->id) selected="" @endif>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--{{$subcategory->category_name}}</option>
                          @endforeach
                      @endforeach
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" name="product_name" class="form-control" id="product_name" placeholder="Enter Product Name" value="{{$productData->product_name}}">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label for="product_code">Product Code</label>
                    <input type="text" name="product_code" class="form-control" id="product_code" placeholder="Enter Product Code" value="{{$productData->product_code}}">
                </div>
                <div class="form-group">
                    <label for="product_color">Product Color</label>
                    <input type="text" name="product_color" class="form-control" id="product_color" placeholder="Enter Product Color" value="{{$productData->product_color}}">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label for="product_price">Product Price</label>
                    <input type="number" step="any" min="0" name="product_price" class="form-control" id="product_price" placeholder="Enter Product Price" value="{{$productData->product_price}}">
                </div>
                <div class="form-group">
                    <label for="product_discount">Product Discount(%)</label>
                    <input type="number" min="0" name="product_discount" class="form-control" id="product_discount" placeholder="Enter Product Discount" value="{{$productData->product_discount}}">
                </div>
              </div>  

              <div class="col-md-6">
                <div class="form-group">
                    <label for="product_weight">Product Weight</label>
                    <input type="text" name="product_weight" class="form-control" id="product_weight" placeholder="Enter Product Weight" value="{{$productData->product_weight}}">
                </div>

                <div class="form-group">
                    <label for="product_image">Product Main Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="product_image" name="image" accept = 'image/jpeg , image/jpg, image/gif, image/png, image/svg, image/webp' onchange="previewFile(this)">
                        <label class="custom-file-label" for="product_image">Choose Image</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                </div>
              </div> 

              <div class="col-md-6">
                <div class="form-group">
                    <label for="product_video">Product Video</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="product_video" name="product_video">
                        <label class="custom-file-label" for="product_video">Choose Video</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                </div>
              </div> 

              <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="wash_care">Wash Care</label>
                    <textarea name="wash_care" id="wash_care" class="form-control" rows="3" placeholder="Enter ...">{{$productData->wash_care}}</textarea>
                </div>
              </div>  

              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="description">Product Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter ...">{{$productData->description}}</textarea>
                </div>

                <div class="form-group">
                  <label>Select Fabric</label>
                  <select name="fabric" id="fabric" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach($fabricArray as $fabric)
                      <option value="{{ $fabric }}" @if(!empty($productData->fabric) && $productData->fabric == $fabric) selected="" @endif>{{ $fabric }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Select Occasion</label>
                  <select name="occasion" id="occasion" class="form-control select2" style="width: 100%;">
                    <option value="">Select Occasion</option>
                    @foreach($occasionArray as $occasion)
                      <option value="{{ $occasion }}" @if(!empty($productData->occasion) && $productData->occasion == $occasion) selected="" @endif>{{ $occasion }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label>Select Sleeve</label>
                  <select name="sleeve" id="sleeve" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach($sleeveArray as $sleeve)
                      <option value="{{ $sleeve }}" @if(!empty($productData->sleeve) && $productData->sleeve == $sleeve) selected="" @endif>{{ $sleeve }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Select Pattern</label>
                  <select name="pattern" id="pattern" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach($patternArray as $pattern)
                      <option value="{{ $pattern }}" @if(!empty($productData->pattern) && $productData->pattern == $pattern) selected="" @endif>{{ $pattern }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label>Select Fit</label>
                  <select name="fit" id="fit" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach($fitArray as $fit)
                      <option value="{{ $fit }}" @if(!empty($productData->fit) && $productData->fit == $fit) selected="" @endif>{{ $fit }}</option>
                    @endforeach
                  </select>
                </div>
              </div>


              <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <textarea name="meta_title" id="meta_title" class="form-control" rows="3" placeholder="Enter ...">{{$productData->meta_title}}</textarea>
                </div>
              </div>

              <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="meta_description">Meta Discription</label>
                    <textarea name="meta_description" id="meta_description" class="form-control" rows="3" placeholder="Enter ...">{{$productData->meta_description}}</textarea>
                </div>
              </div>

              <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="meta_keywords">Meta Keywords</label>
                    <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="3" placeholder="Enter ...">{{$productData->meta_keywords}}</textarea>
                </div>

                <div class="form-group">
                    <label for="product_discount">Feature Item</label>
                    <input type="checkbox" name="is_featured" id="is_featured" value="Yes" @if(!empty($productData->is_featured) && $productData->is_featured == "Yes") checked="" @endif>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
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