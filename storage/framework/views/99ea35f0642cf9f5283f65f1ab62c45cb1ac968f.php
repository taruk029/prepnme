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
</style>
    <div class="single-course-content section-padding-100" >
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="course--content">
                        <div class="row header_test"><!-- header_test -->
                            <div class="col-lg-7 col-sm-12 col-md-6">
                                <p style="margin-top: 10px; line-height: 26px;">PrepNMe <?php echo e($test->test_name); ?></p>
                                <p class="section_heading"><?php echo e($section->section); ?></p>
                            </div>
                        <!--     <div class="input-group input-timer-group"><div class="input-group-addon"></div><timer-directive interval="1000" countdown="sectionRemainingTime_sec" finish-callback="userOutOfTime()" class="input-timer form-control ng-binding ng-isolate-scope"><span class="ng-binding ng-scope">00:03:03</span></timer-directive></div> -->
                            <div class="col-lg-5 col-sm-12 col-md-5">
                                <div class="timer_div">
                                    <div id="countdowntimer">
                                    <div class="section_timer"> 
                                        <label class="time_remain" >Time Remaining  </label>
                                        <div class="timer-clock">
                                            <i class="fa fa-lg fa-clock-o" style="margin-left: 10px;"></i> <span id="m_timer"></span>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="register-login-area stop-pause" style=" width: 314px; margin-top: 10px;">
                                        <a href="#" onclick="javascript:pause_end(1)" id="pauseBtnms" class="btn active" style="height: 31px;line-height: 31px;font-size: 12px;"><i class="fa fa-pause"></i> Pause</a>
                                        <a href="#" onclick="javascript:pause_end(2)"  class="btn active" style="height: 31px;line-height: 31px;font-size: 12px;"><i class="fa fa-stop"></i> Stop & End Section</a>
                                    </div>
                                     
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
                                            <ul id="test_questions" ><!-- class="pagination" -->
                                                    <?php $__currentLoopData = $all_qst; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rowqst): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                
                                                    <li>                                                        
                                                        <svg height="12" width="16" id="<?php echo e($rowqst->question_count); ?>" style="<?php if($rowqst->come_back_later==1) echo 'display: hidden;margin-bottom: 3px;'; else echo 'display: none;'; ?>">
                                                          <circle cx="11" cy="3" r="3" stroke-width="3" fill="#ffc107" />
                                                        </svg><br>
                                                        <a href="javascript:void(0)" <?php if(!empty($rowqst->user_answer_id)) { if(Request::segment(5)==$rowqst->question_count) echo "class='selected answered'"; else echo "class='answered'"; } else {  if(Request::segment(5)==$rowqst->question_count) echo "class='selected'"; } ?>  onclick="javascript:get_question(<?php echo e($rowqst->question_count); ?>)">
                                                            <?php echo e($rowqst->question_count); ?>

                                                        </a>
                                                    </li>
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
                                                
                                                 <div class="col-md-6 col-sm-6 col-lg-5 ans_div">
                                                    <center>
                                                    <?php if(Request::segment(5)!=1): ?>
                                                        <a href="#" class="btn clever-btn previous" onclick="javascript:previous()">Previous Question</a>
                                                    <?php endif; ?>
                                                    <?php if(Request::segment(5) < count($all_qst)): ?>
                                                    <a href="#" class="btn clever-btn" onclick="javascript:next()">Next Question</a>
                                                    <?php endif; ?>
                                                    </center><br>
                                                    <div id="answer_div">
                                                    <ul>
                                                        <?php $sn = 65; ?>
                                                        <?php $__currentLoopData = $answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ans): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li>
                                                            <svg width="65" height="65" style="cursor: pointer;float: left;" onclick="javascript:set_answer(<?php echo e($ans->id); ?>)">
                                                            <circle cx="32" cy="32" r="23" <?php if($ans->id == $qst->user_answer_id) echo 'fill="#3098a0"'; else echo 'fill="transparent"'; ?> stroke="#eeeeee" stroke-width="4" class="circle_ans" id="circle<?php echo e($ans->id); ?>" />
                                                            <text <?php if($ans->id == $qst->user_answer_id) echo 'fill="#ffffff"'; else echo 'fill="#000000"'; ?> id="text<?php echo e($ans->id); ?>" font-size="15" x="26" class="text_ans" y="38"><?php echo e(chr($sn)); ?></text>
                                                            </svg>
                                                            <label style="display: flex; margin-right: 10px; color: #ddd"></label>
                                                            <label style="display: flex;margin-top: 5%;"><?php echo e($ans->answer); ?></label>
                                                            <div style="clear: both;"></div>
                                                        </li>
                                                        <?php $sn++; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                         <center><a href="javascript:void(0)" class="clever-btn" onclick="javascript:come_back_later()"><i class="fa fa-flag"></i> Mark to Review Later</a></center>
                                                    </ul>
                                                    </div>
                                                 </div>
                                                 <?php if($qst->question_type_id!=2): ?>
                                                 <br>
                                                 <div style="clear: both;"></div>
                                                 <div class="col-12 col-lg-12" style="margin-top: 10px;"> 
                                                    <textarea class="form-control" name="essay_ans" id="essay_ans" onkeyup="javascript:save_essay()" placeholder="Please write your answer here." rows="15"><?php echo e($qst->user_answer); ?></textarea>
                                                 </div>
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
    <input type="hidden" name="section_id" id="section_id" value="<?php echo e($section_id); ?>">
    <input type="hidden" name="test_id" id="test_id" value="<?php echo e($test_id); ?>">
    <input type="hidden" name="user_id" id="user_id" value="<?php echo e($user_id); ?>">
    <input type="hidden" name="taken_test_id" id="taken_test_id" value="<?php echo e($taken_test_id); ?>">
    <input type="hidden" name="question_type_id" id="question_type_id" value="<?php echo $qst->question_type_id; ?>">
    <!-- ##### Courses Content End ##### -->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">

    $(document).ready(function(){
        sendRequest();
        inactivityTime(); 
    if ($(window).width() < 700){
        alert("PrepNMe Tests are not designed for phones. Please use a tablet or a PC to take the test");
        parent.history.back();
    }
});

    var inactivityTime = function () {
    var time;
    window.onload = resetTimer;
    // DOM Events
    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;

    function logout() {
        /*alert("You are now logged out.")*/
        pause_end(1);
        //location.href = 'logout.html'
    }

    function resetTimer() {
        clearTimeout(time);
        time = setTimeout(logout, 300000)
        // 1000 milliseconds = 1 second
    }
};
</script>
<script type="text/javascript" src="<?php echo e(asset('front/js/jQuery.countdownTimer.js')); ?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
<script type="text/javascript">
    $(function() {
        var value = $.cookie("<?php echo e($taken_test_id); ?>");
        if(value)
        {
            if(value!="00:00")
            {
                var res = value.split(":");
                $("#m_timer").countdowntimer({
                    minutes : res[0],
                    seconds : res[1],
                    size : "lg",
                    displayFormat : "MS"
                });
            }
            else
            {
                var url = "<?php echo e(Request::root().'/outoftime'.'/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4)); ?>";
                window.location.replace(url);
            }
        }
        else
        {
           /* $("#m_timer").countdowntimer({
                minutes : <?php echo e($remaining_time_mins); ?>,
                seconds : <?php echo e($remaining_time_secs); ?>,
                size : "lg",
                displayFormat : "MS"
            });*/
            var url = "<?php echo e(Request::root().'/outoftime'.'/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4)); ?>";
                window.location.replace(url);
        }
    });
</script>
<script>
    
    function sendRequest()
    {        
        var time = $('#m_timer').text();
        var taken_test_id = $('#taken_test_id').val();
        console.log(time);
        if(time!= "00:00")
        {
            update_timer();
            $.ajax({
                url: "<?php echo e(url('save_timer')); ?>",
                type: 'GET',
                data: {id:taken_test_id, time:time},            
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                complete: function() { 
                }
            });
        }
        else
        {
            var url = "<?php echo e(Request::root().'/outoftime'.'/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4)); ?>";
            window.location.replace(url);
        }
    }

    function update_timer()
    {
         var counter = setInterval(function()
        {   
            var time = $('#m_timer').text();
            var taken_test_id = $('#taken_test_id').val();
            console.log(time);
            if(time!= "00:00")
            {
                $.cookie(taken_test_id, time);
            }
            else
            {
                $("#m_timer").removeAttr("id");
                clearInterval(counter);
                var url = "<?php echo e(Request::root().'/outoftime'.'/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4)); ?>";
                window.location.replace(url);
            }

        }, 1000);        
    }

    function save_essay()
    {
        sendRequest();
        var question_id = $("#question_id").val();
        var section_id = $('#section_id').val();
        var count_id = "<?php echo e(Request::segment(5)); ?>";
        var user_id = $('#user_id').val();
        var essay_ans = $('#essay_ans').val();
        $.ajax({
            url: "<?php echo e(url('save_essay')); ?>",
            type: 'GET',
            data: {user_id:user_id, section_id:section_id, question_id:question_id, count_id:count_id, essay_ans:essay_ans},            
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(data){
                $("#"+count_id).removeAttr("style");
                $("#"+count_id).css("display","hidden");
                $("#"+count_id).css("margin-bottom","3px");
            }
        });
    }

    function next()
    {
        sendRequest();
        var i = (parseInt(<?php echo e(Request::segment(5)); ?>)+1);
        var url = "<?php echo e(Request::root().'/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4).'/'); ?>"+i;
        console.log(url);
        window.location.replace(url);
    }

    function previous()
        {
            sendRequest();
            var i = (parseInt(<?php echo e(Request::segment(5)); ?>)-1);
            var url = "<?php echo e(Request::root().'/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4).'/'); ?>"+i;
            console.log(url);
            window.location.replace(url);
        }

    
    function get_question(id)
    {
        sendRequest();
        var url = "<?php echo e(Request::root().'/'.Request::segment(1).'/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4).'/'); ?>"+id;
        console.log(url);
        window.location.replace(url);
    }

    function pause_end(id)
    {
        sendRequest();
        if(id==1)
        {
            var url = "<?php echo e(Request::root().'/'.'pause_section'.'/'.Request::segment(3).'/'.Request::segment(4)); ?>";
        }
        if(id==2)
        {
            var q_type = $("#question_type_id").val();
            if(q_type==1)
            {
                alert("SSAT Writing Sample questions are not scored. The sample essays are sent to school admissions for review.");
            }
            var url = "<?php echo e(Request::root().'/'.'end_section'.'/'.Request::segment(3).'/'.Request::segment(4)); ?>";
        }
        
        console.log(url);
        window.location.replace(url);
    }

    function come_back_later()
    {
        sendRequest();
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
        sendRequest();
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
        sendRequest();
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

<?php echo $__env->make('front.layout.dashboard_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\training\admin\resources\views/front/dashboard/tests.blade.php ENDPATH**/ ?>