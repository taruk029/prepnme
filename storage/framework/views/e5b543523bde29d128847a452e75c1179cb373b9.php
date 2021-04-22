<?php $__env->startSection('title', 'PrepNMe Practice Test'); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startPush('styles'); ?>
 <?php echo Charts::styles(); ?>

 <style type="text/css">
  .chart_width_margin { /*margin-left: -7% !important;*/ }
 </style>
<?php $__env->stopPush(); ?>
    <!-- ##### Hero Area Start ##### -->
    <!-- <section class="hero-area bg-img bg-overlay-2by5" style="background-image: url(<?php echo e(asset('public/front/img/bg-img/analysis.jpg')); ?>);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    Hero Content
                    <div class="hero-content text-center">
                        <h2>View Results</h2>
                         <a href="#" class="btn clever-btn">Get Started</a> -->
                    <!-- </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- ##### Hero Area End ##### -->
    <div class="single-course-content section-padding-100">
            <div class="container">
            <div class="rowalign-items-center">
                <div class="col-12">
                    <h2><?php echo e($tests->test_name); ?></h2>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="course--content">
                    <?php $active_tab =  base64_decode(Request::segment(4)) ?>
                        <div class="clever-tabs-content">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link1 <?php if($active_tab==0) echo "active"; ?>" href="<?php echo e(url('analysis').'/'.Request::segment(2).'/'.Request::segment(3).'/'.base64_encode(0)); ?>" ><small>Summary</small> <br> Test Overview</a>
                                </li>
                                <?php if($sections): ?>
                                    <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if (strpos($row->section, 'Writing') === false) 
                                        {
                                         ?>
                                    <?php 
                                        $section_status =  App\Helpers\Helper::get_status($user_id, $test_id, $row->id);
                                        $res_section_count = \App\Helpers\Helper::get_user_section_count($row->id, $user_id);
                                     ?> 
                                        <li class="nav-item">
                                            <a class="nav-link1 <?php if($active_tab==$row->id) echo "active"; ?>" id="tab--<?php echo e($row->id); ?>" href="<?php echo e(url('analysis').'/'.Request::segment(2).'/'.Request::segment(3).'/'.base64_encode($row->id)); ?>" >
                                                <?php if($section_status==2): ?>
                                                    <small>View Results</small> 
                                                <?php else: ?>
                                                    <?php if($res_section_count==1): ?>
                                                        <small>Continue</small> 
                                                    <?php else: ?>
                                                        <small>Start</small> 
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <br> 
                                             <?php echo e($row->section); ?></a>
                                        </li>                                     
                                    <?php } ?>   
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                                <!-- <li class="nav-item">
                                    <a class="nav-link" id="tab--3" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="true">Forgot Password</a>
                                </li> -->
                            </ul>

                            <?php 
                            $quan_scaled = 0;
                            $reading_scaled = 0;
                            $verbal_scaled = 0;
                             ?>
                            <div class="tab-content" id="myTabContent">
                              
                                <div class="tab-pane fade show <?php if($active_tab==0) echo "active"; ?>" id="tab1" role="tabpanel" aria-labelledby="tab--1">
                                    <div class="clever-curriculum">
                                        <div class="about-curriculum mb-30">
                                            <h4>Your Results</h4>
                                            <?php if(Session::has('error')): ?>
                                            <div class="alert alert-danger" role="alert" id="alert_notify">
                                              <?php echo e(Session::get( 'error' )); ?>

                                            </div>
                                            <?php endif; ?>
                                            <table class="table table-striped table-condensed">
                                                <tbody>
                                                    <tr>
                                                        <th class="col-xs-3"></th>
                                                        <th class="col-xs-2">Scaled Score</th>
                                                        <th class="col-xs-2">Raw Score</th>
                                                        <th class="col-xs-5">Percentile</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-xs-2">Quantitative Section</th>
                                                        <?php $quan_status = 0; ?>
                                                        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if(strpos($row->section, 'Quantitative') !== false): ?> 
                                                                <?php $section_status =  App\Helpers\Helper::get_status($user_id, $test_id, $row->id); ?>
                                                                    <?php if($section_status==2): ?>
                                                                        <?php $quan_status = 1; ?>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($quan_status==1): ?>
                                                            <?php $quan_scaled = $quantative_scaled_score; ?>
                                                            <th class="col-xs-2"><?php echo e($quantative_scaled_score); ?></th>
                                                            <th class="col-xs-2"><?php echo e($quantative_raw_score_display); ?></th>
                                                            <?php if($grade==3|| $grade==4): ?>
                                                                <th class="col-xs-2"><?php echo e($quantative_percentile_score['quantative']); ?></th>
                                                            <?php else: ?>
                                                                <th class="col-xs-2"><?php echo e($quantative_percentile_score['percentile']); ?></th>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <th class="col-xs-2"></th>
                                                            <th class="col-xs-2"></th>
                                                            <th class="col-xs-2"></th>
                                                        <?php endif; ?>
                                                            
                                                    </tr>
                                                    <tr>
                                                        <th class="col-xs-2">Reading Section</th>
                                                        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if(strpos($row->section, 'Reading') !== false): ?> 
                                                                <?php $section_status =  App\Helpers\Helper::get_status($user_id, $test_id, $row->id); ?>
                                                                <?php if($section_status==2): ?>
                                                                    <?php $reading_scaled = $reading_scaled_score; ?>
                                                                    <th class="col-xs-2"><?php echo e($reading_scaled_score); ?></th>
                                                                    <th class="col-xs-2"><?php echo e($reading_raw_score_display); ?></th>
                                                                    <?php if($grade==3|| $grade==4): ?>
                                                                        <th class="col-xs-2"><?php echo e($reading_percentile_score['reading']); ?></th>
                                                                    <?php else: ?>
                                                                        <th class="col-xs-2"><?php echo e($reading_percentile_score['percentile']); ?></th>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <th class="col-xs-2"></th>
                                                                    <th class="col-xs-2"></th>
                                                                    <th class="col-xs-2"></th>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-xs-2">Verbal Section</th>
                                                        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if(strpos($row->section, 'Verbal') !== false): ?> 
                                                                <?php $section_status =  App\Helpers\Helper::get_status($user_id, $test_id, $row->id); ?>
                                                                <?php if($section_status==2): ?>
                                                                    <?php $verbal_scaled = $verbal_scaled_score; ?>
                                                                    <th class="col-xs-2"><?php echo e($verbal_scaled_score); ?></th>
                                                                    <th class="col-xs-2"><?php echo e($verbal_raw_score_display); ?></th>
                                                                    <?php if($grade==3|| $grade==4): ?>
                                                                        <th class="col-xs-2"><?php echo e($verbal_percentile_score['verbal']); ?></th>
                                                                    <?php else: ?>
                                                                        <th class="col-xs-2"><?php echo e($verbal_percentile_score['percentile']); ?></th>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                <th class="col-xs-2"></th>
                                                                <th class="col-xs-2"></th>
                                                                <th class="col-xs-2"></th>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tr>
                                                    <?php 
                                                        $test_status =  App\Helpers\Helper::get_test_status($user_id, $test_id);
                                                        if($test_status==0)
                                                        {
                                                     ?> 
                                                    <tr>
                                                        <th class="col-xs-2">Total</th>
                                                        <th class="col-xs-2">
                                                            <?php echo e($quan_scaled+$reading_scaled+$verbal_scaled); ?>

                                                        </th>
                                                        <th class="col-xs-2">
                                                           <?php  /*{{ $quantative_raw_score_display+$reading_raw_score_display+$verbal_raw_score_display}}*/ ?>
                                                        </th>
                                                        <?php if($grade==3|| $grade==4): ?>
                                                            <th class="col-xs-2"><?php echo e($total_percentile_score['total']); ?></th>
                                                        <?php else: ?>
                                                            <th class="col-xs-2"><?php echo e($total_percentile_score['percentile']); ?></th>
                                                        <?php endif; ?>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                               
                                <?php if($sections): ?>

                                    <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    
                                <?php if($active_tab==$rows->id): ?>

                                <?php $status =  App\Helpers\Helper::get_status($user_id, $test_id, $active_tab); ?> 
                                <!-- Tab Text -->
                                <div class="tab-pane fade <?php if($active_tab==$rows->id) echo "show active"; ?>" id="tab<?php echo e($rows->id); ?>" role="tabpanel" aria-labelledby="tab--<?php echo e($rows->id); ?>">
                                    <div class="clever-curriculum">
                                        <div class="about-curriculum mb-30">
                                            <div class="row">
                                            <div class="col-md-10 col-sm-12">
                                            <h3><?php echo e($rows->section); ?> Summary </h3>
                                            </div>
                                            <?php if($status==2): ?>  
                                            <div class="col-md-2 col-sm-12">  
                                            <a href="#" onclick="get_this('<?php echo base64_encode(3) ?>', '1')"  class="btn clever-btn">View Results <i class="fa fa-arrow-right"></i></a>
                                            </div>
                                            <br>
                                            <h5>How you did, by difficulty:</h5> 
                                                <div class="row" >
                                                    
                                                    <div class="col-4 col-sm-4 col-lg-4" style="cursor:pointer;">
                                                        <canvas id="myDonut1" onclick="get_this('<?php echo base64_encode(1) ?>', '<?php echo base64_encode(1) ?>')"></canvas>   
                                                    </div>
                                                    

                                                    <div class="col-4 col-sm-4 col-lg-4" style="cursor:pointer;">
                                                      <canvas id="myDonut2" onclick="get_this('<?php echo base64_encode(1) ?>', '<?php echo base64_encode(2) ?>')"></canvas>
                                                    </div>

                                                    <div class="col-4 col-sm-4 col-lg-4" style="cursor:pointer;">
                                                         <canvas id="myDonut3" onclick="get_this('<?php echo base64_encode(1) ?>', '<?php echo base64_encode(3) ?>')"></canvas>
                                                    </div>
                                                </div>
                                            <?php else: ?>

                                                <?php if($res_count==1): ?>
                                                <div class="col-md-12 col-sm-12">
                                                    <h4>Ready to continue <?php echo e($rows->section); ?>?</h4>
                                                    
                                                    <p>Click below to keep going.</p>
                                                    <a href="<?php echo e(url('user_test/'.base64_encode($user_id).'/'.base64_encode($test_id).'/'.base64_encode($rows->id).'/1')); ?>" class="btn clever-btn" style="text-transform: capitalize !important;">Continue <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                                </div>
                                                <?php else: ?>
                                                <div class="col-md-10 col-sm-12">
                                                    <h4>Ready to take the <?php echo e($rows->section); ?>?</h4>
                                                    <p>Click below to start.</p>
                                                    <a href="<?php echo e(url('user_test/'.base64_encode($user_id).'/'.base64_encode($test_id).'/'.base64_encode($rows->id).'/1')); ?>" class="btn clever-btn" style="text-transform: capitalize !important;">Start <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                                </div>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            </div> 


                                                <?php if($status==2): ?> 
                                                <h5>How you did, by subtype:</h5>  <br>
                                                <div class="row">
                                                <?php if($categories): ?>
                                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row_cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                    
                                                        <div class="col-4 col-sm-4 col-lg-4">
                                                            <?php echo e($row_cat->category); ?>

                                                        </div>
                                                        <div class="col-8 col-sm-8 col-lg-8"> 
                                                            <div class="progress" onclick="get_this('<?php echo base64_encode(2) ?>', '<?php echo base64_encode($row_cat->category_id) ?>')" style="height: 1.5rem; margin-bottom: 10px;cursor:pointer;">
                                                            <?php 
                                                            $unans_count = 0;
                                                            $unans_count =  App\Helpers\Helper::get_user_category_count($active_tab, $user_id, $row_cat->category_id, 2);
                                                            if($unans_count!=0 && $row_cat->counts!=0)
                                                                $unans_percent = ($unans_count/$row_cat->counts)*100;
                                                            else
                                                                $unans_percent = 0;
                                                             ?> 
                                                              <div class="progress-bar" role="progressbar" style="width: <?php echo e($unans_percent); ?>%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="<?php echo e($row_cat->counts); ?>" title="Unanswered">
                                                                  <?php echo e($unans_count); ?>

                                                              </div>

                                                              <?php 
                                                                $correct_count = 0;
                                                                $correct_count =  App\Helpers\Helper::get_user_category_count($active_tab, $user_id, $row_cat->category_id, 1); 
                                                                
                                                                if($correct_count!=0 && $row_cat->counts!=0)
                                                                $correct_percent = ($correct_count/$row_cat->counts)*100;
                                                                else
                                                                    $correct_percent = 0;
                                                                ?> 
                                                              <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo e($correct_percent); ?>%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="<?php echo e($row_cat->counts); ?>" title="Correct">
                                                                  <?php echo e($correct_count); ?>

                                                              </div>

                                                            <?php 
                                                            $incorrect_count = 0;
                                                            $incorrect_count =  App\Helpers\Helper::get_user_category_count($active_tab, $user_id, $row_cat->category_id, 0);

                                                            if($incorrect_count!=0 && $row_cat->counts!=0)
                                                                $incorrect_percent = ($incorrect_count/$row_cat->counts)*100;
                                                            else
                                                                $incorrect_percent = 0;
                                                            ?> 
                                                              <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo e($incorrect_percent); ?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="<?php echo e($row_cat->counts); ?>" title="InCorrect">
                                                                  <?php echo e($incorrect_count); ?>

                                                              </div>
                                                            </div>
                                                        </div>

                                                    <div style="clear: both; "></div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                                </div>
                                                <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/Chart.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/utils.js')); ?>"></script>
<script type="text/javascript">
    function get_this(type, value) 
    {
        var uri = "<?php echo e(Request::root().'/result/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4).'/1'.'/'); ?>"+type+"/"+value;
        window.location.replace(uri);
    }
</script>
<script>
    /* Doughnut1 Start Here */
    var ctx = document.getElementById("myDonut1").getContext("2d");
    window.myDoughnut = new Chart(ctx, {
        type: 'doughnut',
        data: {
            "labels": [
                    'Correct','Wrong','Unanswered'],
            "datasets":[{
                "data":[ <?php echo e(round($easy_correct_ans, 1)); ?>, <?php echo e(round($easy_wrong_ans, 1)); ?>, <?php echo e(round($easy_unanswered_ans, 1)); ?> ],
                "backgroundColor": ["#28a745", "#f14235", "#ffc107"],
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'EASY'
            },
            legend: {
                display: true,
                position: 'right',
            },
        }
    });

    /* Doughnut2 Start Here */
    var ctx = document.getElementById("myDonut2").getContext("2d");
    window.myDoughnut = new Chart(ctx, {
        type: 'doughnut',
        data: {
            "labels": [
                    'Correct','Wrong','Unanswered'],
            "datasets":[{
                "data":[ <?php echo e(round($medium_correct_ans, 1)); ?>, <?php echo e(round($medium_wrong_ans, 1)); ?>, <?php echo e(round($medium_unanswered_ans, 1)); ?> ],
                "backgroundColor": ["#28a745", "#f14235", "#ffc107"],
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'MEDIUM'
            },
            legend: {
                display: true,
                position: 'right',
            },
        }
    });

    /* Doughnut3 Start Here */
    var ctx = document.getElementById("myDonut3").getContext("2d");
    window.myDoughnut = new Chart(ctx, {
        type: 'doughnut',
        data: {
            "labels": [
                    'Correct','Wrong','Unanswered'],
            "datasets":[{
                "data":[ <?php echo e(round($diff_correct_ans, 1)); ?>, <?php echo e(round($diff_wrong_ans, 1)); ?>, <?php echo e(round($diff_unanswered_ans, 1)); ?> ],
                "backgroundColor": ["#28a745", "#f14235", "#ffc107"],
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'DIFFICULT'
            },
            legend: {
                display: true,
                position: 'right',
            },
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('front.layout.dashboard_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\training\admin\resources\views/front/dashboard/analysis.blade.php ENDPATH**/ ?>