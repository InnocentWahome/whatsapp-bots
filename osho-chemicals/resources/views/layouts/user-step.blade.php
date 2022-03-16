@extends('layouts.admin')

@section('content')
   <!-- Content Header (Page header) -->
   <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">User Bot Steps</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">User Steps</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">User Session Steps Table</h3>

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
                          <th>Message</th>
                          <th>Bot Session Step</th>
                        </tr>
                      </thead>

                      <tbody>
                        @foreach ($user_steps as $item)
                        <tr>
                          <td>{{$item->id}}</td>
                          <td>{{$user->userName}}</td>
                          <td>{{$item->message}}</td>
                          <td>{{$item->botSessionStep}}</td>
                        </tr>
                        @endforeach

                      </tbody>

                  </table>
                  <div class="d-flex justify-content-center">
                    {{$user_steps->links()}}
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
