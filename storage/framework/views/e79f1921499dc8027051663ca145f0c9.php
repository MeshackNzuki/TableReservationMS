
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rollingstones Eateries Menu</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com/3.0.24"></script>
</head>

<body>
        <div
        <div class="max-w-screen-lg w-full px-1 bg-black  mx-auto">
            <!-- Menu Grid Section -->
            <div class="min-h-screen bg-black text-[#efbf04]">
              <div class="flex flex-row justify-center items-center"><a href="/menus-dev"><svg class="w-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg></a>
  <h1 class="font-bold text-4xl  my-4"><?php echo e($category->name); ?></h1></div>
                <?php $__currentLoopData = $menu_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex justify-center">
                    <div class="max-w-xs w-full  mb-2 rounded-sm">
                        <div class="mt-4 text-sm font-semibold uppercase  flex justify-between">
                            <?php echo e($item->name); ?> 
                            <span class="text-sm font-bold "><span>.............</span><?php echo e($item->price); ?></span>
                        </div>
                        <span class="text-left text-sm w-full text-white"><?php echo e($item->description); ?></span>
                    </div>
                </div>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
             <div class="w-full text-center">End!</div>
            </div>
        </div>
    </div>
</body>

<?php /**PATH /home/glmokehj/public_html/resources/views/menus/menu_items.blade.php ENDPATH**/ ?>