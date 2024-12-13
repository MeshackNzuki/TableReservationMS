<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <h1 class="text-gray-500 dark:text-white font-bold">Table Reservation List</h1>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-end gap-4 ">
                @if ($search == '1')
                    <a href="{{ route('admin.reservations.index') }}"
                        class="px-4 py-2 bg-red-500 hover:bg-red-700 rounded-lg text-white">Close Search</a>
                @endif
                <form action="{{ route('admin.reservations.search') }}" method="POST" class="mr-12">

                    @csrf
                    <label for="filter_datetime" class="text-gray-700 dark:text-white">Filter by Date and Time:</label>
                    <input type="datetime-local" id="filter_datetime" name="date"
                        class="px-2 py-1 rounded-md border border-gray-300 dark:border-gray-600 focus:outline-none focus:border-indigo-500">
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg py-2 text-white">Filter</button>
                </form>

                <a href="{{ route('admin.reservations.create') }}"
                    class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">New Reservation</a>
                <a href="{{ route('admin.locationreservations.create') }}"
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
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-400 uppercase text-gray-400">
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
                                            Recurring
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            reference
                                        </th>
                                        <th scope="col" class="relative py-3 px-6">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reservations as $reservation)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap uppercase dark:text-gray-500">
                                                {{ $reservation->user->name }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                {{ $reservation->user->tel_number }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                {{ \Carbon\Carbon::parse($reservation->res_date)->format('Y/m/d') }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                {{ \Carbon\Carbon::parse($reservation->res_date)->format('H:i:s') }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                {{ \Carbon\Carbon::parse($reservation->checkout_date)->format('m/d  H:i:s') }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                {{ $reservation->table->name }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                @php
                                                    $locationName = \App\Models\Location::where(
                                                        'id',
                                                        $reservation->table->location_id,
                                                    )->value('name');
                                                @endphp {{ $locationName }}

                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                {{ $reservation->guest_number }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                @if ($reservation->recurring == 1)
                                                    Yes
                                                @else
                                                    No
                                                @endif
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                {{ $reservation->ref }}
                                            </td>
                                            <td class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap">
                                                <div class="flex space-x-2">
                                                    @if ($reservation->cancel == 0)
                                                        <form
                                                            class="px-4 py-2 bg-yellow-500 hover:bg-yellow-700 rounded-lg  text-white"
                                                            method="POST"
                                                            action="{{ route('admin.reservations.cancel', $reservation->id) }}"
                                                            onsubmit="return confirm('Are you sure to cancel?');">
                                                            @csrf
                                                            @method('POST')
                                                            <button type="submit">Cancel</button>
                                                        </form>
                                                    @else
                                                        <form
                                                            class="px-4 py-2 bg-red-500 hover:bg-emerald-700 rounded-lg  text-white"
                                                            method="POST"
                                                            action="{{ route('admin.reservations.cancel', $reservation->id) }}"
                                                            onsubmit="return confirm('Are you sure to uncancel?');">
                                                            @csrf
                                                            @method('POST')
                                                            <button type="submit">Cancelled</button>
                                                        </form>
                                                    @endif

                                                    <a href="{{ route('admin.reservations.edit', $reservation->id) }}"
                                                        class="px-4 py-2 bg-emerald-500 hover:bg-emerald-700 rounded-lg  text-white">Edit</a>
                                                    @if (Auth::user()->is_super_admin)
                                                        <form
                                                            class="px-4 py-2 bg-red-500 hover:bg-red-700 rounded-lg text-white"
                                                            method="POST"
                                                            action="{{ route('admin.reservations.destroy', $reservation->id) }}"
                                                            onsubmit="return confirm('Are you sure to delete?') && confirm('Are you really sure, this record will be deleted from the system!');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit">Delete</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
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
