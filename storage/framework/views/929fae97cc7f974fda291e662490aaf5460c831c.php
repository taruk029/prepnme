<?php if(!$model->responsive): ?>
    <?php if($model->height): ?>
        height: <?php echo e($model->height); ?>,
    <?php endif; ?>

    <?php if($model->width): ?>
        width: <?php echo e($model->width); ?>,
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\training\admin\resources\views/vendor/charts/_partials/dimension/js2.blade.php ENDPATH**/ ?>