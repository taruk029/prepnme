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
                <h5 class="breadcrumbs-title">Add Question</h5>
                <ol class="breadcrumbs">
                  <li><a href="{{ url('home')}}">Dashboard</a></li>
                  <li><a href="{{ url('add_question')}}">Add Question</a></li>
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
                        <form class="col s12" method="post" action="{{url('add_question')}}" enctype="multipart/form-data">
                          {{ csrf_field() }}
                          <div class="row">
                            <div class="input-field col s12">
                                <select name="question_type" id="question_type" required="required" onchange="javascript:check_question_type()">
                                  <option value="">Select Question Type </option>
                                  @foreach($question_types as $row)
                                    <option value="{{ $row->id }}">{{ $row->question_type }}</option>
                                  @endforeach
                                </select>
                                 @if ($errors->has('question_types'))
                                    <strong>{{ $errors->first('question_types') }}</strong>
                                @endif
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <select name="difficulty_level" id="difficulty_level" required="required">
                                <option value="" >Select Difficulty Level</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                              </select>
                               @if ($errors->has('difficulty_level'))
                                    <strong>{{ $errors->first('difficulty_level') }}</strong>
                                @endif
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <select name="category" id="category" required="required">
                                <option value="">Select Category</option>
                                @foreach($category as $row)
                                    <option value="{{ $row->id }}">{{ $row->category }}</option>
                                  @endforeach
                              </select>
                               @if ($errors->has('category'))
                                    <strong>{{ $errors->first('category') }}</strong>
                                @endif
                            </div>
                          </div>                          
                          <div class="row">

                            <div class="input-field col s12">
                              <textarea id="question" class="materialize-textarea" name="question" >{{old('question')}}
                              </textarea>
                              <label for="first_name" class="">Question</label>
                               @if ($errors->has('question'))
                                    <strong>{{ $errors->first('question') }}</strong>
                                @endif
                            </div>
                          </div>
                          <div id="answers_div" style="display: none;">
                          <div class="row">
                            <div class="input-field col s2">
                              <input type="radio" id="radio-one" name="is_correct" class="form-radio" value="1" onclick="javascript:check_this('one')">
                              <label for="radio-one">Correct</label>
                            </div>
                            <div class="input-field col s10">
                              <input id="answer_one" type="text" name="one" value="{{old('answer_one')}}">
                              <label for="first_name" class="" style="color: #000000;">Answer Option 1</label>
                               @if ($errors->has('answer_one'))
                                    <strong>{{ $errors->first('answer_one') }}</strong>
                                @endif
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s2">
                              <input type="radio" id="radio-two" name="is_correct" class="form-radio" value="2" onclick="javascript:check_this('two')">
                              <label for="radio-two">Correct</label>
                              </label>
                            </div>
                            <div class="input-field col s10">
                              <input id="answer_two" type="text" name="two" value="{{old('answer_two')}}">
                              <label for="first_name" class="" style="color: #000000;">Answer Option 2</label>
                               @if ($errors->has('answer_two'))
                                    <strong>{{ $errors->first('answer_two') }}</strong>
                                @endif
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s2">
                              <input type="radio" id="radio-three" name="is_correct" class="form-radio" value="3" onclick="javascript:check_this('three')">
                              <label for="radio-three">Correct</label>
                              </label>
                            </div>
                            <div class="input-field col s10">
                              <input id="answer_three" type="text" name="three" value="{{old('answer_three')}}">
                              <label for="first_name" class="" style="color: #000000;">Answer Option 3</label>
                               @if ($errors->has('answer_three'))
                                    <strong>{{ $errors->first('answer_three') }}</strong>
                                @endif
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s2">
                              <input type="radio" id="radio-four" name="is_correct" class="form-radio" value="4" onclick="javascript:check_this('four')">
                              <label for="radio-four">Correct</label>
                              </label>
                            </div>
                            <div class="input-field col s10">
                              <input id="answer_four" type="text" name="four" value="{{old('answer_four')}}">
                              <label for="answer_four" class="" style="color: #000000;">Answer Option 4</label>
                               @if ($errors->has('question'))
                                    <strong>{{ $errors->first('answer_four') }}</strong>
                                @endif
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s2">
                              <input type="radio" id="radio-five" name="is_correct" class="form-radio" value="5" onclick="javascript:check_this('five')">
                              <label for="radio-five">Correct</label>
                            </div>
                            <div class="input-field col s10">
                              <input id="answer_five" type="text" name="five" value="{{old('answer_five')}}">
                              <label for="first_name" class="" style="color: #000000;">Answer Option 5</label>
                               @if ($errors->has('answer_five'))
                                    <strong>{{ $errors->first('answer_five') }}</strong>
                                @endif
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <textarea id="description" class="materialize-textarea" name="description" >{{old('description')}}
                              </textarea>
                              <label for="first_name" class="">Resolution Description</label>
                            </div>
                          </div>
                          </div>
                          <input id="correct_answer" type="hidden" name="correct_answer" value="">
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="average_time" type="text" name="average_time" value="{{old('average_time')}}" onkeypress="return NumbersOnly(event,this)">
                              <label for="first_name" class="">Average Time ( in minutes )</label>
                               @if ($errors->has('average_time'))
                                    <strong>{{ $errors->first('average_time') }}</strong>
                                @endif
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input type="file" name="images" id="images" title="Question Image">                              
                            </div>
                          </div>
                          
                          <div class="row">
                            <div class="input-field col s12">
                              <label for="radio-five" style="color: #000000;">Place Image</label><br>
                              <div class="input-field col s4">
                              <input type="radio" id="before" name="place" class="form-radio" value="1" checked="checked" onclick="javascript:check_image_this(1)">
                              <label for="radio-five" style="color: #000000;">Before Question</label> 
                            </div>
                            <div class="input-field col s4">
                              <input type="radio" id="after" name="place" class="form-radio" value="2" onclick="javascript:check_image_this(2)">
                              <label for="radio-five" style="color: #000000;">After Question</label>     
                              </div>                       
                            </div>
                          </div>
                          <input id="place_image" type="hidden" name="place_image" value="1">
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

<script>
    function check_question_type()
    {
      $("#answers_div").css("display", "none");
      var qst_type = $('#question_type').val();
      $('#answer_one').val('');
      $('#answer_two').val('');
      $('#answer_three').val('');
      $('#answer_four').val('');
      $('#answer_five').val('');
      $("#correct_answer").val('');
      $("#description").html('');
      $(".form-radio").prop("checked", false);
      if(qst_type!="")
      {
        if(qst_type==2)
        {
          $("#answers_div").css("display", "block");
        }
      }
    }

    function check_this(id)
    {
      $("#correct_answer").val(id);
    }
    function check_image_this(id)
    {
      $("#place_image").val(id);
    }
</script>