<?php $__env->startSection('title', 'Practice Test'); ?>
<?php $__env->startSection('content'); ?>
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
                <h5 class="breadcrumbs-title">Update Question</h5>
                <ol class="breadcrumbs">
                  <li><a href="<?php echo e(url('home')); ?>">Dashboard</a></li>
                  <li><a href="<?php echo e(Request::url()); ?>">Update Question</a></li>
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
                        <form class="col s12" method="post" action="<?php echo e(url('update_question')); ?>" enctype="multipart/form-data">
                          <?php echo e(csrf_field()); ?>

                           <input id="id" type="hidden" name="id" value="<?php echo e($questions->id); ?>">
                          <div class="row">
                            <div class="input-field col s12">
                                <select name="question_type" id="question_type" required="required" onchange="javascript:check_question_type()">
                                  <option value="">Select Question Type </option>
                                  <?php $__currentLoopData = $question_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($row->id); ?>" <?php if($questions->question_type_id == $row->id) echo "selected"; ?> ><?php echo e($row->question_type); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                 <?php if($errors->has('question_types')): ?>
                                    <strong><?php echo e($errors->first('question_types')); ?></strong>
                                <?php endif; ?>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <select name="difficulty_level" id="difficulty_level" required="required">
                                <option value="" >Select Difficulty Level</option>
                                <option value="1" <?php if($questions->difficulty_level==1) echo "selected"; ?> >1</option>
                                <option value="2" <?php if($questions->difficulty_level==2) echo "selected"; ?> >2</option>
                                <option value="3" <?php if($questions->difficulty_level==3) echo "selected"; ?> >3</option>
                                <option value="4" <?php if($questions->difficulty_level==4) echo "selected"; ?> >4</option>
                                <option value="5" <?php if($questions->difficulty_level==5) echo "selected"; ?> >5</option>
                                <option value="6" <?php if($questions->difficulty_level==6) echo "selected"; ?> >6</option>
                                <option value="7" <?php if($questions->difficulty_level==7) echo "selected"; ?> >7</option>
                                <option value="8" <?php if($questions->difficulty_level==8) echo "selected"; ?> >8</option>
                                <option value="9" <?php if($questions->difficulty_level==9) echo "selected"; ?> >9</option>
                                <option value="10" <?php if($questions->difficulty_level==10) echo "selected"; ?> >10</option>
                              </select>
                               <?php if($errors->has('difficulty_level')): ?>
                                    <strong><?php echo e($errors->first('difficulty_level')); ?></strong>
                                <?php endif; ?>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <select name="category" id="category" required="required">
                                <option value="">Select Category</option>
                                <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($row->id); ?>" <?php if($questions->category_id == $row->id) echo "selected"; ?> ><?php echo e($row->category); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </select>
                               <?php if($errors->has('category')): ?>
                                    <strong><?php echo e($errors->first('category')); ?></strong>
                                <?php endif; ?>
                            </div>
                          </div>                          
                          <div class="row">

                            <div class="input-field col s12">
                              <textarea id="question" class="materialize-textarea" name="question" ><?php echo e($questions->question); ?>

                              </textarea>
                              <label for="first_name" class="">Question</label>
                               <?php if($errors->has('question')): ?>
                                    <strong><?php echo e($errors->first('question')); ?></strong>
                                <?php endif; ?>
                            </div>
                          </div>
                          <div id="answers_div" style="display: <?php if($questions->question_type_id==2) echo "block"; else echo "none"; ?>;">
                            <?php if($answers): ?>
                              <?php 
                                $ans_count = 0;
                                $label = "";
                                $correct_ans = "";
                                $ans_count = count($answers); 
                                $sn =1;
                              ?>
                              <?php $__currentLoopData = $answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($sn==1): ?>
                                <?php  $label = "one";?>
                                <?php elseif($sn==2): ?>
                                <?php   $label = "two";?>
                                <?php elseif($sn==3): ?>
                                <?php   $label = "three";?>
                                <?php elseif($sn==4): ?>
                                <?php   $label = "four";?>
                                <?php elseif($sn==5): ?>
                                <?php   $label = "five";?>
                                <?php endif; ?>

                                <?php if($row->is_correct == 1): ?>
                                  <?php   $correct_ans = $label;?>
                                <?php endif; ?>
                                <div class="row">
                                  <div class="input-field col s2">
                                    <input type="radio" id="radio-<?php echo e($label); ?>" name="is_correct" class="form-radio" value="<?php echo e($sn); ?>" onclick="javascript:check_this('<?php echo e($label); ?>')" <?php if($row->is_correct == 1) echo "checked"; ?> >
                                    <label for="radio-one">Correct</label>
                                  </div>
                                  <div class="input-field col s10">
                                    <input id="answer_<?php echo e($label); ?>" type="text" name="<?php echo e($label); ?>" value="<?php echo e($row->answer); ?>">
                                    <label for="first_name" class="" style="color: #000000;">Answer Option <?php echo e($sn); ?></label>
                                  </div>
                                </div>
                                <?php $sn++; ?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                          <div class="row">
                            <div class="input-field col s12">
                              <textarea id="description" class="materialize-textarea" name="description" >
                              <?php echo e(trim($questions->resolution_desc)); ?>

                              </textarea>
                              <label for="first_name" class="">Resolution Description</label>
                            </div>
                          </div>
                          </div>
                          <input id="correct_answer" type="hidden" name="correct_answer" value="<?php echo e($correct_ans); ?>">
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="average_time" type="text" name="average_time" value="<?php echo e($questions->average_time); ?>" onkeypress="return NumbersOnly(event,this)">
                              <label for="first_name" class="">Average Time ( in minutes )</label>
                               <?php if($errors->has('average_time')): ?>
                                    <strong><?php echo e($errors->first('average_time')); ?></strong>
                                <?php endif; ?>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input type="file" name="images" id="images" title="Question Image">                              
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <?php if($questions->image): ?>
                                <?php 
                                $file = base_path().'/public/question_picture/'.$questions->image;
                                if(file_exists($file)) 
                                  { ?>
                                    <img class="materialboxed" width="250" src="<?php echo e($questions->image_url); ?>">
                                <?php   }
                                ?>
                              <?php endif; ?>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <label for="radio-five" style="color: #000000;">Place Image</label><br>
                              <div class="input-field col s4">
                              <input type="radio" id="before" name="place" class="form-radio" value="1" checked onclick="javascript:check_image_this(1)" <?php if($questions->image_placement!= 0 && $questions->image_placement == 1) echo "checked"; else echo "checked"; ?> >
                              <label for="radio-five" style="color: #000000;">Before Question</label> 
                            </div>
                            <div class="input-field col s4">
                              <input type="radio" id="after" name="place" class="form-radio" value="2" onclick="javascript:check_image_this(2)" <?php if($questions->image_placement!= 0 && $questions->image_placement == 2) echo "checked"; ?>>
                              <label for="radio-five" style="color: #000000;">After Question</label>     
                              </div>                       
                            </div>
                          </div>
                          <input id="place_image" type="hidden" name="place_image" value='<?php if($questions->image_placement!=0) echo $questions->image_placement; else echo 1; ?>' >
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
<?php $__env->stopSection(); ?>

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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\training\admin\resources\views/questions/edit.blade.php ENDPATH**/ ?>