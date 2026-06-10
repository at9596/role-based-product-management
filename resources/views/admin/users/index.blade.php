@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-6xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Users</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-blue-600 hover:underline font-medium">
                ← Admin Dashboard
            </a>
        </div>

        {{-- Flash Messages --}}
        <x-alert type="success" />
        <x-alert type="error" />

        {{-- Users Table --}}
        <div class="bg-white rounded-lg shadow">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-800">All Users ({{ $users->total() }})</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">#</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">Name</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">Email</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">Role</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">Joined</th>
                            <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3 text-gray-500">{{ $user->id }}</td>
                                <td class="px-5 py-3 font-medium text-gray-800">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span class="ml-1 text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full font-semibold">You</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-gray-600">{{ $user->email }}</td>
                                <td class="px-5 py-3">
                                    @if($user->roles->isNotEmpty())
                                        @foreach($user->roles as $role)
                                            <x-role-badge :role="$role" />
                                        @endforeach
                                    @else
                                        <span class="text-xs text-gray-400">No role</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('admin.users.show', $user) }}"
                                           class="text-blue-600 hover:underline font-medium">View</a>

                                        <a href="{{ route('admin.users.edit', $user) }}"
                                           class="text-yellow-600 hover:underline font-medium">Edit Role</a>

                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                  onsubmit="return confirm('Delete this user? This cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 hover:underline font-medium">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-gray-400 text-sm">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($users->hasPages())
                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
