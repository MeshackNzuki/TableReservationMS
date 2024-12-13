<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex m-2 p-2">
                <a href="{{ route('admin.locationreservations.index') }}"
                    class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">Reservation List
                    (Locations)</a>
            </div>
            <div class="m-2 p-2 bg-slate-100 rounded flex justify-center">
                <div class="space-y-8 divide-y divide-gray-200 w-full lg:w-1/2 mt-10">
                    <div class="bg-green-200 rounded-lg p-1 text-xs text-center"> if customer already exists, skip
                        username and
                        email, enter
                        the phone number.
                    </div>
                    <form method="POST" action="{{ route('admin.locationreservations.store') }}">
                        @csrf
                        <div class="sm:col-span-6">
                            <label for="first_name" class="block text-sm font-medium text-gray-700"> Full Name </label>
                            <div class="mt-1">
                                <input type="text" id="first_name" name="name" value="{{ old('name') }}"
                                    class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                            </div>
                            @error('name')
                                <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="sm:col-span-6">
                            <label for="email" class="block text-sm font-medium text-gray-700"> Email </label>
                            <div class="mt-1">
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                    class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                            </div>
                            @error('email')
                                <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="sm:col-span-6">
                            <label for="tel_number" class="block text-sm font-medium text-gray-700"> Phone number
                            </label>
                            <div class="mt-1">
                                <input type="text" id="tel_number" name="tel_number" value="{{ old('tel_number') }}"
                                    class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                            </div>
                            @error('tel_number')
                                <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="sm:col-span-6">
                            <label for="res_date" class="block text-sm font-medium text-gray-700"> Reservation Date
                            </label>
                            <div class="mt-1">
                                <input type="datetime-local" id="res_date" name="res_date"
                                    value="{{ old('res_date') }}"
                                    class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                            </div>
                            @error('res_date')
                                <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="sm:col-span-6">
                            <label for="res_date" class="block text-sm font-medium text-gray-700"> Checkout Date
                            </label>
                            <div class="mt-1">
                                <input type="datetime-local" id="res_date" name="checkout_date"
                                    value="{{ old('checkout_date') }}"
                                    class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                            </div>
                            @error('checkout_date')
                                <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="sm:col-span-6">
                            <label for="guest_number" class="block text-sm font-medium text-gray-700"> Guest Number
                            </label>
                            <div class="mt-1">
                                <input type="number" id="guest_number" name="guest_number"
                                    value="{{ old('guest_number') }}"
                                    class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                            </div>
                            @error('guest_number')
                                <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="sm:col-span-6 pt-5">
                            <label for="status" class="block text-sm font-medium text-gray-700">Location</label>
                            <div class="mt-1">
                                <select id="location_id" name="location_id" class="form-multiselect block w-full mt-1">
                                    @php
                                        $locations = \App\Models\Location::with('tables')->get();
                                    @endphp
                                    @foreach ($locations as $location)
                                        @php
                                            $totalCapacity = $location->tables->sum('guest_number');
                                        @endphp
                                        <option value="{{ $location->id }}">
                                            {{ $location->name }} (Total Capacity: {{ $totalCapacity }} Guests)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('table_id')
                                <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="sm:col-span-6 pt-5">
                            <label for="status" class="block text-sm font-medium text-gray-700">Set As
                                Recurring</label>
                            <div class="mt-1">
                                <input type="checkbox" id="recurring" name="recurring" value="{{ old('recurring') }}"
                                    class="form-checkbox h-5 w-5 text-indigo-600 transition duration-150 ease-in-out" />
                            </div>
                        </div>
                        <div class="mt-6 p-4">
                            <button type="submit"
                                class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white px-4">Store</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>
<script>
    flatpickr("#res_date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true,
        minuteIncrement: 30,
        altInput: true,
        altFormat: "Y-m-d H:i",

        minDate: "today",
        maxDate: new Date().fp_incr(60) // 60 days from now


    });
</script>
