<?php if($model->responsive): ?>
    height: 100%; width: 100%;
<?php else: ?>
    <?php if($model->height): ?>
        height: <?php echo e($model->height); ?>px;
    <?php endif; ?>

    <?php if($model->width): ?>
        width: <?php echo e($model->width); ?>px;
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\training\admin\vendor\consoletvs\charts\src/../resources/views/_partials/dimension/css.blade.php ENDPATH**/ ?>