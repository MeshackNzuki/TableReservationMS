<x-admin-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center items-center m-2 p-2 gap-4">
                <div id="print-area" class="flex flex-col justify-center items-center">
                    <div id="print-area-text" class="flex justify-center items-center flex-col mb-10"></div>
                    <div class="flex flex-col justify-center items-center my-10">
                        {!! $qrCode = SimpleSoftwareIO\QrCode\Facades\QrCode::size(150)->color(0, 0, 0)->generate('https://www.rollingstones.co.ke/menus') !!}</div>
                </div>
                <span class="flex flex-col justify-center items-center m-2 p-2 ">
                    {{-- onclick="printDiv()" --}}
                    <p class="dark:text-white ">Print this QR code and place it on customer tables</p>
                    <p class="bg-emerald-300 p-2 rounded-md m-1 text-xs"><i
                            class="fa fa-exclamation-circle me-2"></i>Please
                        disable
                        header and
                        footer
                        in browser printing
                        settings (Go to "more settings" )</p>
                    <button onclick="printDiv()"
                        class="px-4 py-2 bg-indigo-500
                        hover:bg-indigo-700 rounded-lg text-white">Print
                        Qr Menu
                        Code
                    </button>
                </span>
            </div>
            <div class="flex justify-end m-2 p-2 gap-4">
                <a href="{{ route('admin.menus.create') }}"
                    class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">New Menu Item</a>
                <a href="{{ route('admin.categories.create') }}"
                    class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">New Category</a>
            </div>
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block py-2 min-w-full sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow-md sm:rounded-lg ">
                            <table class="min-w-full overflow-scroll" id="menu">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Name
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Category
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Description
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            Price
                                        </th>
                                        <th scope="col" class="relative py-3 px-6">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($menus as $menu)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $menu->name }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $menu->category->name }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white overflow-x-scroll max-w-48">
                                                {{ $menu->description }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $menu->price }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('admin.menus.edit', $menu->id) }}"
                                                        class="px-4 py-2 bg-emerald-500 hover:bg-emerald-700 rounded-lg  text-white">Edit</a>
                                                    <form
                                                        class="px-4 py-2 bg-red-500 hover:bg-red-700 rounded-lg text-white"
                                                        method="POST"
                                                        action="{{ route('admin.menus.destroy', $menu->id) }}"
                                                        onsubmit="return confirm('Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit">Delete</button>
                                                    </form>
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
    <script>
        $(document).ready(function() {
            new DataTable('#menu');
        });

        function printDiv() {

            document.getElementById('print-area-text').innerHTML = `
              <h1 class="text-2xl font-bold text-gray-800 underline">MENU</h1>
                <h1 class="text-2xl font-bold text-gray-800">WELCOME TO ROLLINGSTONES EATERY!</h1>
                <p class="text-lg text-gray-600">Scan the QR code below to browse our Menu.</p>
            `;

            var printContents = document.getElementById('print-area').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
            document.getElementById('print-area-text').innerHTML = "";
        }
    </script>
</x-admin-layout>
