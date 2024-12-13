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
            <?php echo e(__('Dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?>
    <h1 class="text-gray-500 dark:text-white font-bold">Manage Recurring Reservations (ALL)</h1>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-end gap-4">
                <a href="<?php echo e(route('admin.reservations.create')); ?>"
                    class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">New Reservation</a>
                <a href="<?php echo e(route('admin.locationreservations.create')); ?>"
                    class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">Area Reservation</a>
            </div>
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block py-2 min-w-full sm:px-6 lg:px-8">
                        <div
                            class="overflow-hidden shadow-md sm:rounded-lg p-2 text-gray-500 bg-gray-100 dark:text-gray-800 dark:bg-gray-100 ">
                            <table id='TableReservations' class="min-w-full display pt-2">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left  uppercase text-gray-400">
                                            Name
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Phone
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Date
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Time In
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Time Out
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Table
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Location
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            No of Guests
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Day of Week
                                        </th>
                                        <th scope="col" class="relative py-3 px-6">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap uppercase dark:text-gray-500">
                                                <?php echo e($reservation->user->name); ?>

                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                <?php echo e($reservation->user->tel_number); ?>

                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                <?php echo e(\Carbon\Carbon::parse($reservation->res_date)->format('Y/m/d')); ?>

                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                <?php echo e(\Carbon\Carbon::parse($reservation->res_date)->format('H:i:s')); ?>

                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                <?php echo e(\Carbon\Carbon::parse($reservation->checkout_date)->format('m/d  H:i:s')); ?>

                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                <?php echo e($reservation->table->name); ?>

                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                <?php
                                                    $locationName = \App\Models\Location::where(
                                                        'id',
                                                        $reservation->table->location_id,
                                                    )->value('name');
                                                ?> <?php echo e($locationName); ?>


                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                <?php echo e($reservation->guest_number); ?>

                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                <?php echo e($reservation->day_of_week); ?>

                                            </td>
                                            <td class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap">
                                                <div class="flex space-x-2">
                                                    <?php if($reservation->cancel == 0): ?>
                                                        <form
                                                            class="px-4 py-2 bg-yellow-500 hover:bg-yellow-700 rounded-lg  text-white"
                                                            method="POST"
                                                            action="<?php echo e(route('admin.reservations.cancel', $reservation->id)); ?>"
                                                            onsubmit="return confirm('Are you sure to council?');">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('POST'); ?>
                                                            <button type="submit">Cancel</button>
                                                        </form>
                                                    <?php else: ?>
                                                        <form
                                                            class="px-4 py-2 bg-red-500 hover:bg-emerald-700 rounded-lg  text-white"
                                                            method="POST"
                                                            action="<?php echo e(route('admin.reservations.cancel', $reservation->id)); ?>"
                                                            onsubmit="return confirm('Are you sure to uncouncil?');">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('POST'); ?>
                                                            <button type="submit">Cancelled</button>
                                                        </form>
                                                    <?php endif; ?>
                                                    <a href="<?php echo e(route('admin.reservations.edit', $reservation->id)); ?>"
                                                        class="px-4 py-2 bg-emerald-500 hover:bg-emerald-700 rounded-lg  text-white">Edit</a>
                                                    <?php if(Auth::user()->is_super_admin): ?>
                                                        <form
                                                            class="px-4 py-2 bg-red-500 hover:bg-red-700 rounded-lg text-white"
                                                            method="POST"
                                                            action="<?php echo e(route('admin.reservations.destroy', $reservation->id)); ?>"
                                                            onsubmit="return confirm('Are you sure to delete?') && confirm('Are you really sure, this record will be deleted from the system!');">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                            <button type="submit">Delete</button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $locationreservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap uppercase dark:text-gray-500">
                                                <?php echo e($reservation->user->name); ?>

                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                <?php echo e($reservation->user->tel_number); ?>

                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                <?php echo e(\Carbon\Carbon::parse($reservation->res_date)->format('Y/m/d')); ?>

                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                <?php echo e(\Carbon\Carbon::parse($reservation->res_date)->format('H:i:s')); ?>

                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                <?php echo e(\Carbon\Carbon::parse($reservation->checkout_date)->format('m/d  H:i:s')); ?>

                                            </td>
                                            <td
                                                class=" px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500 bg-emerald-300 rounded-lg">
                                                All Tables
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                <?php
                                                    $locationName = \App\Models\Location::where(
                                                        'id',
                                                        $reservation->location_id,
                                                    )->value('name');
                                                ?> <?php echo e($locationName); ?>


                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                <?php echo e($reservation->guest_number); ?>

                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                <?php echo e($reservation->day_of_week); ?>

                                            </td>
                                            <td class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap">
                                                <div class="flex space-x-2">
                                                    <?php if($reservation->cancel == 0): ?>
                                                        <form
                                                            class="px-4 py-2 bg-yellow-500 hover:bg-yellow-700 rounded-lg  text-white"
                                                            method="POST"
                                                            action="<?php echo e(route('admin.locationreservations.cancel', $reservation->id)); ?>"
                                                            onsubmit="return confirm('Are you sure to council?');">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('POST'); ?>
                                                            <button type="submit">Cancel</button>
                                                        </form>
                                                    <?php else: ?>
                                                        <form
                                                            class="px-4 py-2 bg-red-500 hover:bg-emerald-700 rounded-lg  text-white"
                                                            method="POST"
                                                            action="<?php echo e(route('admin.locationreservations.cancel', $reservation->id)); ?>"
                                                            onsubmit="return confirm('Are you sure to uncouncil?');">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('POST'); ?>
                                                            <button type="submit">Cancelled</button>
                                                        </form>
                                                    <?php endif; ?>
                                                    <a href="<?php echo e(route('admin.locationreservations.edit', $reservation->id)); ?>"
                                                        class="px-4 py-2 bg-emerald-500 hover:bg-emerald-700 rounded-lg
                                            text-white">Edit</a>
                                                    <?php if(Auth::user()->is_super_admin): ?>
                                                        <form
                                                            class="px-4 py-2 bg-red-500 hover:bg-red-700 rounded-lg text-white"
                                                            method="POST"
                                                            action="/admin/reservation/location-delete/<?php echo e($reservation->id); ?>"
                                                            onsubmit="return confirm('Are you sure to delete?') && confirm('Are you really sure, this record will be deleted from the system!');">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="_method" value="POST">
                                                            <button type="submit">Delete</button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<script>
    $(document).ready(function() {
        $('.dt-input').addClass('text-gray-500');
        $('#TableReservations').DataTable({
            "order": [
                [2, "asc"]
            ], // Set initial ordering by the third column (index 2) in ascending order
            "layout": {
                "topStart": {
                    "buttons": ['copy', 'csv', 'excel', 'pdf', 'print']
                }
            }
        });
    });
</script>
<?php /**PATH /home/glmokehj/public_html/resources/views/admin/recurring/index.blade.php ENDPATH**/ ?>