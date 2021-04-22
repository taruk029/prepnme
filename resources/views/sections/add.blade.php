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
                <h5 class="breadcrumbs-title">Add Section</h5>
                <ol class="breadcrumbs">
                  <li><a href="{{ url('home')}}">Dashboard</a></li>
                  <li><a href="{{ url('add_section')}}">Add Section</a></li>
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
                        <form class="col s12" method="post" action="{{url('add_section')}}">
                          {{ csrf_field() }}
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="section" type="text" name="section" required="required" maxlength="255" value="{{old('section')}}">
                              <label for="first_name" class="">Section Name</label>
                               @if ($errors->has('section'))
                                    <strong>{{ $errors->first('section') }}</strong>
                                @endif
                            </div>
                          </div>                          
                          <div class="row">
                            <div class="input-field col s12">
                              <select name="difficulty_level" id="difficulty_level" required="required">
                                <option value="" >Select Difficulty Level</option>
                                <option value="1">Easy</option>
                                <option value="2">Medium</option>
                                <option value="3">Hard</option>
                              </select>
                               @if ($errors->has('difficulty_level'))
                                    <strong>{{ $errors->first('difficulty_level') }}</strong>
                                @endif
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="duration_in_mins" type="text" name="duration_in_mins" onkeypress="return NumbersOnly(event,this)" maxlength="3" required="required" value="{{old('duration_in_mins')}}">
                              <label for="first_name" class="">Duration In Minutes</label>
                               @if ($errors->has('duration_in_mins'))
                                    <strong>{{ $errors->first('duration_in_mins') }}</strong>
                                @endif
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <textarea id="description" class="materialize-textarea" name="description" >{{old('description')}}
                              </textarea>
                              <label for="first_name" class="">Description</label>
                            </div>
                          </div>
                            <div class="row">
                              <div class="input-field col s12">
                                <button class="btn waves-effect waves-light right cyan" type="submit" name="action">Submit
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
