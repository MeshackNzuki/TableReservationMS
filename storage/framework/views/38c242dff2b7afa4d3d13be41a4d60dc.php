<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rollingstones Eateries Menu</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com/3.0.24"></script>
</head>

<body>
    <div
        style="background-image: url('<?php echo e(asset('/images/bellow-menu-bg.jpg')); ?>'); background-repeat: repeat-x; top: 0;">
        <div class="max-w-screen-lg w-full px-5 py-6 mx-auto">
            <!-- Header Section -->
            <div class="flex justify-center items-center flex-col">
                <h3 class="font-bold text-3xl my-3 " style="color:rgb(107, 0, 4)">Welcome to Rollingstones Eateries!
                </h3>
                <h3 class="font-bold text-2xl text-gray-700">MENU</h3>
            </div>
        </div>
    </div>

    <hr class="my-3 border-gray-300 dark:border-gray-700" />
    <div
        style="background-image: url('<?php echo e(asset('/images/bellow-menu-bg.jpg')); ?>'); background-repeat: repeat-x; top: 0;">
        <div class="max-w-screen-lg w-full px-5 py-6 mx-auto">

            <!-- Menu Grid Section -->
            <div class="min-h-screen p-4" style="background-color: #f1e5cd">
                <?php if($menus->count() != 0): ?>
                    <?php
                        // Group menus by category
                        $menusByCategory = $menus->groupBy('category_id');
                    ?>

                    <?php $__currentLoopData = $menusByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryId => $categoryMenus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($categoryMenus->first()->category): ?>
                            <div class="w-full text-center text-2xl font-bold  mb-4">
                                <?php echo e($categoryMenus->first()->category->name); ?>

                            </div>
                        <?php endif; ?>
                        <div class="flex flex-wrap justify-center w-full">
                            <?php $__currentLoopData = $categoryMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex justify-center">
                                    <div class="max-w-xs mx-4 mb-2 rounded-sm">
                                        <img class="w-full h-48 object-cover rounded-t-lg"
                                            src="<?php echo e(Storage::url($menu->image)); ?>" alt="Image of <?php echo e($menu->name); ?>" />
                                        <div class="mt-4  text-sm font-semibold tracking-tight flex justify-between">


                                            <?php echo e($menu->name); ?> <span>.................</span>
                                            <span class="text-sm font-bold ">$<?php echo e($menu->price); ?></span>

                                        </div>
                                        <span
                                            class="text-center text-sm w-full bg-emerald-500 px-4  rounded-lg bg-opacity-40"><?php echo e($menu->description); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="col-span-4 text-center">
                        <p class="text-gray-600 dark:text-gray-300 my-10">Menu not available yet!</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</body>

</html>
<?php /**PATH C:\Users\Admin\Desktop\Mesh\ReservationsMS\resources\views/menus/index.blade.php ENDPATH**/ ?>