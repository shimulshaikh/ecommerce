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
              <li class="breadcrumb-item active">Banners</li>
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

      <form name="bannerForm" id="bannerForm" action="{{route('banner.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Add Banner</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label for="image">Banner Image *</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image" accept = 'image/jpeg , image/jpg, image/gif, image/png, image/svg, image/webp' onchange="previewFile(this)">
                        <label class="custom-file-label" for="image">Choose Image</label>
                      </div>
                    </div>
                </div>

              
                <div class="form-group">
                    <label for="title">Banner Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter Banner Title" value="{{old('title')}}">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label for="link">Banner Link</label>
                    <input type="text" name="link" class="form-control" id="link" placeholder="Enter Banner Link" value="{{old('link')}}">
                </div>
                <div class="form-group">
                    <label for="alt">Banner Alternate Text</label>
                    <input type="text" name="alt" class="form-control" id="alt" placeholder="Enter Banner Alternate Text" value="{{old('alt')}}">
                </div>
              </div> 

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