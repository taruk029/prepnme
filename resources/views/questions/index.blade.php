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
                <h5 class="breadcrumbs-title">Questions</h5>
                <ol class="breadcrumbs">
                  <li><a href="{{ url('home')}}">Dashboard</a></li>
                  <li><a href="{{ url('questions')}}">Questions</a></li>
                </ol>
              </div>
              <div class="col s2 m6 l6">
                <a class="btn waves-effect waves-light breadcrumbs-btn cyan right" href="{{ url('add_question') }}">Add New Question
                  <i class="material-icons left">add</i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->
          <!--start container-->
          <div class="container">
            <!-- <div id="work-collections">
              <div class="row">
              <div class="col s12 m12 l12">
                <div class="card-panel">
                  <div class="row">
                    <form class="col s12" >
                      <h4 class="header2">Search</h4>
                      <div class="row">
                        <div class="input-field col s4">
                          <select class="validate">
                            <option value="" disabled selected>Select Question Type</option>
                            @foreach($question_types as $row)
                              <option value="{{ $row->id }}">{{ $row->question_type }}</option>
                            @endforeach
                          </select>
                        </div>
                        
                      </div>
                      <div class="row">
                              <div class="input-field col s12">
                                <button class="btn waves-effect waves-light right cyan" type="submit" name="action">Search
                                  <i class="material-icons right">youtube_searched_for</i>
                                </button>
                              </div>
                            </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            </div>
 -->

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
                              <th data-field="name">Section</th>
                              <th data-field="name">Question</th>
                              <th data-field="name">Category</th>
                              <th data-field="name">Question Type</th>
                              <th data-field="name">Difficulty Level</th>
                              <th data-field="price">Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($questions as $rowq)
                            <tr>
                              <td>{{ $rowq->test_name }}</td>
                              <td>{{ $rowq->section }}</td>
                              <td><?php echo $rowq->question ?></td>
                              <td>{{ $rowq->category }}</td>
                              <td>{{ $rowq->question_type }}</td>
                              <td>{{ $rowq->difficulty_level }}</td>
                              <td>
                                <a href="{{url('edit_question/'.$rowq->id)}}" title="Edit Question">
                                  <i class="material-icons left">edit</i>
                                </a>
                                 <a href="{{url('delete_question/'.$rowq->id)}}" title="Delete Question" onclick="return confirm('This question will be permanently deleted from the test. Are you sure to delete the question!');">
                                    <i class="material-icons left">delete_forever</i>
                                  </a>
                                <!-- @if($rowq->is_active == 1)
                                  <a href="{{url('deactivate_category/'.$rowq->id)}}" title="Make Inactive">
                                    <i class="material-icons left">clear</i>
                                  </a>
                                @else
                                  <a href="{{url('deactivate_category/'.$rowq->id)}}" title="Make Active">
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
          </div>
          <!--end container-->
        </section>
@endsection
