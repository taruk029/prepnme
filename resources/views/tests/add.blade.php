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
                <h5 class="breadcrumbs-title">Add Test</h5>
                <ol class="breadcrumbs">
                  <li><a href="{{ url('home')}}">Dashboard</a></li>
                  <li><a href="{{ url('add_test')}}">Add Test</a></li>
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
                        <form class="col s12" method="post" action="{{url('add_test')}}">
                           {{ csrf_field() }}
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="test_name" type="text" name="test_name" required="required" value="{{ old('test_name')}}" >
                              <label for="first_name" class="">Test Name</label>
                              <span class="form-text" style="color:red">
                                @if ($errors->has('test_name'))
                                    <strong>{{ $errors->first('test_name') }}</strong>
                                @endif
                            </span>
                            </div>
                          </div>
                         <!--  <div class="row">
                            <div class="input-field col s12">
                                <select id="user_category" name="user_category" >
                                  <option value="">Select User Type</option>
                                  <option value="1">Free</option>
                                  <option value="2">Premium</option>
                                </select>
                                <span class="form-text" style="color:red">
                                @if ($errors->has('user_category'))
                                    <strong>{{ $errors->first('user_category') }}</strong>
                                @endif
                            </span>
                            </div>
                          </div> -->
                          <div class="row">
                            <div class="input-field col s12">
                                <select id="membership_level" name="membership_level" required="required">
                                  <option value="">Select Membership Level</option>
                                  @if($membership_level)
                                    @foreach($membership_level as $rowr)
                                      <option value="{{ $rowr->id }}">{{ $rowr->name }}</option>
                                    @endforeach
                                  @endif
                                </select>
                                <span class="form-text" style="color:red">
                                @if ($errors->has('membership_level'))
                                    <strong>{{ $errors->first('membership_level') }}</strong>
                                @endif
                            </span>
                            </div>
                          </div>
                            <div class="row">
                              <div class="input-field col s12">
                                <button class="btn waves-effect waves-light right cyan" type="submit" name="action">Submit
                                  <i class="material-icons right">send</i>
                                </button>
                              </div>
                            </div>
                        </form>
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
