<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startPush('styles'); ?>
<?php $__env->stopPush(); ?>
<style type="text/css">
    
#test_questions {
      width: 100%;
  }
#test_questions  li {
    width: 10px;
    height: 15px;
    margin-top: 10px;
    margin-right: 20px;
    display: inline-block !important;    
    border-radius: 4px;
  }

#test_questions li a{
  border: 1px solid #dddddd;
  padding: 7px;
  margin-left: 3px;
  color: #337ab7;
  cursor: pointer;
  }
  .correct_answered
  {
    background-color:#5cb85c; 
    color: #fff !important;
  }
  .wrong_answered
  {
    background-color:#ac2925; 
    color: #fff !important;
  }
</style>
    <div class="single-course-content section-padding-100" >
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="course--content">
                        <div class="row header_test"><!-- header_test -->
                            <div class="col-lg-7 col-sm-12 col-md-6">
                                <p style="margin-top: 10px; line-height: 26px;">PrepNMe <?php echo e($membership_level->name); ?></p>
                                <p class="section_heading"><?php echo e($section->section); ?></p>
                            </div>
                        <!--     <div class="input-group input-timer-group"><div class="input-group-addon"></div><timer-directive interval="1000" countdown="sectionRemainingTime_sec" finish-callback="userOutOfTime()" class="input-timer form-control ng-binding ng-isolate-scope"><span class="ng-binding ng-scope">00:03:03</span></timer-directive></div> -->
                            <div class="col-lg-5 col-sm-12 col-md-5">
                                <div class="register-login-area stop-pause">
                                 <a href="<?php echo e(url('analysis/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4))); ?>" class="btn active" style="height: 31px;line-height: 31px;font-size: 12px;margin-top: 35px; ">Back to Results Summary</a>
                             </div>
                            </div>
                        </div>

                        <div class="clever-tabs-content">
                            
                            <div class="tab-content" id="myTabContent">
                                
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab--1">
                                    <div class="clever-description">
                                        <!-- FAQ -->
                                        <div class="clever-faqs" style="min-height: 800px;">
                                           <div class="page_number">
                                            <center>
                                            <ul id="test_questions" >
                                                    <?php 
                                                    $counts = 1; ?><!-- class="pagination" -->
                                                    <?php $__currentLoopData = $all_qst; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rowqst): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                
                                                    <li>                                                        
                                                        <svg height="12" width="16" id="<?php echo e($rowqst->question_count); ?>" style="<?php if($rowqst->come_back_later==1) echo 'display: hidden;margin-bottom: 3px;'; else echo 'display: none;'; ?>">
                                                          <circle cx="11" cy="3" r="3" stroke-width="3" fill="#ffc107" />
                                                        </svg><br>
                                                        <a href="javascript:void(0)" 
                                                        <?php 
                                                            if(!empty($rowqst->user_answer_id)) 
                                                            { 
                                                                if(Request::segment(5)==$rowqst->question_count) 
                                                                {
                                                                    if($rowqst->is_correct==1)
                                                                        echo "class='selected correct_answered'"; 
                                                                    else
                                                                        echo "class='selected wrong_answered'";
                                                                }
                                                                else 
                                                                {
                                                                    if($rowqst->is_correct==1)
                                                                        echo "class='correct_answered'";
                                                                    elseif ($rowqst->is_correct==0) {
                                                                        echo "class='wrong_answered'";
                                                                    }
                                                                    else
                                                                        echo "class='answered'"; 
                                                                }
                                                            } 
                                                            else 
                                                            {  
                                                                if(Request::segment(5)==$rowqst->question_count) 
                                                                    echo "class='selected'"; 
                                                            } 
                                                        ?>  
                                                        onclick="javascript:get_question(<?php echo e($rowqst->question_count); ?>)">
                                                            <?php echo e($counts); ?>

                                                        </a>
                                                    </li>
                                                    <?php $counts++; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                            </center>
                                            </div>
                                            <div style="clear: both;"></div>
                                            <div class="row qst_section">
                                                <div class="col-lg-7 col-md-6 col-sm-6">  
                                                <div class="row"  style="padding: 10px 0px 10px 0px;">
                                                    <div class="col-lg-1 col-md-1 col-sm-1"><?php echo e(Request::segment(5)); ?>.</div>
                                                    <div class="col-lg-11 col-md-10 col-sm-10"> 
                                                        <div id="question_div">
                                                            <input type="hidden" name="question_id" id="question_id" value="<?php echo e($qst->question_id); ?>">
                                                            <?php if($qst->image_placement==1): ?>
                                                                <?php if(!empty($qst->image_url)): ?>
                                                                    <?php  $file = base_path().'/public/question_picture/'.$qst->image; ?>
                                                                    <?php if(file_exists($file)): ?> 
                                                                        <img class="qst_image"  src="<?php echo e($qst->image_url); ?>"><br><br>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            <?php endif; ?> 
            
                                                           <?php echo $qst->question; ?>
                                                            
                                                            <?php if($qst->image_placement==2): ?>
                                                                <?php if(!empty($qst->image_url)): ?>
                                                                    <?php  $file = base_path().'/public/question_picture/'.$qst->image; ?>
                                                                    <?php if(file_exists($file)): ?> 
                                                                        <br><br><img class="qst_image" src="<?php echo e($qst->image_url); ?>">
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            <?php endif; ?> 
                                                        </div>
                                                </div>
                                                </div>
                                                </div>
                                                
                                                <?php if($qst->question_type_id==2): ?>
                                                 <div class="col-md-6 col-sm-6 col-lg-5 ans_div">
                                                    <center>
                                                    <?php 
                                                    $key = array_search(Request::segment(5), $next_array);
                                                    if($key!=0)
                                                    {
                                                        if (array_key_exists($key-1,$next_array)) 
                                                        {
                                                            $previousqstid = $next_array[$key-1];                     
                                                        ?>
                                                        <a href="#" class="btn clever-btn previous" onclick="javascript:previous(<?php echo e($previousqstid); ?>)">Previous Question</a>
                                                    <?php } } ?>
                                                    <?php 
                                                    $key = array_search(Request::segment(5), $next_array);
                                                    if (array_key_exists($key+1,$next_array)) 
                                                    {
                                                        $nextqstid = $next_array[$key+1];                     
                                                    ?>
                                                    <a href="#" class="btn clever-btn" onclick="javascript:next(<?php echo e($nextqstid); ?>)">Next Question</a>
                                                    <?php } ?>
                                                    </center><br>
                                                    <div id="answer_div">
                                                    <ul>
                                                        <?php $sn = 65; ?>
                                                        <?php $__currentLoopData = $answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ans): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li>
                                                            <svg width="65" height="65" style="cursor: pointer;float: left;">
                                                            <circle cx="32" cy="32" r="23" 
                                                            <?php 
                                                            if($ans->id == $qst->user_answer_id) 
                                                            {
                                                                if($ans->is_correct==1)
                                                                    echo 'fill="#5cb85c"'; 
                                                                else
                                                                    echo 'fill="#ac2925"'; 
                                                            }
                                                            else
                                                            {
                                                                if($ans->is_correct==1)
                                                                    echo 'fill="#5cb85c"'; 
                                                                else
                                                                    echo 'fill="transparent"'; 
                                                            } 

                                                            ?> stroke="#eeeeee" stroke-width="4" class="circle_ans" id="circle<?php echo e($ans->id); ?>" />
                                                            <text 
                                                            <?php 
                                                            if($ans->id == $qst->user_answer_id) 
                                                                echo 'fill="#ffffff"'; 
                                                            else 
                                                                echo 'fill="#000000"';
                                                             ?> 
                                                             id="text<?php echo e($ans->id); ?>" font-size="15" x="26" class="text_ans" y="38"><?php echo e(chr($sn)); ?></text>
                                                            </svg>
                                                            <label style="display: flex; margin-right: 10px; color: #ddd"></label>
                                                            <label style="display: flex;margin-top: 4%;"><?php echo e($ans->answer); ?></label>
                                                            <div style="clear: both;"></div>
                                                        </li>
                                                        <?php $sn++; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                    </div>
                                                 </div>
                                                 <?php endif; ?>
                                                 <?php if($qst->question_type_id!=2): ?>
                                                 <br>
                                                 <div style="clear: both;"></div>
                                                 <div class="col-12 col-lg-12" style="margin-top: 10px;"> 
                                                    <textarea class="form-control" name="essay_ans" id="essay_ans" disabled="disabled" placeholder="Please write your answer here." rows="15"><?php echo e($qst->user_answer); ?></textarea>
                                                 </div>
                                                 <?php endif; ?>
                                                 <br>
                                                 <div style="clear: both;"></div>
                                                 <div class="col-lg-12 col-sm-12 col-md-12" style="margin-top: 10px;background: #D2EBF6;padding: 30px;border-radius: 8px;">
                                                 <h4>Solution</h4> 
                                                 <?php if($qst->question_type_id!=2): ?>
                                                    SSAT Writing Sample questions are not scored. The sample essays are sent to school admissions for review.
                                                <?php else: ?>
                                                    <?php echo e($qst->resolution_desc); ?>

                                                <?php endif; ?>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    </div>
    <input type="hidden" name="section_id" id="section_id" value="<?php echo e($section_id); ?>">
    <input type="hidden" name="test_id" id="test_id" value="<?php echo e($test_id); ?>">
    <input type="hidden" name="user_id" id="user_id" value="<?php echo e($user_id); ?>">
    <input type="hidden" name="taken_test_id" id="taken_test_id" value="<?php echo e($test_id); ?>">
    <!-- ##### Courses Content End ##### -->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    $(document).ready(function(){
    if ($(window).width() < 700){
        alert("PrepNMe Tests are not designed for phones. Please use a tablet or a PC to take the test");
        parent.history.back();
    }
});
</script>
<script>

    function next(nextqstid)
    {
        var url = "<?php echo e(Request::root().'/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4).'/'); ?>"+nextqstid+"<?php echo e('/'.Request::segment(6).'/'.Request::segment(7)); ?>";
        console.log(url);
        window.location.replace(url);
        /*var section_id = $('#section_id').val();
        var count = "<?php echo e($qst_count); ?>";
        var user_id = $('#user_id').val();
        $.ajax({
            url: "<?php echo e(url('next_question')); ?>",
            type: 'GET',
            data: {user_id:user_id, section_id:section_id},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).done( 
            function(data) 
            {
                $('#question_div').html(data);
                var i = (parseInt(<?php echo e(Request::segment(5)); ?>)+1);
                var url = "<?php echo e(Request::root().'/'.'/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4).'/'); ?>"+i;
                console.log(url);
                window.location.replace(url);
            });*/
    }

    function previous(previousqstid)
        {
            var url = "<?php echo e(Request::root().'/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4).'/'); ?>"+previousqstid+"<?php echo e('/'.Request::segment(6).'/'.Request::segment(7)); ?>";
            console.log(url);
            window.location.replace(url);
        }

    
    function get_question(id)
    {
        var url = "<?php echo e(Request::root().'/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4).'/'); ?>"+id+"<?php echo e('/'.Request::segment(6).'/'.Request::segment(7)); ?>";
        console.log(url);
        window.location.replace(url);
    }

    function pause_end(id)
    {
        if(id==1)
        {
            var url = "<?php echo e(Request::root().'/'.'pause_section'.'/'.Request::segment(3).'/'.Request::segment(4)); ?>";
        }
        if(id==2)
        {
            var url = "<?php echo e(Request::root().'/'.'end_section'.'/'.Request::segment(3).'/'.Request::segment(4)); ?>";
        }
        
        console.log(url);
        window.location.replace(url);
    }

    function come_back_later()
    {
        var question_id = $("#question_id").val();
        var section_id = $('#section_id').val();
        var count_id = "<?php echo e(Request::segment(5)); ?>";
        var user_id = $('#user_id').val();
        $.ajax({
            url: "<?php echo e(url('come_back_later')); ?>",
            type: 'GET',
            data: {user_id:user_id, section_id:section_id, question_id:question_id, count_id:count_id},            
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(data){
                $("#"+count_id).removeAttr("style");
                $("#"+count_id).css("display","hidden");
                $("#"+count_id).css("margin-bottom","3px");
            }
        });
    }

    function set_answer(id)
    {
        var question_id = $("#question_id").val();
        var section_id = $('#section_id').val();
        var answer_id = id;
        var user_id = $('#user_id').val();
        $.ajax({
            url: "<?php echo e(url('set_answer')); ?>",
            type: 'GET',
            data: {user_id:user_id, section_id:section_id, question_id:question_id, answer_id:answer_id},            
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(data){

                $('.circle_ans').css({ fill: "#eeeeee" });
                $('.text_ans').css({ fill: "#000000" });
                $('#circle'+id).css({ fill: "#3098a0" });
                $('#text'+id).css({ fill: "#ffffff" });
            }
        });
    }
</script>
<script type="text/javascript"> 
    $(document).ready(function() {
        var numitems =  $("#test_questions li").length;

        //$("ul#test_questions").css("column-count",numitems/2);
    });
</script>
<script type="text/javascript" >
  $(document).ready(function() {
        window.history.pushState(null, "", window.location.href);        
        window.onpopstate = function() {
            window.history.pushState(null, "", window.location.href);
        };
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('front.layout.dashboard_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\training\admin\resources\views/front/dashboard/test_result.blade.php ENDPATH**/ ?>