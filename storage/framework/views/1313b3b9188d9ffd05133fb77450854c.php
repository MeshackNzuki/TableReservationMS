<?php if (isset($component)) { $__componentOriginal91fdd17964e43374ae18c674f95cdaa3 = $component; } ?>
<?php $component = App\View\Components\AdminLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AdminLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('User Management')); ?>

        </h2>
     <?php $__env->endSlot(); ?>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6">User Management</h1>
        <a href="<?php echo e(route('admin.users.create')); ?>"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg mb-4 inline-block">Add
            User</a>
        <?php if(session('success')): ?>
            <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <table class="w-full border-collapse border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Name</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="bg-white">
                        <td class="border p-2"><?php echo e($user->id); ?></td>
                        <td class="border p-2"><?php echo e($user->name); ?></td>
                        <td class="border p-2"><?php echo e($user->email); ?></td>
                        <td class="border p-2">
                            <a href="<?php echo e(route('admin.users.show', $user->id)); ?>"
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg">View</a>
                            <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>"
                                class="bg-yellow-500 text-white px-4 py-2 rounded-lg">Edit</a>
                            <?php if(!$user->is_super_admin): ?>
                            <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST"
                                class="inline-block">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit"
                                    class="bg-red-500 text-white px-4 py-2 rounded-lg">Delete</button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php /**PATH /home/glmokehj/public_html/resources/views/admin/users/index.blade.php ENDPATH**/ ?>