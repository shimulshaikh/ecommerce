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
              <li class="breadcrumb-item active">Categories</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

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

      <form name="categoryForm" id="categoryForm" action="{{route('category.update',$categories->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Update Category</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">

                <div class="form-group">
                    <label for="category_name">Category Name *</label>
                    <input type="text" name="category_name" class="form-control" id="category_name" placeholder="Enter Category Name" value="{{$categories->category_name}}">
                </div>

                <div id="appendCategorisLevel">
                  @include('admin.categories.edit_append_categoris_level')
                </div>

              </div>
              <!-- /.col -->
              <div class="col-md-6">
                
                <div class="form-group">
                  <label>Select Section *</label>
                  <select name="section_id" id="section_id" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach($sections as $section)
                      <option value="{{$section->id}}" {{ ($section->id == $categories->section_id) ? 'selected' : '' }}>{{ $section->name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                    <label for="category_image">Category Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="category_image" name="image" accept = 'image/jpeg , image/jpg, image/gif, image/png, image/svg, image/webp' onchange="previewFile(this)">
                        <label class="custom-file-label" for="category_image">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                    @if($categories->category_image != 'default.png')
                      <div>
                        <img style="width: 80px; margin-top: 5px;" src="{{ asset('/storage/category_image') }}/{{ $categories->category_image  }}">
                        &nbsp; <a onclick="return confirm('Are You sure want to delete !')" href="{{route('deleteCategoryImage',$categories->id)}}">Delete Image</a>
                      </div>  
                    @endif
                </div>

              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <div class="col-12 col-sm-6">

                <div class="form-group">
                    <label for="category_discount">Category Discount</label>
                    <input type="number" step="any" min="0" name="category_discount" class="form-control" id="category_discount" placeholder="Enter Category Name" value="{{$categories->category_discount}}">
                </div>

                <div class="form-group">
                    <label for="description">Category Discription</label>
                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter ...">{{$categories->description}}</textarea>
                </div>

              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-6">

                <div class="form-group">
                    <label for="url">Meta URL *</label>
                    <input type="text" name="url" class="form-control" id="url" placeholder="Enter Category Name" value="{{$categories->url}}">
                </div>

                <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <textarea name="meta_title" id="meta_title" class="form-control" rows="3" placeholder="Enter ...">{{$categories->meta_title}}</textarea>
                </div>

              </div>


              <div class="col-12 col-sm-6">

                <div class="form-group">
                    <label for="meta_description">Meta Discription</label>
                    <textarea name="meta_description" id="meta_description" class="form-control" rows="3" placeholder="Enter ...">{{$categories->meta_description}}</textarea>
                </div>

              </div>

              <div class="col-12 col-sm-6">

                <div class="form-group">
                    <label for="meta_keywords">Meta Keywords</label>
                    <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="3" placeholder="Enter ...">{{$categories->meta_keywords}}</textarea>
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