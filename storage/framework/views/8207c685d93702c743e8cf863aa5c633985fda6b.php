<?php $__env->startSection('title', 'Welcome'); ?>
<?php $__env->startSection('content'); ?>
    
    <!-- ##### Hero Area Start ##### -->
    <section class="hero-area bg-img bg-overlay-2by5" style="background-image: url(<?php echo e(asset('front/img/bg-img/test.jpg')); ?>);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <!-- Hero Content -->
                    <div class="hero-content text-center">
                        <h2>Welcome to Scoolars</h2>
                        <!-- <a href="#" class="btn clever-btn">Get Started</a> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Hero Area End ##### -->

    <!-- ##### Cool Facts Area Start ##### -->
    <section class="cool-facts-area section-padding-100-0">
        <div class="container">
            <div class="row">
                 <?php if(Session::has('message')): ?>
                <div class="col-12 col-sm-12 col-lg-12 alert alert-success" role="alert" id="alert_notify">
                 <?php echo e(Session::get( 'message' )); ?>

                </div>
                <?php endif; ?>
            </div>
            <div class="row">
                <!-- Single Cool Facts Area -->
                <div class="col-12 col-sm-6 col-lg-6">
                    <div class="single-cool-facts-area text-center mb-100 wow fadeInUp" data-wow-delay="250ms">
                        
                        <h2><i class="fa fa-desktop"></i></h2>
                        <h5><a href="<?php echo e(url('web-app')); ?>">Access your mini test and diagnostics</a></h5><br>
                        <div class="register-login-area">
                                <a href="<?php echo e(url('dashboard')); ?>" class="btn active">View Dashboard</a>
                            </div>
                    </div>
                </div>

                <!-- Single Cool Facts Area -->
                <div class="col-12 col-sm-6 col-lg-6">
                    <div class="single-cool-facts-area text-center mb-100 wow fadeInUp" data-wow-delay="500ms">
                        
                        <h2><i class="fa fa-arrow-circle-up"></i></h2>
                        <h5><a href="<?php echo e(url('pricing')); ?>">Get more practice tests.</a></h5><br>
                        <div class="register-login-area">
                              <a href="index-login.html" class="btn active">Upgrade</a>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('front.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\training\admin\resources\views/front/home.blade.php ENDPATH**/ ?>