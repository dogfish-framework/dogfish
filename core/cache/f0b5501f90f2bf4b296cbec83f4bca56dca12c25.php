<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo e(url('css/materialize/fontemeterilize.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(url('css/materialize/iconematerialize.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(url('css/materialize/materialize.min.css')); ?>" type="text/css" rel="stylesheet">
    <!-- if !isDemo-->

    <title><?php echo $__env->yieldContent('title','Home'); ?></title>
</head>
<body>

<nav>
    <div class="nav-wrapper">
        <a href="/" class="brand-logo ">Dog-FISH
            <img src="<?php echo e(url('DOGFISH.png')); ?>" width="80" height="50">
        </a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            <li><a href="#">Docummentation</a></li>
            <li><a href="#">Demontration</a></li>
            <li><a href="#">Sources</a></li>
        </ul>
    </div>
</nav>

<ul class="sidenav" id="mobile-demo">
    <li class="btn-block text-darken-1 " style="background: #ee6e73;text-align: center">MENU</li>
    <li><a href="#">Docummentation</a></li><hr>
    <li><a href="#">Demontration</a></li><hr>
    <li><a href="#">Sources</a></li><hr>
</ul>
<div class="container">
    <?php echo $__env->yieldContent('container',''); ?>
</div>

<script src="<?php echo e(url('js/materialize/jquery.min.js')); ?>"></script>
<script src="<?php echo e(url('js/materialize/materialize.min.js')); ?>"></script>
<script src="<?php echo e(url('js/app/main.js')); ?>"></script>
</body>
</html>

