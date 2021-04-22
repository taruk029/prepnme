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
                <h5 class="breadcrumbs-title">Bulk Upload Test Result</h5>
                <ol class="breadcrumbs">
                  <li><a href="{{ url('home')}}">Dashboard</a></li>
                  <li><a href="{{ url('/')}}">Bulk Upload Test Result</a></li>
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
                        <?php
                          $log_file = storage_path("logs/".$log->logs);
                          if(file_exists($log_file))
                          {
                            $lines = file($log_file);                            
                            if(!count($lines))
                            { ?>
                              <h5>All the questions are added successfully.</h5>
                            <?php }
                            else
                            {
                           ?>
                       <h5>Following questions could not be added:-</h5>
                      <div id="responsive-table">
                    <div class="row">
                      <div class="col s12">
                        <table id="table_id" class=" display responsive-table">
                          <thead>
                            <tr>
                              <th data-field="name">Sr. No.</th>
                              <th data-field="name">Question</th>
                            </tr>
                          </thead>
                          <tbody>
                             <?php
                              if(file_exists($log_file))
                              {
                                $lines = file($log_file);
                                $sn = 1;
                               ?>
                              @foreach($lines as $value)
                            <tr>
                              <td>{{$sn}}</td>
                              <td><?php 
                                $error =  explode("error-", $value);
                                if(count($error)>1)
                                {
                                  $qst = explode("'", $error[1]); 
                                  
                                    if(count($qst)>=3)
                                    {    
                                      ?>                              
                                       <strong>{{$qst[1]}}</strong> <i>{{ isset($qst[2])?str_replace("[]","",$qst[2]) : ""}}</i>;
                                    <?php }                                
                                    else
                                    {
                                      echo '<strong>'.str_replace("[]","",$qst[0]).'</strong>';
                                    }
                                }
                                else
                                {
                                  echo '<strong>'.$value.'</strong>';
                                }
                                 ?>
                              </td>
                            </tr>
                            <?php $sn++; ?>
                            @endforeach
                          <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                <?php }
                }
                else{ ?>
                <h5><i class="material-icons">done_all</i> Questions are uploaded successfully.</h5>
              <?php } ?>
                    </div>
                  </div>
               </div>
            
            <!-- //////////////////////////////////////////////////////////////////////////// -->
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
            data = JSON.parse(data);
            var count = Object.keys(data).length;
            var trHTML = '';
            table.clear().draw();
            for (var i = 0; i < count; i++) 
            { 
              table.row.add([data[i].section, data[i].duration_in_mins, data[i].difficulty_level]).draw(false);
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
      if(id=="" && (id = "-1" && test_name=="") ) 
      {
        if(id=="")
        {
          alert("Please select test.");
          return;
        }
        else if(id = "-1" ||  test_name=="")
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
              data = JSON.parse(data);       
              if(data.success==1)
              {
                alert(data.message);
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

</script>
