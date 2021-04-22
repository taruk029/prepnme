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
                        <form class="col s12" method="post" action="{{url('add_bulk_test')}}" id="bulk_form" enctype="multipart/form-data">
                           {{ csrf_field() }}
                          <div class="row">
                            <div class="input-field col s12">
                                <select name="test" id="test" required="required" onchange="javascript:get_test()">
                                  <option value="" selected>Select Test </option>
                                  <option value="-1">Create New Test</option>
                                  @foreach($tests as $row)
                                    <option value="{{ $row->id }}">{{ $row->test_name }}</option>
                                  @endforeach
                                </select>
                                 @if ($errors->has('test'))
                                    <strong>{{ $errors->first('test') }}</strong>
                                @endif
                            </div>
                          </div>
                          <input type="hidden" name="testid" id="_testid">
                          <div class="row" id="test_name_id" style="display: none;">
                            <div class="input-field col s12">
                              <input id="test_name" type="text" name="test_name" value="{{ old('test_name')}}" >
                              <label for="first_name" class="">Test Name</label>
                              <span class="form-text" style="color:red">
                                @if ($errors->has('test_name'))
                                    <strong>{{ $errors->first('test_name') }}</strong>
                                @endif
                            </span>
                            </div>
                          </div>
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
                          </div>

                          <div class="row" style="border-top: 1px solid #eee; padding: 10px;">
                            <div class="row" style="margin-bottom: 30px;  ">
                              <div class="col s10 m6 l6">
                                <h5 class="breadcrumbs-title">Sections</h5>
                              </div>
                              <div class="col s2 m6 l6">
                                <a class="btn waves-effect waves-light breadcrumbs-btn cyan right waves-effect waves-light btn modal-trigger" href="#modal1" style="margin-left: 5px;">Add New Section
                                  <i class="material-icons left">add</i>
                                </a>
                              </div>
                            </div>
                             <div class="col s12">
                                <table id="table_id" class=" display responsive-table">
                                  <thead>
                                    <tr>
                                      <th data-field="name">Sections</th>
                                      <th data-field="name">Duration (in mins)</th>
                                      <th data-field="name">Difficulty Level</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  
                                  </tbody>
                                </table>
                              </div>
                          </div>

                          <div class="row" style="border-top: 1px solid #eee; padding: 10px;">
                            <h5 class="breadcrumbs-title">Upload Excel</h5>
                            <div class="row">
                            <div class="input-field col s12">
                              <input type="file" name="bulk_excel" id="bulk_excel_file" title="Bulk Upload Excel" required="required">                              
                            </div>
                          </div>
                          </div>
                      </div>
                    </div>
                  </div>
                    <div class="row">
                              <div class="input-field col s12">
                                <button class="btn waves-effect waves-light right cyan" onclick="javascript:submit_upload()"  type="button" name="action">Submit
                                  <i class="material-icons right">send</i>
                                </button>
                              </div>
                            </div>
                        </form>
               </div>
            
            <!-- //////////////////////////////////////////////////////////////////////////// -->
          </div>
           <!-- Modal Structure -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <div class="row">
        <h5 class="breadcrumbs-title">Add Section</h5>
                        <form class="col s12" method="post" id = "form_id">
                          {{ csrf_field() }}
                          <div class="row">
                            <div class="input-field col s6">
                              <input id="section" type="text" name="Section" required="required" maxlength="255" value="{{old('section')}}">
                              <label for="first_name" class="">Section Name</label>
                               @if ($errors->has('section'))
                                    <strong>{{ $errors->first('section') }}</strong>
                                @endif
                            </div>
                            <div class="input-field col s6">
                              <select name="Difficulty Level" id="difficulty_level" required="required">
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
                            <div class="input-field col s6">
                              <input id="duration_in_mins" type="text" name="Duration in mins" onkeypress="return NumbersOnly(event,this)" maxlength="3" required="required" value="{{old('duration_in_mins')}}">
                              <label for="first_name" class="">Duration In Minutes</label>
                               @if ($errors->has('duration_in_mins'))
                                    <strong>{{ $errors->first('duration_in_mins') }}</strong>
                                @endif
                            </div>
                            <div class="input-field col s6">
                              <input id="description" type="text" name="description" value="{{old('description')}}">
                              <label for="first_name" class="">Description</label>
                            </div>
                          </div>
                          </div>
    </div>
    <div class="modal-footer">
      <input type="button" name="" class="modal-close waves-effect waves-red btn-flat" value="Close">
      <input type="button" name="" class="waves-effect waves-green btn-flat" onclick="javascript:submit_section()" value="Submit">
    </div>
  </div>
    <!--end container-->
  </section><br>
@endsection

<script type="text/javascript">
function get_test()
{
  var id = $("#test").val();

  $("#test_name_id").css("display", "none");  
  $("#test_name").removeAttr("required", "required");
  $("#membership_level").val("");
  $('#membership_level').material_select(); 
  if(id == "-1")
  {
    table.clear().draw();
    $("#_testid").val("");
    $("#membership_level").val("");
    $('#membership_level').material_select(); 
    $("#test_name_id").css("display", "block");
    $("#test_name").attr("required", "required");
  }
  else
  {
    $("#test_name_id").css("display", "none");  
    $("#test_name").removeAttr("required", "required");
    $("#_testid").val(id);
    $.blockUI({ message: "<i class='material-icons' >sync</i> &nbsp; <h6>Loading... a moment please.</h6>" });
    $.ajax({
        url: "{{ url('get_test_membership') }}",
        type: 'GET',
        data: {id:id},            
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(data){                   
            data = JSON.parse(data);
            $("#membership_level").val(data);     
            $('#membership_level').material_select();   
            $.unblockUI();
        }
    });

    $.ajax({
        url: "{{ url('get_test_sections') }}",
        type: 'GET',
        data: {id:id},            
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(data){ 
          table.clear().draw();
          if(data!="")     
          {             
            data = JSON.parse(data);
            var count = Object.keys(data).length;
            var trHTML = '';            
            for (var i = 0; i < count; i++) 
            { 
              table.row.add([data[i].section, data[i].duration_in_mins, data[i].difficulty_level]).draw(false);
            }
          }              
            $.unblockUI();
        }
    });
  }

}

  var question_lists = [];    
  var question_ids_list = [];

  function submit_section()
  {

      var id = $("#test").val();
      var test_name = "";

      test_name = $("#test_name").val();
      var section = $("#section").val();
      var difficulty_level = $("#difficulty_level").val();
      var duration_in_mins = $("#duration_in_mins").val();
      var description = $("#description").val();
      var membership_level = $("#membership_level").val();
      if(id=="" || (id == "-1" && test_name=="") ) 
      {
        if(id=="")
        {
          alert("Please select test.");
          return;
        }
        else if(id == "-1" &&  test_name=="")
        {
          alert("Please enter test name.");
          return;
        }
      }
      if(!section) 
      {
        alert("Please enter section name.");
        return;
      }
      if(!difficulty_level)
      { 
        alert("Please enter Difficulty Level.");
        return;
      }
      if(!duration_in_mins) 
      {
        alert("Please enter Duration In Minutes.");
        return;
      }
      if(!membership_level) 
      {
        alert("Please select Membership Level");
        return;
      }
      
      $.blockUI({ message: "<i class='material-icons' >sync</i> &nbsp; <h6>Loading... a moment please.</h6>" });
      $.ajax({
          url: "{{ url('add_test_section') }}",
          type: 'GET',
          data: {id:id, test_name:test_name, section:section, difficulty_level:difficulty_level, duration_in_mins:duration_in_mins, description:description, membership_level:membership_level},            
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success:function(data){    
              $("#form_id").trigger("reset");               
              data = JSON.parse(data); 
              //alert(data);
              if(data.success==1)
              {
                $("#_testid").val(data.testid);
                //$("#test").attr("disabled", "disabled");
                $('#test').prop("disabled", true);
                $('#test').material_select();
                $('#modal1').closeModal();
                  $.ajax({
                      url: "{{ url('get_test_sections') }}",
                      type: 'GET',
                      data: {id:data.testid},            
                      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                      success:function(datas){                   
                          datas = JSON.parse(datas);
                          var count = Object.keys(datas).length;
                          var trHTML = '';
                          table.clear().draw();
                          for (var i = 0; i < count; i++) 
                          { 
                            table.row.add([datas[i].section, datas[i].duration_in_mins, datas[i].difficulty_level]).draw(false);
                          }            
                          $.unblockUI();
                      }
                  });
              }
              else
              {
                alert(data.message);
              }              
              $.unblockUI();
          }
      });
  }

function submit_upload()
{
    var counts = table.data().count();

    var id = $("#test").val();
    var test_name = "";

    test_name = $("#test_name").val();
    var membership_level = $("#membership_level").val();
    var bulk_excel_file = $("#bulk_excel_file")[0].files.length;
    if(id=="")
    {
      alert("Please select test.");
      event.preventDefault(); 
    }
    else if(id == "-1" && test_name=="")
    {
      alert("Please enter test name.");
      event.preventDefault(); 
    }
    else
    {
      if(membership_level=="") 
      {
        alert("Please select Membership Level");
        event.preventDefault(); 
      }  
      else
      {
        if(bulk_excel_file>0)
        {
          if(counts>0)
          {
            $.blockUI({ message: "<i class='material-icons' >sync</i> &nbsp; <h6>Loading... a moment please.</h6>" });
            $("#bulk_form").submit(); 
          }
          else
          {
            alert("There are no sections available, please enter sections.");
            event.preventDefault();  
          }
        }
        else
        {
          alert("Please select file to upload.");
          event.preventDefault();  
        }
      }   
    }
}
</script>
