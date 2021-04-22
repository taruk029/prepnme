@extends('layouts.app')

@section('content')
     <section id="content">
       <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
          <!-- Search for small screen -->
          <div class="header-search-wrapper grey lighten-2 hide-on-large-only">
            <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
          </div>
          <div class="container">
            <div class="row">
              <div class="col s10 m6 l6">
                <h5 class="breadcrumbs-title">Tests</h5>
                <ol class="breadcrumbs">
                  <li><a href="{{ url('home')}}">Dashboard</a></li>
                  <li><a href="{{ url('categories')}}">Tests</a></li>
                </ol>
              </div>
              <div class="col s2 m6 l6">
                <a class="btn waves-effect waves-light breadcrumbs-btn cyan right" href="{{ url('add_test') }}">Add New Test
                  <i class="material-icons left">add</i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->
          <!--start container-->
          <div class="container">
            <div id="work-collections">
              <div class="row">
                <div class="col s12 m12 l12">
                  <div class="col s12">
                    <div class="card-panel">
                  <div id="responsive-table">
                    <div class="row">
                      <div class="col s12">
                        <table id="table_id" class=" display responsive-table">
                          <thead>
                            <tr>
                              <th data-field="name">Test</th>
                              <!-- <th data-field="name">For Users</th> -->
                              <th data-field="price">Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($tests as $row)
                            <tr>
                              <td>{{ $row->test_name }}</td>
                             <!--  <td>{{ $row->user_category }}</td> -->
                              <td>
                                <a href="{{url('edit_test/'.$row->id)}}" title="Edit Test">
                                  <i class="material-icons left">edit</i>
                                </a>
                                <a href="{{url('delete/'.$row->id)}}" title="Delete Test" onclick="return confirm('Are you sure to delete the test!');"> <i class="material-icons left">delete_forever</i>
                                </a>
                                @if($row->is_bulk_uploaded==1)
                                  <a target="_blank" href="{{url('get_log/'.$row->id)}}" title="Show Log">
                                    <i class="material-icons left">library_books</i>
                                  </a>
                                @endif
                                <!-- @if($row->is_active == 1)
                                  <a href="{{url('deactivate_test/'.$row->id)}}" title="Make Inactive">
                                    <i class="material-icons left">clear</i>
                                  </a>
                                @else
                                  <a href="{{url('deactivate_test/'.$row->id)}}" title="Make Active">
                                    <i class="material-icons left">check</i>
                                  </a>
                                @endif -->
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  </div>
                  </div>
                  </div>
                </div>
              </div>
            
            <!-- //////////////////////////////////////////////////////////////////////////// -->
          </div>
          <!--end container-->
        </section>
@endsection
