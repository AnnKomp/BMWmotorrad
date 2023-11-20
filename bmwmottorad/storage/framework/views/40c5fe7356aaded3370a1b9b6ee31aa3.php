<?php
    $categories = [];

    // Compter le nombre de lignes par catégorie
    foreach ($infos as $info) {
        $categories[$info->nomcatcaracteristique] = isset($categories[$info->nomcatcaracteristique])
            ? $categories[$info->nomcatcaracteristique] + 1
            : 1;
    }

    $motoname = $infos[0]->nommoto;
?>



<?php $__env->startSection('title', 'Moto'); ?>

<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/moto.css')); ?>"/>

<?php $__env->startSection('categories'); ?>
    <div class = 'header_category'>
        <a href="/moto?id=<?php echo e($idmoto); ?>" class = "categories"><?php echo e($motoname); ?></a>
        <a href="/moto/color?id=<?php echo e($idmoto); ?>" class = "categories">Couleurs</a>
        <a href="/moto/pack?id=<?php echo e($idmoto); ?>" class = "categories">Packs</a>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<div class="slider-container">
<div class = 'slider'>
<?php $__currentLoopData = $moto_pics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <img src=<?php echo e($pic->lienmedia); ?>>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div></div>


<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
    $(document).ready(function(){
        $('.slider').slick({
            prevArrow: '<button type="button" class="slick-prev"></button>',
            nextArrow: '<button type="button" class="slick-next"></button>',
        });
    });
</script>



<h1>La BMW <?php echo e($motoname); ?></h1>


<p><hr NOSHADE  ALIGN=CENTER WIDTH="40%" SIZE='5'></p>


<h1>Fiche technique</h1>
<table>
<tr style='border: solid'>
    <th class='top_caracteristics'>Catégorie </th>
    <th  class='top_caracteristics'>Caractéristique</th>
    <th class='top_caracteristics'>Description</th>
</tr>

<?php $__currentLoopData = $infos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr >
        <?php if($categories[$info->nomcatcaracteristique] > 0): ?>
            <td class='category_caracteristics' rowspan="<?php echo e($categories[$info->nomcatcaracteristique]); ?>">
                <?php echo e($info->nomcatcaracteristique); ?>

            </td>
            <?php
                $categories[$info->nomcatcaracteristique] = 0;
            ?>
        <?php endif; ?>
        <td class='caracteristics_name'><?php echo e($info->nomcaracteristique); ?></td>
        <td class='caracteristics'><?php echo e($info->valeurcaracteristique); ?></td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>


<p><hr NOSHADE  ALIGN=CENTER WIDTH="40%" SIZE='5'></p>

<h1>Les options</h1>
<table>
<?php $__currentLoopData = $moto_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td class='caracteristics_name'><?php echo e($option->nomoption); ?></td>
    <td class='caracteristics'><?php echo e($option->detailoption); ?></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.menus', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/turart/public_html/SAE301_TD2_G5/bmwmottorad/resources/views/moto.blade.php ENDPATH**/ ?>