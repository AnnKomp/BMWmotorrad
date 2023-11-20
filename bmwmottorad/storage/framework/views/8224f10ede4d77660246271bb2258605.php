<html lang="<?php echo e(app()->getLocale()); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/layout-menu.css')); ?>"/>


        <title>BMW <?php echo $__env->yieldContent('title'); ?></title>



    </head>


    <body>

    	<header>
            <a href="<?php echo e(url("/")); ?>" class='menus'><img src="https://www.bmw-motorrad.fr/content/dam/bmwmotorradnsc/common/mnm/graphics/bmw_motorrad_logo.svg.asset.1585209612412.svg"></a>
            <a href="<?php echo e(url("/motos")); ?>" class='menus'>Les motos</a>
            <a href="<?php echo e(url("/motos")); ?>" class='menus'>Les équipements</a>
    	</header>

        <div><?php echo $__env->yieldContent('categories'); ?></div>

        <div class="container">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

    </body>
</html>
<?php /**PATH /home/turart/public_html/SAE301_TD2_G5/bmwmottorad/resources/views/layouts/menus.blade.php ENDPATH**/ ?>