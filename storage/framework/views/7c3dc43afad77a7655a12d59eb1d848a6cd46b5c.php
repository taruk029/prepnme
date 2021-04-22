<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>


    <div class="single-course-content section-padding-100">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="course--content">
                        <div class="header_test">
                            <div class="col-12 col-lg-8" style="float: left;">
                                <p style="margin-top: 10px; line-height: 26px;">PrepNMe <?php echo e($tests->test_name); ?></p>
                                <p class="section_heading"><?php echo e($section->section); ?></p>
                            </div>
                        
                        </div>

                        <div class="clever-tabs-content">
                            
                            <div class="tab-content" id="myTabContent" >
                                <!-- Tab Text -->
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab--1">
                                    <div class="clever-description">
                                        <!-- FAQ -->
                                        <div class="clever-faqs">
                                             <h4>You’ve paused this section!</h4>
                                              <p>From your dashboard, you’ll be able to pick up where you left off whenever you’re ready.</p>
                                              <br>
                                            <center>
                                           <div style="border-top: 1px solid #eeeeee;padding: 20px;">
                                                <a href="<?php echo e(url('pause/'.Request::segment(2).'/'.Request::segment(3).'/'.Request::segment(4))); ?>" class="btn clever-btn" style="width: 300px;background: #e41515;">Leave For Now</a>
                                                  <a href="<?php echo e($_SERVER['HTTP_REFERER']); ?>" class="btn clever-btn" style="width: 300px;">Keep Working</a>
                                           </div>
                                           </center>
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
    <!-- ##### Courses Content End ##### -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout.dashboard_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\training\admin\resources\views/front/dashboard/pause_section.blade.php ENDPATH**/ ?>