<?php $__env->startSection('title'); ?>
Home
<?php $__env->stopSection(); ?>

<?php $__env->startSection('container'); ?>
<h4 CLASS="text-accent-3 center">Bienvenue sur DOGFISH</h4>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>