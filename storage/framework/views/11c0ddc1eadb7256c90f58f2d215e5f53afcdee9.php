<script type="text/javascript">
    var <?php echo e($model->id); ?>;
    $(function () {
        <?php echo e($model->id); ?> = new Highcharts.Chart({
            colors: [
                <?php $__currentLoopData = $model->colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    "<?php echo e($c); ?>",
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ],
            chart: {
                renderTo: "<?php echo e($model->id); ?>",
                <?php echo $__env->make('charts::_partials.dimension.js2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                backgroundColor: null,
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
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
            tooltip: {
                pointFormat: '{point.y} <b>({point.percentage:.1f}%)</strong>'
                /*pointFormat: '{point.y} <b>({point.percentage:.1f}%)</strong>'*/
            },
            plotOptions: {
                pie: {
                    innerSize: '60%',
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false,
                        format: '<b>{point.name}</strong>: {point.y} ({point.percentage:.1f}%)',
                        /*format: '<b>{point.name}</strong>: {point.y} ({point.percentage:.1f}%)',*/
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            legend: {
                <?php if(!$model->legend): ?>
                    enabled: false
                <?php endif; ?>
            },
            series: [{
                colorByPoint: true,
                data: [
                    <?php for($l = 0; $l < count($model->values); $l++): ?>
                        {
                            name: "<?php echo $model->labels[$l]; ?>",
                            y: <?php echo e($model->values[$l]); ?>

                        },
                    <?php endfor; ?>
                ]
            }]
        })
    });
</script>

<?php if(!$model->customId): ?>
    <?php echo $__env->make('charts::_partials.container.div', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\training\admin\resources\views/vendor/charts/highcharts/donut.blade.php ENDPATH**/ ?>