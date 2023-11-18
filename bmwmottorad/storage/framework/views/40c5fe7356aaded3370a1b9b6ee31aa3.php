<?php $__env->startSection('title', 'Moto'); ?>

<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/moto.css')); ?>"/>


<?php $__env->startSection('content'); ?>

<h1>Fiche technique</h1>
<table>
<?php $__currentLoopData = $infos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
<td class='category_caracteristics'><?php echo e($info->nomcatcaracteristique); ?></td>
<td class='caracteristics_name'><?php echo e($info->nomcaracteristique); ?></td>
<td class='caracteristics'><?php echo e($info->valeurcaracteristique); ?></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.menus', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/turart/public_html/SAE301_TD2_G5/bmwmottorad/resources/views/moto.blade.php ENDPATH**/ ?>