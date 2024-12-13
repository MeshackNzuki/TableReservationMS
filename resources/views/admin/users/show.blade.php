<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    @section('content')
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h1 class="text-2xl font-bold mb-6">User Details</h1>
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" id="name" value="{{ $user->name }}"
                    class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" value="{{ $user->email }}"
                    class="w-full px-4 py-2 border rounded-lg bg-gray-100" readonly>
            </div>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Back</a>
        </div>
    </x-admin-layout>
