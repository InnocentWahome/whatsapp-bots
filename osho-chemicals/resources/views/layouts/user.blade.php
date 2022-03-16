@extends('layouts.admin')

@section('content')
   <!-- Content Header (Page header) -->
   <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Users</h1>

        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Users</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">User Table</h3>

                  <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">

                  <table class="table table-hover text-nowrap">

                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>User</th>
                          <th>Phone Number</th>
                          <th>Created At</th>
                        </tr>
                      </thead>
                      @foreach ($users as $user)
                      <tbody>
                        <tr>
                          <td>{{$user->id}}</td>
                          <td>{{$user->userName}}</td>
                          <td>{{$user->phoneNumber}}</td>
                          <td>{{$user->created_at}}</td>
                        </tr>
                      </tbody>
                      @endforeach

                  </table>
                  <div class="d-flex justify-content-center">
                    {{$users->links()}}
                </div>
                </div>

                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection
