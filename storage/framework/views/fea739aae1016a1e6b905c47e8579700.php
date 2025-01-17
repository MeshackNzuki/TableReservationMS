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
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4 px-4 mt-8 sm:grid-cols-4 sm:px-8 mb-2">
                <div class="flex items-center bg-white  rounded-lg overflow-hidden shadow">
                    <div class="p-4 bg-emerald-500"><svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg></div>
                    <div class="px-4 text-gray-700">
                        <h3 class="text-sm tracking-wider">Total Customers</h3>
                        <p class="text-3xl"><?php echo e($total_customers); ?></p>
                    </div>
                </div>
                <div class="flex items-center bg-white  rounded-lg overflow-hidden shadow">
                    <div class="p-4 bg-blue-400"><svg class="w-12 h-12 text-white dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11v5m0 0 2-2m-2 2-2-2M3 6v1a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Zm2 2v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8H5Z" />
                        </svg>
                    </div>
                    <div class="px-4 text-gray-700">
                        <h3 class="text-sm tracking-wider">Total bookings</h3>
                        <p class="text-3xl"><?php echo e($total_bookings); ?></p>
                    </div>
                </div>
                <div class="flex items-center bg-white  rounded-lg overflow-hidden shadow">
                    <div class="p-4 bg-indigo-400"><svg class="w-12 h-12 text-white dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 5V3m0 18v-2M7.05 7.05 5.636 5.636m12.728 12.728L16.95 16.95M5 12H3m18 0h-2M7.05 16.95l-1.414 1.414M18.364 5.636 16.95 7.05M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" />
                        </svg>
                    </div>
                    <div class="px-4 text-gray-700">
                        <h3 class="text-sm tracking-wider">Today's bookings</h3>
                        <p class="text-3xl"><?php echo e($todays_bookings); ?></p>
                    </div>
                </div>
                <div class="flex items-center bg-white  rounded-lg overflow-hidden shadow">
                    <div class="p-4 bg-purple-500"><svg class="w-12 h-12 text-white dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div class="px-4 text-gray-700">
                        <h3 class="text-sm tracking-wider">Upcoming bookings</h3>
                        <p class="text-3xl"><?php echo e($upcoming_bookings); ?></p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col md:flex-row justify-around">
                <div class="flex justify-around items-center rounded-lg">
                    <?php if($filter == '1'): ?>
                        <span class="px-4 bg-sky-500 hover:bg-sky-700 rounded-lg text-white">
                            <?php echo e(\Carbon\Carbon::parse($startdate)->format('Y-m-d H:i')); ?>

                            <span class="mx-2 dark:text-white font-bold">TO</span>
                            <?php echo e(\Carbon\Carbon::parse($enddate)->format('Y-m-d H:i')); ?>

                        </span>
                        <a href="/admin"
                            class="flex items-center px-4 bg-sky-500 hover:bg-sky-700 rounded-lg text-white ml-2">
                            <i class="fas fa-times"></i>
                            <span class="ml-1">Close filter</span>
                        </a>
                    <?php endif; ?>
                </div>

                <form action="<?php echo e(route('admin.reservationshome.filter')); ?>" method="POST"
                    class="flex justify-around items-center rounded-lg mr-12 flex-col md:flex-row gap-2"
                    id="reservationForm">
                    <?php echo csrf_field(); ?>
                    <div class="">
                        <label for="filter_date" class="text-gray-700 dark:text-white">Date</label>
                        <input type="text" id="filter_date" name="date"
                            class="px-2 py-1 rounded-md border border-gray-300 dark:border-gray-600 focus:outline-none focus:border-indigo-500"
                            placeholder="YYYY-MM-DD">
                    </div>
                    <div class="flex items-center space-x-4">
                        <label class="text-gray-700 dark:text-gray-300 mr-2">Period :</label>
                        <div class="flex items-center">
                            <input type="checkbox" id="morning" class="hidden peer" name="time_period"
                                value="morning">
                            <label for="morning"
                                class="flex items-center justify-center w-8 h-8 border-2 border-gray-700 dark:border-gray-300 bg-gray-200  rounded-lg cursor-pointer peer-checked:bg-gradient-to-r from-red-500  to-rose-600 peer-checked:border-emerald-500 transition duration-200 ease-in-out">
                                <svg class="hidden w-4 h-4 text-white peer-checked:block"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a1 1 0 01-.707-.293l-4-4a1 1 0 011.414-1.414L10 15.586l7.293-7.293a1 1 0 011.414 1.414l-8 8A1 1 0 0110 18z"
                                        clip-rule="evenodd" />
                                </svg>
                            </label>
                            <label for="morning" class="text-gray-700 dark:text-gray-300 ml-2">Morning</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="evening" class="hidden peer" name="time_period"
                                value="evening">
                            <label for="evening"
                                class="flex items-center justify-center w-8 h-8 border-2 border-gray-700 dark:border-gray-300 bg-gray-200 rounded-lg cursor-pointer peer-checked:bg-gradient-to-r from-red-500  to-rose-600 peer-checked:border-emerald-500 transition duration-200 ease-in-out">
                                <svg class="hidden w-4 h-4 text-white peer-checked:block"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a1 1 0 01-.707-.293l-4-4a1 1 0 011.414-1.414L10 15.586l7.293-7.293a1 1 0 011.414 1.414l-8 8A1 1 0 0110 18z"
                                        clip-rule="evenodd" />
                                </svg>
                            </label>
                            <label for="evening" class="text-gray-700 dark:text-gray-300 ml-2">Evening</label>
                        </div>
                    </div>


                    <input type="hidden" id="start_date" name="start_date">
                    <input type="hidden" id="end_date" name="end_date">

                    <button type="submit"
                        class="px-4 bg-indigo-500 hover:bg-indigo-700 rounded-lg py-2 text-white">Filter</button>
                </form>
            </div>
            <div class="flex justify-between m-2 p-2">

                <div class=" w-full flex justify-between items-center">
                    <div class="flex">
                        <div class="flex items-center mr-4 ">
                            <div class="h-6 w-6 rounded-full bg-gradient-to-r from-emerald-600 to bg-emerald-400 mr-2">
                            </div>
                            <div class="dark:text-white ml-2">Available</div>
                        </div>
                        <div class="flex items-center ml-2">
                            <div class="h-6 w-6 rounded-full bg-gradient-to-r from-red-500  to-rose-600 mr-2"></div>
                            <div class="dark:text-white ml-2">Reserved</div>
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="dark:text-white font-bold">BANDAS</h4>
            <hr>
            <div class="flex flex-wrap w-full justify-between mt-6 mb-6">
                <?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $reservations = $table->reservations;
                        $reservationIds = $reservations->pluck('id')->toArray();
                    ?>
                    <?php if($table->location->name == 'Banda'): ?>
                        <a href="/admin/reservation/show/<?php echo e(implode(',', $reservationIds)); ?>">
                            <span
                                class="m-2 flex justify-center rounded-full items-center px-4 py-2                               
                                <?php
$reservationOverlap = false;
                                foreach ($reservations as $reservation) {
                                    $resStartDate = \Carbon\Carbon::parse($reservation->res_date);
                                    $resEndDate = \Carbon\Carbon::parse($reservation->checkout_date);
                                    $reservationOverlap = ($startdate != null && $enddate != null)
                                        ? ($resStartDate->between($startdate, $enddate))
                                        : $resStartDate->isToday() && $resEndDate->isToday() ;
                                    if ($reservationOverlap) {
                                        break;
                                    }
                                }
                                echo $reservationOverlap ? 'bg-gradient-to-r from-red-500  to-rose-600 hover:bg-red-700' : 'bg-gradient-to-r from-emerald-600 to bg-emerald-400 hover:bg-emerald-700'; ?>
                                shadow-lg text-white"
                                style="height:90px; width:90px">
                                <strong><?php echo e($table->name); ?></strong>
                            </span>
                        </a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <h4 class="dark:text-white font-bold">DUG</h4>
            <hr>
            <div class="flex flex-wrap w-full justify-between mt-6 mb-6">
                <?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $reservations = $table->reservations;
                        $reservationIds = $reservations->pluck('id')->toArray();
                    ?>

                    <?php if($table->location->name == 'DUG'): ?>
                        <a href="/admin/reservation/show/<?php echo e(implode(',', $reservationIds)); ?>">
                            <span
                                class="m-2 flex justify-center rounded-full items-center px-4 py-2                               
                            <?php
$reservationOverlap = false;
                            foreach ($reservations as $reservation) {
                                $resStartDate = \Carbon\Carbon::parse($reservation->res_date);
                                $resEndDate = \Carbon\Carbon::parse($reservation->checkout_date);

                         
                                $reservationOverlap = ($startdate != null && $enddate != null)
                                    ? ($resStartDate->between($startdate, $enddate))
                                    : $resStartDate->isToday() && $resEndDate->isToday() ;
                                if ($reservationOverlap) {
                                    break;
                                }
                            }
                            echo $reservationOverlap ? 'bg-gradient-to-r from-red-500  to-rose-600 hover:bg-red-700' : 'bg-gradient-to-r from-emerald-600 to bg-emerald-400 hover:bg-emerald-700'; ?>
                            shadow-lg text-white"
                                style="height:90px; width:90px;clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);">
                                <strong><?php echo e($table->name); ?></strong>
                            </span>
                        </a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <h4 class="dark:text-white font-bold">BAR</h4>
            <hr>
            <div class="flex flex-wrap w-full justify-between mt-6 mb-6">
                <?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $reservations = $table->reservations;
                        $reservationIds = $reservations->pluck('id')->toArray();
                    ?>


                    <?php if($table->location->name == 'Bar'): ?>
                        <a href="/admin/reservation/show/<?php echo e(implode(',', $reservationIds)); ?>">
                            <span
                                class="m-2 flex justify-center rounded-full items-center px-4 py-2                               
                            <?php
$reservationOverlap = false;
                            foreach ($reservations as $reservation) {
                                $resStartDate = \Carbon\Carbon::parse($reservation->res_date);
                                $resEndDate = \Carbon\Carbon::parse($reservation->checkout_date);

                       

                                $reservationOverlap = ($startdate != null && $enddate != null)
                                    ? ($resStartDate->between($startdate, $enddate))
                                    : $resStartDate->isToday() && $resEndDate->isToday() ;
                                if ($reservationOverlap) {
                                    break;
                                }
                            }
                            echo $reservationOverlap ? 'bg-gradient-to-r from-red-500  to-rose-600 hover:bg-red-700' : 'bg-gradient-to-r from-emerald-600 to bg-emerald-400 hover:bg-emerald-700'; ?>
                            shadow-lg text-white"
                                style="height:60px; width:100px">
                                <strong><?php echo e($table->name); ?></strong>
                            </span>
                        </a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <h4 class="dark:text-white font-bold">BAR - (Lawn)</h4>
            <hr>
            <div class="flex flex-wrap w-full justify-between mt-6 mb-6">
                <?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $reservations = $table->reservations;
                        $reservationIds = $reservations->pluck('id')->toArray();
                    ?>

                    <?php if($table->location->name == 'Bar( Lawn)'): ?>
                        <a href="/admin/reservation/show/<?php echo e(implode(',', $reservationIds)); ?>">
                            <span
                                class="m-2 flex justify-center rounded-full items-center px-4 py-2                               
                                <?php
$reservationOverlap = false;
                                foreach ($reservations as $reservation) {
                                    $resStartDate = \Carbon\Carbon::parse($reservation->res_date);
                                    $resEndDate = \Carbon\Carbon::parse($reservation->checkout_date);

                                    $reservationOverlap = ($startdate != null && $enddate != null)
                                        ? ($resStartDate->between($startdate, $enddate))
                                        : $resStartDate->isToday() && $resEndDate->isToday() ;
                                    if ($reservationOverlap) {
                                        break;
                                    }
                                }
                                echo $reservationOverlap ? 'bg-gradient-to-r from-red-500  to-rose-600 hover:bg-red-700' : 'bg-gradient-to-r from-emerald-600 to bg-emerald-400 hover:bg-emerald-700'; ?>
                                shadow-lg text-white"
                                style="height:90px; width:90px;clip-path: polygon(50% 0%, 85% 13%, 100% 50%, 85% 87%, 50% 100%, 15% 87%, 0% 50%, 15% 13%););">
                                <strong><?php echo e($table->name); ?></strong>
                            </span>
                        </a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <h4 class="dark:text-white font-bold">BANQUET</h4>
            <hr>
            <div class="flex flex-wrap w-full justify-between mt-6 mb-6">
                <?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($table->location->name == 'Banquet'): ?>
                        <?php
                            $reservations = $table->reservations;
                            $reservationIds = $reservations->pluck('id')->toArray();
                            $AreaReservations = App\Models\LocationReservations::where(
                                'location_id',
                                $table->location->id,
                            )
                                ->whereDate('res_date', \Carbon\Carbon::parse($startdate)->toDateString())
                                ->get();
                        ?>

                        <a href="/admin/reservation/show/<?php echo e(implode(',', $reservationIds)); ?>">
                            <span
                                class="m-2 flex justify-center rounded-lg items-center px-4 py-2                               
                                <?php
$reservationOverlapTables = false;
                                $reservationOverlapAreas = false;
                              foreach ($AreaReservations as $reservation) {
                                    $resStartDate = \Carbon\Carbon::parse($reservation->res_date);
                                    $resEndDate = \Carbon\Carbon::parse($reservation->checkout_date);

                                    $reservationOverlapAreas = ($startdate != null && $enddate != null)
                                        ? ($resStartDate->between($startdate, $enddate))
                                        : $resStartDate->isToday() && $resEndDate->isToday() ;
                                    if ($reservationOverlapAreas) {
                                        break;
                                    }
                                }
                                foreach ($reservations as $reservation) {
                                    $resStartDate = \Carbon\Carbon::parse($reservation->res_date);
                                    $resEndDate = \Carbon\Carbon::parse($reservation->checkout_date);

                                    $reservationOverlapTables = ($startdate != null && $enddate != null)
                                        ? ($resStartDate->between($startdate, $enddate))
                                        : $resStartDate->isToday() && $resEndDate->isToday() ;
                                    if ($reservationOverlapTables) {
                                        break;
                                    }
                                }
                                echo $reservationOverlapTables || $reservationOverlapAreas ? 'bg-gradient-to-r from-red-500  to-rose-600 hover:bg-red-700' : 'bg-gradient-to-r from-emerald-600 to bg-emerald-400 hover:bg-emerald-700'; ?>
                                shadow-lg text-white"
                                style="height:60px; width:100px">
                                <strong><?php echo e($table->name); ?></strong>
                            </span>
                        </a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    flatpickr("#filter_date", {
        dateFormat: "Y-m-d"
    });

    $('#reservationForm').on('submit', function(event) {
        event.preventDefault();

        let selectedDate = $('#filter_date').val();
        const timePeriod = $('input[name="time_period"]:checked').val();

        if (!selectedDate) {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based
            const dd = String(today.getDate()).padStart(2, '0');
            selectedDate = `${yyyy}-${mm}-${dd}`;
        }

        let startDate, endDate;

        if (!timePeriod) {
            startDate = `${selectedDate}T00:00`;
            endDate = `${selectedDate}T23:59`;
        } else if (timePeriod === 'morning') {
            startDate = `${selectedDate}T11:00`;
            endDate = `${selectedDate}T18:00`;
        } else if (timePeriod === 'evening') {
            startDate = `${selectedDate}T18:00`;
            endDate = `${selectedDate}T23:59`;
        }

        $('#start_date').val(startDate);
        $('#end_date').val(endDate);

        this.submit();
    });
</script>
<?php /**PATH C:\Users\meshk\OneDrive\Desktop\Mesh\Gozerolabs\TableReservationMS\resources\views/admin/index.blade.php ENDPATH**/ ?>