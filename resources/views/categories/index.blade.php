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
                <h5 class="breadcrumbs-title">Categories</h5>
                <ol class="breadcrumbs">
                  <li><a href="{{ url('home')}}">Dashboard</a></li>
                  <li><a href="{{ url('question_types')}}">Categories</a></li>
                </ol>
              </div>
              <div class="col s2 m6 l6">
                <a class="btn waves-effect waves-light breadcrumbs-btn cyan right" href="{{ url('add_category') }}" style="display: none;">Add New Category
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
                              <th data-field="name">Category Id</th>
                              <th data-field="name">Categories</th>
                             <!--  <th data-field="price">Actions</th> -->
                            </tr>
                          </thead>
                          <tbody>
                            @if($category)
                              @foreach($category as $row)
                              <tr>
                              <td>{{ $row->id }}</td>
                              <td>{{ $row->category }}</td>
                              <!-- <td>
                                <!-- <a href="{{url('edit_category/'.$row->id)}}" title="Edit Category">
                                  <i class="material-icons left">edit</i>
                                </a> -->
                                <!-- @if($row->is_active==1)
                                <a href="{{url('deactivate_category/'.$row->id)}}" title="Make Inactive">
                                  <i class="material-icons left">clear</i>
                                </a>
                                @else
                                  <a href="{{url('edit_employee/'.$row->id)}}" title="Make Inactive">
                                  <i class="material-icons left">check</i>
                                  </a>
                                @endif -->
                              <!-- </td> -->
                            </tr>
                            @endforeach
                            @endif
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
