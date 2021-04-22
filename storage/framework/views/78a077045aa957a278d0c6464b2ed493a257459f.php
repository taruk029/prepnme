<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <!-- CORE CSS-->
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link href="<?php echo e(asset('css/materialize.css')); ?>" type="text/css" rel="stylesheet">
    <link href="<?php echo e(asset('css/style.css')); ?>" type="text/css" rel="stylesheet">
    <!-- Custome CSS-->
    <link href="<?php echo e(asset('css/custom/custom.css')); ?>" type="text/css" rel="stylesheet">
    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="<?php echo e(asset('vendors/perfect-scrollbar/perfect-scrollbar.css')); ?>" type="text/css" rel="stylesheet">
    <link href="<?php echo e(asset('vendors/flag-icon/css/flag-icon.min.css')); ?>" type="text/css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> -->
    <?php echo $__env->yieldPushContent('styles'); ?>
  </head>
  <body>
    <!-- Start Page Loading -->
    <div id="loader-wrapper">
      <div id="loader"></div>
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
    </div>
    <!-- End Page Loading -->
    <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- START MAIN -->
    <div id="main">
      <!-- START WRAPPER -->
      <div class="wrapper">
        <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- START CONTENT -->
        <?php if(Session::has('flash_notification')): ?>
            <?php $__currentLoopData = session('flash_notification', collect())->toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!-- <?php print_r($message); ?> -->
                <?php if($message['level']=="success"): ?>
                    <div class="gradient-45deg-green-teal padding-2 medium-small" id="alert_notify" style="color: rgba(255, 255, 255, 0.901961);">                 
                        <?php echo e($message['message']); ?>

                    </div>
                <?php else: ?>
                <div class="deep-orange accent-2 padding-2 medium-small" id="alert_notify" style="color: rgba(255, 255, 255, 0.901961);">
                    <?php echo e($message['message']); ?>

                </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
           
        <?php endif; ?>
            <?php echo $__env->yieldContent('content'); ?>
            <!-- Modal Trigger -->      
        <!-- END CONTENT -->       
      </div>
      <!-- END WRAPPER -->
    </div>
    <!-- END MAIN -->
    <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- ================================================
    Scripts
    ================================================ -->
    <!-- jQuery Library -->
    <script type="text/javascript" src="<?php echo e(asset('vendors/jquery-3.2.1.min.js')); ?>"></script>
    <!--materialize js-->
    <script type="text/javascript" src="<?php echo e(asset('js/materialize.min.js')); ?>"></script>
    <!--scrollbar-->
    <script type="text/javascript" src="<?php echo e(asset('vendors/perfect-scrollbar/perfect-scrollbar.min.js')); ?>"></script>
    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="<?php echo e(asset('js/plugins.js')); ?>"></script>
    <!--custom-script.js - Add your own theme custom JS--> 
    <script type="text/javascript" src="<?php echo e(asset('js/custom-script.js')); ?>"></script>    
    <script src="<?php echo e(asset('js/block_ui.js')); ?>"></script>    
    <script src="<?php echo e(asset('js/bootstrap-notify.min.js')); ?>"></script>
  
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script>
    
        function NumbersOnly(evt,obj) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        } else {
            if(charCode != 32)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    function isDecimal(evt,obj) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        } else {
            if(charCode != 32)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
        
    
    function skip_space(evnt,obj) {
        var charCode = (evnt.which) ? evnt.which : evnt.keyCode;
        if (charCode == 32) {
            return false;
        }
    }
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <script type="text/javascript">
        $("body").removeAttr("style");
        setTimeout(function(){ $("#alert_notify").fadeOut(); }, 5000);
    </script>
    <script>
        var table;
     $(document).ready(function()
     {
        $('.modal-trigger').leanModal();
        table = $('#table_id').DataTable();
     });
  </script>
  </body>
</html><?php /**PATH C:\xampp\htdocs\Prepnme\resources\views/layouts/app.blade.php ENDPATH**/ ?>