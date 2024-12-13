<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <h1 class="text-gray-500 dark:text-white font-bold">Area Location Reservation Report</h1>
    <div class="py-12">
        @if ($search == '1')
            <a href="{{ route('admin.locationreservations.history') }}"
                class="px-4 py-2 bg-red-500 hover:bg-red-700 rounded-lg text-white">Close Search</a>
        @endif
        <form action="{{ route('admin.locationreservations.history.search') }}" method="POST" class="mr-12">
            @csrf
            <label for="filter_datetime" class="text-gray-700 dark:text-white">Filter by Date and Time:</label>
            <input type="datetime-local" id="filter_datetime" name="date"
                class="px-2 py-1 rounded-md border border-gray-300 dark:border-gray-600 focus:outline-none focus:border-indigo-500">
            <button type="submit"
                class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg py-2 text-white">Filter</button>
        </form>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-end gap-2 m-2 p-2">
            </div>
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block py-2 min-w-full sm:px-6 lg:px-8">
                        <div
                            class="overflow-hidden shadow-md sm:rounded-lg p-2 text-gray-500 bg-gray-100 dark:text-gray-800 dark:bg-gray-100 ">
                            <table id='LocationReservationsHistory' class="min-w-full display pt-2">
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
                                            No of Guests
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
                                            Location
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Recurring
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            reference
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reservations as $reservation)
                                     @if($reservation->user)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td
                                                class="py-4 px-6 text-sm font-medium uppercase text-gray-900 whitespace-nowrap dark:text-gray-500">
                                                {{ $reservation->user->name }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                {{ $reservation->user->tel_number }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                {{ $reservation->guest_number }}
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
                                                {{ \Carbon\Carbon::parse($reservation->checkout_date)->format('m/d - H:i:s') }}
                                            </td>

                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-500">
                                                @php
                                                    $locationName = \App\Models\Location::where(
                                                        'id',
                                                        $reservation->location_id,
                                                    )->value('name');
                                                @endphp {{ $locationName }}

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
                                        </tr>
                                        @endif
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
        $('#LocationReservationsHistory').DataTable({
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
