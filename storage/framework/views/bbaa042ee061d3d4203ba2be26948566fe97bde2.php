<?php
    // Get the max / min index
    $max = 0;
    $min = $model->values ? $model->values[0] : 0;
?>

<?php $__currentLoopData = $model->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($dta > $max): ?>
        <?php ($max = $dta); ?>
    <?php elseif($dta < $min): ?>
        <?php ($min = $dta); ?>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<script type="text/javascript">
    var <?php echo e($model->id); ?>;
    $(function () {
        <?php echo e($model->id); ?> = new Highcharts.Map({
            chart: {
                renderTo:  "<?php echo e($model->id); ?>",
                <?php echo $__env->make('charts::_partials.dimension.js2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            },
            <?php if($model->title): ?>
                title: {
                    text:  "<?php echo $model->title; ?>"
                },
            <?php endif; ?>
            <?php if(!$model->credits): ?>
                credits: {
                    enabled: false
                },
            <?php endif; ?>
            mapNavigation: {
                enabled: true,
                enableDoubleClickZoomTo: true
            },
            colorAxis: {
                min: <?php echo e($min); ?>,
                <?php if($model->colors and count($model->colors) >= 2): ?>
                    minColor: "<?php echo e($model->colors[0]); ?>",
                <?php endif; ?>

                max: <?php echo e($max); ?>,
                <?php if($model->colors and count($model->colors) >= 2): ?>
                    maxColor: "<?php echo e($model->colors[1]); ?>",
                <?php endif; ?>
            },
            series : [{
                data : [
                    <?php for($i = 0; $i < count($model->values); $i++): ?>
                        {
                            'code':  "<?php echo e($model->labels[$i]); ?>",
                            'value': <?php echo e($model->values[$i]); ?>

                        },
                    <?php endfor; ?>
                ],
                mapData: Highcharts.maps['custom/world'],
                joinBy: ['iso-a2', 'code'],
                name: "<?php echo $model->element_label; ?>",
                states: {
                    hover: {
                        color: '#BADA55'
                    }
                },
            }]
        })
    });
</script>

<?php if(!$model->customId): ?>
    <?php echo $__env->make('charts::_partials.container.div', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\training\admin\vendor\consoletvs\charts\src/../resources/views/highcharts/geo.blade.php ENDPATH**/ ?>