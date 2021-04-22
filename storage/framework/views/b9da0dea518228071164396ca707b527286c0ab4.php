<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>
<style type="text/css">
    svg text {
   font-family: FontAwesome;
}
</style>


    <div class="single-course-content section-padding-100">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-8">
                    <div class="course--content">

                        <div class="clever-tabs-content">
                            
                            <div class="tab-content" id="myTabContent">
                                <!-- Tab Text -->
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab--1">
                                    <div class="clever-description">
                                        <!-- FAQ -->
                                        <div class="clever-faqs">
                                            <h4>Your Tests</h4>
                                            <?php if(Session::has('error')): ?>
                                            <div class="alert alert-danger" role="alert" id="alert_notify">
                                              <?php echo e(Session::get( 'error' )); ?>

                                            </div>
                                            <?php endif; ?>
                                            <div class="accordions" id="accordion" role="tablist" aria-multiselectable="true">
                                                <?php $sn=1; ?>
                                                <?php if($tests): ?>
                                                    <?php $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <!-- Single Accordian Area -->
                                                <div class="panel single-accordion">
                                                    <?php /*if($sn!=1) { echo 'class="collapsed"'; } */ ?>   
                                                    <h6><a role="button" class="collapsed" aria-controls="collapse<?php echo e($sn); ?>" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo e($sn); ?>">
                                                        <?php echo e($rows->test_name); ?>

                                                    <span class="accor-open"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                                    <span class="accor-close"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                                    </a></h6>                                                    
                                                    <div id="collapse<?php echo e($sn); ?>" class="accordion-content collapse">
                                                        <ul class="list-group" style="padding: 4px;">
                                                            <?php if($sections): ?>
                                                                <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rowsec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if($rowsec->test_id == $rows->id) 
                                                                    {
                                                                       $status = App\Helpers\Helper::get_status($user_id, $rows->id, $rowsec->id);
                                                                    ?>
                                                                        <li class="list-group-item <?php if($status==2) echo "test_completed"; ?>"  >
                                                                                <div class="row">
                                                                                    <div class="col-md-2 col-sm-12" style="text-align:center;">
                                                                                       <svg width="100" height="100">
                                                                                          <circle cx="32" cy="32" r="28" stroke="#eeeeee" stroke-width="4" fill="transparent" />
                                                                                          <?php if($status!=2)
                                                                                          { ?>
                                                                                        <text fill="#000000" font-size="15" x="22" y="38"><?php echo e(App\Helpers\Helper::get_remaining_time($user_id, $rows->id, $rowsec->id)?App\Helpers\Helper::get_remaining_time($user_id, $rows->id, $rowsec->id): $rowsec->duration_in_mins); ?></text>
                                                                                    <?php } else { ?>
                                                                                        <text fill="#000000" font-size="15" x="22" y="38">&#xf00c;</text>
                                                                                    <?php } ?>
                                                                                        </svg>
                                                                                    </div>
                                                                                    <div class="col-md-6 col-sm-12" style="text-align:center;">
                                                                                       <span style="line-height: 3; text-align: left; font-size: 18px;"> <?php echo e($rowsec->section); ?></span>
                                                                                    </div>
                                                                                    <div class="col-md-4 col-sm-12">
                                                                                        <div class="register-login-area">
                                                                                            <?php 
                                                                                            if($status==1)
                                                                                            { ?>
                                                                                                <a href="<?php echo e(url('user_test/'.base64_encode($user_id).'/'.base64_encode($rows->id).'/'.base64_encode($rowsec->id).'/1')); ?>" class="btn" style="text-transform: capitalize !important;">Continue <i class="fa fa-arrow-right" aria-hidden="true"></i></a>

                                                                                            <?php }
                                                                                            elseif($status!=2)
                                                                                          { ?>
                                                                                            <a href="<?php echo e(url('user_test/'.base64_encode($user_id).'/'.base64_encode($rows->id).'/'.base64_encode($rowsec->id).'/1')); ?>" class="btn" style="text-transform: capitalize !important;">Start <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                                                                            <?php } else { ?>
                                                                                                 <a href="<?php echo e(url('analysis/'.base64_encode($user_id).'/'.base64_encode($rows->id).'/'.base64_encode(0))); ?>" class="btn" style="text-transform: capitalize !important;"> <i class="fa fa-bar-chart" aria-hidden="true"></i>View Results</a>
                                                                                                <?php } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                        </li>
                                                                    <?php  } ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                 <?php $sn++; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                                <!-- Single Accordian Area -->
                                                <!-- <div class="panel single-accordion">
                                                    <h6>
                                                        <a role="button" class="collapsed" aria-expanded="true" aria-controls="collapseTwo" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">What is the refund policy?
                                                        <span class="accor-open"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                                        <span class="accor-close"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                                        </a>
                                                    </h6>
                                                    <div id="collapseTwo" class="accordion-content collapse">
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vel lectus eu felis semper finibus ac eget ipsum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vulputate id justo quis facilisis.</p>
                                                    </div>
                                                </div> -->
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <?php if($upgrade_membership): ?>
                <div class="col-sm-12 col-lg-4" style="display: block; background-repeat: repeat-x;
    background-image: -webkit-linear-gradient(135deg, #65a844 0, #fff 150%);
    background-image: -o-linear-gradient(135deg, #65a844 0, #fff 150%);
    background-image: linear-gradient(135deg, #65a844 0, #fff 150%); padding: 20px; height: 370px; border-radius: 5px; border: 1px solid #65a844">
                    <h3 style='text-transform: uppercase;
                        margin: 0 0 5px 0;
                        color: #fff;    font-size: 23px;'>Upgrade your account to get the practice you need!</h3>
                    <ul style="color: #fff;list-style-type: disc !important; padding: 20px; line-height: 25px;">
                        <li><i class="fa fa-angle-right"></i> More Full length tests</li>
                        <li><i class="fa fa-angle-right"></i> 3 tests for Starter level</li>
                        <li><i class="fa fa-angle-right"></i> 5 tests for Scholar level</li>
                        <li><i class="fa fa-angle-right"></i> Full access to the test questions for one year</li>
                        <li><i class="fa fa-angle-right"></i> Dedicated support</li>
                        <li><i class="fa fa-angle-right"></i> Feedback provided in 24 hours guaranteed</li>
                    </ul>
                    <a class="btn btn-success" href="https://www.prepnme.com/user-login/" style="float: right;">Upgrade</a>
                </div>
                 <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- ##### Courses Content End ##### -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout.dashboard_app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Prepnme\resources\views/front/dashboard/home.blade.php ENDPATH**/ ?>