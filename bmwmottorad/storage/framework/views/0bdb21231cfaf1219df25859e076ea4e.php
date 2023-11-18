<?php $__env->startSection('title', 'Motos'); ?>

<?php $__env->startSection('categories'); ?>
  <div style="<?php echo \Illuminate\Support\Arr::toCssStyles([
        'background-color : grey',
        'display: flex',
        'flex-wrap: nowrap',
        'justify-content: space-around',
        'padding: auto',
        'align-items: center',
        ]) ?>">

        <?php $__currentLoopData = $gammes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gamme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a style="<?php echo \Illuminate\Support\Arr::toCssStyles(['color: black','text-decoration: none','font-size: 2em','height : 1%']) ?>"><?php echo e($gamme->libellegamme); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<h2>Les motos</h2>
<ul>
   <?php $__currentLoopData = $motos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   <a href="/moto?id=<?php echo e($moto->idmoto); ?>" style="<?php echo \Illuminate\Support\Arr::toCssStyles(['color: black','text-decoration: none']) ?>">
   <div
   style="<?php echo \Illuminate\Support\Arr::toCssStyles([
        'background: #FAFAFA',
        'border-radius: 1rem',
        'box-shadow: 0 0 5px #0000001c',
        'padding: 2em'
        ]) ?>">
        <div style="<?php echo \Illuminate\Support\Arr::toCssStyles(['color: red']) ?>">
        <?php echo e($moto->nommoto); ?>

        </div>
        <div>
        <?php echo e($moto->descriptifmoto); ?>

        </div>

    </div>
   </a>

  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.menus', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/turart/public_html/SAE_BMWMOTTORAD/bmwmottorad/resources/views/moto-list.blade.php ENDPATH**/ ?>