<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6">User Management</h1>
        <a href="{{ route('admin.users.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg mb-4 inline-block">Add
            User</a>
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif
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
                @foreach ($users as $user)
                    <tr class="bg-white">
                        <td class="border p-2">{{ $user->id }}</td>
                        <td class="border p-2">{{ $user->name }}</td>
                        <td class="border p-2">{{ $user->email }}</td>
                        <td class="border p-2">
                            <a href="{{ route('admin.users.show', $user->id) }}"
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg">View</a>
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                class="bg-yellow-500 text-white px-4 py-2 rounded-lg">Edit</a>
                            @if(!$user->is_super_admin)
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white px-4 py-2 rounded-lg">Delete</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>
