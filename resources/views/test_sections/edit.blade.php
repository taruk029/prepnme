@extends('layouts.app')
@section('title', 'Practice Test')
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
                <h5 class="breadcrumbs-title">Edit Assign Section</h5>
                <ol class="breadcrumbs">
                  <li><a href="{{ url('home')}}">Dashboard</a></li>
                  <li><a href="{{ Request::url() }}">Edit Assign Section</a></li>
                </ol>
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
                    <div class="card-panel">
                      <div class="row">
                        <form class="col s12" method="post" action="{{url('update_test_section')}}">
                          {{ csrf_field() }}
                          <div class="row">
                            <div class="input-field col s12">
                                <select name="test" id="test" required="required">
                                  <option value="" selected>Select Test </option>
                                  @foreach($tests as $row)
                                    <option value="{{ $row->id }}" selected="selected">{{ $row->test_name }}</option>
                                  @endforeach
                                </select>
                                 @if ($errors->has('test'))
                                    <strong>{{ $errors->first('test') }}</strong>
                                @endif
                            </div>
                          </div>
                          <h4 class="header2">Please Select Sections</h4><br>
                          <div class="row">
                            @foreach($sections as $row)
                            <div class="col s6 m3">
                              <label class="container_label_check">{{ $row->section }}  ({{"ID- ".$row->id}})
                                  <input type="checkbox" name="section[]" value="{{ $row->id }}" <?php if(in_array($row->id, $section_tests_array)) echo "checked='checked'"; ?> >
                                  <span class="checkmark"></span>
                                </label>
                            </div>
                            @endforeach
                          </div>
                            <div class="row">
                              <div class="input-field col s12">
                                <button class="btn waves-effect waves-light right cyan" type="submit" name="action">Update
                                  <i class="material-icons right">send</i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </form>
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
