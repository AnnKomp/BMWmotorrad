<html lang="<?php echo e(app()->getLocale()); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <title>BMW <?php echo $__env->yieldContent('title'); ?></title>



    </head>


    <body>

    	<header style="<?php echo \Illuminate\Support\Arr::toCssStyles([
            'background-color : #aaa',
            'display: flex',
            'flex-wrap: nowrap',
            'justify-content: space-around',
            'padding: 30px',
            'align-items: center'
            ]) ?>">
            <a href="<?php echo e(url("/")); ?>" style="<?php echo \Illuminate\Support\Arr::toCssStyles(['color: black','text-decoration: none', 'font-size: 3em','height : 1%', 'font-weight: bolder']) ?>">BMW</a>
            <a href="<?php echo e(url("/motos")); ?> " style="<?php echo \Illuminate\Support\Arr::toCssStyles(['color: black','text-decoration: none','font-size: 3em','height : 1%']) ?>">Les motos</a>
            <a href="<?php echo e(url("/motos")); ?> " style="<?php echo \Illuminate\Support\Arr::toCssStyles(['color: black','text-decoration: none','font-size: 3em','height : 1%']) ?>">Les équipements</a>
    	</header>

        <div><?php echo $__env->yieldContent('categories'); ?></div>

        <div class="container">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

    </body>
</html>
<?php /**PATH /home/turart/public_html/SAE_BMWMOTTORAD/bmwmottorad/resources/views/layouts/menus.blade.php ENDPATH**/ ?>