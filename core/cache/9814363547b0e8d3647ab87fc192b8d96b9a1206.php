<?php $__env->startSection('title'); ?>
Home
<?php $__env->stopSection(); ?>

<?php $__env->startSection('container'); ?>
<h4 CLASS="text-accent-3 center">Bienvenue sur DOGFISH</h4>
        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <li><?php echo e($user->nom); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p>No users</p>
        <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>