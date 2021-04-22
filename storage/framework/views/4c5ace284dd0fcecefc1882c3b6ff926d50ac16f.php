<?php $__env->startSection('title', 'Practice Test'); ?>
<?php $__env->startSection('content'); ?>
<style type="text/css">
  .input-field label {
    position: relative;
    height: 20px;
    pointer-events: all;
    cursor: pointer;
  }
</style>
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
                <h5 class="breadcrumbs-title">Edit Assign Section Questions</h5>
                <ol class="breadcrumbs">
                  <li><a href="<?php echo e(url('home')); ?>">Dashboard</a></li>
                  <li><a href="<?php echo e(url('assign_section')); ?>">Edit Assign Section Questions</a></li>
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
                    <form class="col s12"  method="post" action="<?php echo e(url('update_section_questions')); ?>">
                       <?php echo e(csrf_field()); ?>

                      <h4 class="header2">Sections</h4>
                      <div class="row">
                        <div class="input-field col s4">
                          <select class="validate" name="sections" required="required">
                            <option value="" disabled selected>Select Section</option>
                            <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($row->id); ?>" selected="selected"><?php echo e($row->section); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select>
                        </div>
                      </div>
                    
                  </div>
                </div>
              </div>
            </div>
            </div>

            <div id="work-collections">
              <div class="row">
                <div class="col s12 m12 l12">
                    <div class="card-panel">
                      <div class="row">
                         <h4 class="header2">Please Select Questions</h4><br>
                         <div class="row">
                             <div class="input-field col s4">
                                    <select name="category" id="category" required="required" onchange="javascript:get_questions()">
                                      <option value="" disabled selected>Select Category </option>
                                      <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($row->id); ?>"><?php echo e($row->category); ?></option>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                     <?php if($errors->has('test')): ?>
                                        <strong><?php echo e($errors->first('test')); ?></strong>
                                    <?php endif; ?>
                                </div>
                          </div>
                              
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
                                          <th data-field="name">Question</th>
                                          <th data-field="name">Difficulty Level</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                              </div>
                              </div>
                              </div>
                            </div>
                            <div class="row">
                            <div class="col s12 m12 l12">
                                <h4 class="header2"> Selected Questions</h4>
                              <div class="col s12">
                                <div class="card-panel">
                                  <div id="selected_questions" style="line-height: 30px;">
                                    <?php 
                                      $qst_ids = "";
                                      $qst_id_array = array();
                                    ?>
                                    <?php $__currentLoopData = $sub; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <span data_id="<?php echo e($row->id); ?>">- <?php echo e($row->question); ?> &nbsp;<i class="material-icons task-cat red accent-2" style="cursor:pointer;" onClick="unselectQuestion(this)" title="Remove Question">clear</i></span><br>
                                      <?php 
                                        array_push($qst_id_array, $row->id );
                                      ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      <?php 
                                        $qst_ids = implode(",", $qst_id_array);
                                      ?>
                                  </div>
                              </div>
                              </div>
                              </div>
                            </div>
                            
                          </div>
                            <div class="row">
                              <div class="input-field col s12">
                                <button class="btn waves-effect waves-light right cyan" type="submit" name="action">Update
                                  <i class="material-icons right">send</i>
                                </button>
                              </div>
                            </div>
                             <input type="hidden" name="question_ids" id="question_ids" value="<?php echo $qst_ids; ?>">
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
             
            </form>
            <!-- //////////////////////////////////////////////////////////////////////////// -->
          </div>
          <!--end container-->
        </section>
<?php $__env->stopSection(); ?>
<script type="text/javascript">
  var question_lists = [];    
  var question_ids_list = [];

  <?php foreach($sub as $row) 
  { ?>
    question_lists.push('<span data_id="<?php echo $row->id;  ?>">- <?php echo $row->question;  ?>&nbsp;<i class="material-icons task-cat red accent-2" style="cursor:pointer;" onClick="unselectQuestion(this)" title="Remove Question">clear</i></span>');

    question_ids_list.push(<?php echo $row->id;  ?>);
  <?php }
  ?>
/*console.log(question_lists);
console.log(question_ids_list);*/
  function get_questions(){
    var category = $("#category").val();
    var question_list = [];
    //var table = $("#table_id tbody");
    $.blockUI({ message: "<i class='material-icons' >sync</i> &nbsp; <h6>Loading... a moment please.</h6>" });
    $.ajax({
        url: "<?php echo e(url('get_questions')); ?>",
        type: 'GET',
        data: {id:category},            
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success:function(data){                   
            data = JSON.parse(data);
            var count = Object.keys(data).length;
            var trHTML = '';
            table.clear().draw();
            for (var i = 0; i < count; i++) 
            { 
                var checks = "";
                /*alert(question_ids_list);
                alert(data[i].id);
                alert(jQuery.inArray( data[i].id, question_ids_list ));*/
                if(jQuery.inArray( data[i].id, question_ids_list )!="-1")
                {
                  checks = "checked = 'checked'";
                  console.log(1);
                }
                question_list.push('<label class="container_label_check" style="color:#000000">'+data[i].question+'<input type="checkbox" name="questions"  '+checks+' data_id="'+data[i].id+'" data_value="'+data[i].question+'" value="'+data[i].id+'" onClick="get_selected_question(this)"><span class="checkmark"></span></label>');
                
                trHTML = '<label class="container_label_check" style="color:#000000">'+data[i].question+'<input type="checkbox" name="questions"  '+checks+' data_id="'+data[i].id+'" data_value="'+data[i].question+'" value="'+data[i].id+'" onClick="get_selected_question(this)"><span class="checkmark"></span></label>';
                table.row.add([trHTML, data[i].difficulty_level ]).draw(false);
            }
            var list = question_list.join(" ");         
            $.unblockUI();
        }
    });
  }
   
  function get_selected_question(sender)
  {     
    if($(sender).is(':checked')==true)
    {
      if(question_ids_list.indexOf(parseInt($(sender).attr("data_id")))=="-1")
      {
        /*alert(question_lists);*/
        question_lists.push('<span data_id="'+parseInt($(sender).attr("data_id"))+'">- ' + $(sender).attr("data_value") + '&nbsp;<i class="material-icons task-cat red accent-2" style="cursor:pointer;" onClick="unselectQuestion(this)" title="Remove Question">clear</i></span>');
        question_ids_list.push(parseInt($(sender).attr("data_id")));
        var list = question_lists.join("<br/>  ");
        var id_list = question_ids_list.join(",");
        $("#selected_questions").html(list);
        $("#question_ids").val(id_list);
      }
    }
    else
    {
      unselectQuestion(sender);
    }
  }

  function unselectQuestion(sender)
  {
    question_lists.splice(question_ids_list.indexOf(parseInt($(sender).parent().attr("data_id"))) , 1);
    question_ids_list.splice(question_ids_list.indexOf(parseInt($(sender).parent().attr("data_id"))),1);
    if(typeof('input:checkbox[value="'+parseInt($(sender).parent().attr("data_id"))+'"]') != 'undefined')
    {
        $('input:checkbox[value="'+parseInt($(sender).parent().attr("data_id"))+'"]').prop('checked', false);      
    }
      var list = question_lists.join("<br/>  ");
      var id_list = question_ids_list.join(",");
      $("#selected_questions").html(list);
      $("#question_ids").val(id_list);
  }
</script>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\training\admin\resources\views/sections_question/edit.blade.php ENDPATH**/ ?>