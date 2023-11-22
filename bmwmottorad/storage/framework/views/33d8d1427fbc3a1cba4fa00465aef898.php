<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/moto-list.css')); ?>"/>

<?php $__env->startSection('categories'); ?>
    <div class = 'header_category'>
        <a href="/motos" class="categories">Voir tout</a>
        <?php $__currentLoopData = $ranges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="/motos-filtered?id=<?php echo e($range->idgamme); ?>" class = "categories">
                <?php echo e($range->libellegamme); ?>

            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="moto_display">
<?php $__currentLoopData = $motos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<a href="/moto?id=<?php echo e($moto->idmoto); ?>" class = "moto_lien">
    <div class = 'moto_box' >
        <div class = 'moto_name'>
            <?php echo e($moto->nommoto); ?>

        </div>
        <img width=100% height=100% src=<?php echo e($moto->lienmedia); ?>>


    </div>


</a>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.menus', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/turart/public_html/SAE301_TD2_G5/bmwmottorad/resources/views/moto-list-filtered.blade.php ENDPATH**/ ?>