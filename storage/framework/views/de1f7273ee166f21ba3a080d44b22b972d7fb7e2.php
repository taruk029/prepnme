
<?php $__currentLoopData = session('flash_notification', collect())->toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($message['overlay']): ?>
        <?php echo $__env->make('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php else: ?>
        <script>
        $.notify({
            message: '<?php echo $message['message']; ?>'
        },{
            type: '<?php echo e($message['level']); ?>',
            offsetx: 1000,
            delay: 5000,
            z_index: 1031,
            timer: 1000,
            allow_dismiss: true,
            newest_on_top: true,
            placement: {
                from: "top",
                align: "center"
            },
            animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
            }
        });
        </script>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php echo e(session()->forget('flash_notification')); ?>

<?php /**PATH C:\xampp\htdocs\training\admin\resources\views/vendor/flash/message.blade.php ENDPATH**/ ?>