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
              <li class="breadcrumb-item active">Banner</li>
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
            
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Banner</h3>
                <a href="{{route('banner.create')}}" style="max-width: 150px; float: right; display: inline-block;" class="btn btn-block btn-success">Add Brand</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="banners" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Link</th>
                    <th>Title</th>
                    <th>Alt</th>
                    <th>Image</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($banners as $banner)	
                  <tr>
                    <td>{{ $banner->id }}</td>
                    <td>{{ $banner->link }}</td>
                    <td>{{ $banner->title }}</td>
                    <td>{{ $banner->alt }}</td>
                    <td>
                      @if(!empty($banner->image))
                        <img style="width: 90px;" src="{{ asset('/storage/banner') }}/{{ $banner->image  }}">
                      @else
                        <img style="width: 90px;" src="{{asset('backend/dist/img/No_Image.jpg')}}">
                      @endif
                    </td>
                    <td>
                      <a title="Edit" href="{{route('banner.edit', $banner->id)}}"><i class="fas fa-edit"></i></a>
                      &nbsp;
                      <a title="Delete" record="banner" record_id="{{$banner->id}}" class="confirmDelete" href="javascript:void(0)"><i class="fas fa-trash"></i></a>
                      &nbsp;
                    	@if($banner->status == 1) 
                    		<a class="updateBannerStatus" id="banner-{{ $banner->id }}" banner_id="{{ $banner->id }}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                    	@else
                    		<a class="updateBannerStatus" id="banner-{{ $banner->id }}" banner_id="{{ $banner->id }}" href="javascript:void(0)"><i class="fa fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                    	@endif		
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