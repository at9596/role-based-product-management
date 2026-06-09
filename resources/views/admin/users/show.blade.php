@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-2xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">User Details</h1>
            <a href="{{ route('admin.users.index') }}"
               class="text-sm text-blue-600 hover:underline font-medium">
                ← Back to Users
            </a>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-800">{{ $user->name }}</h2>
            </div>

            <div class="p-5 flex flex-col gap-4">

                <div class="flex flex-col gap-1">
                    <span class="text-xs font-semibold text-gray-500 uppercase">Name</span>
                    <span class="text-gray-800 font-medium">{{ $user->name }}</span>
                </div>

                <div class="flex flex-col gap-1">
                    <span class="text-xs font-semibold text-gray-500 uppercase">Email</span>
                    <span class="text-gray-800">{{ $user->email }}</span>
                </div>

                <div class="flex flex-col gap-1">
                    <span class="text-xs font-semibold text-gray-500 uppercase">Role</span>
                    <div class="flex gap-2 flex-wrap">
                        @forelse($user->roles as $role)
                            <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full
                                @if($role->name === 'Admin') bg-purple-100 text-purple-700
                                @elseif($role->name === 'Manager') bg-blue-100 text-blue-700
                                @else bg-gray-100 text-gray-600 @endif">
                                {{ $role->name }}
                            </span>
                        @empty
                            <span class="text-sm text-gray-400">No role assigned</span>
                        @endforelse
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <span class="text-xs font-semibold text-gray-500 uppercase">Joined</span>
                    <span class="text-gray-800">{{ $user->created_at->format('d M Y, h:i A') }}</span>
                </div>

            </div>

            <div class="px-5 py-4 border-t border-gray-100 flex gap-3">
                <a href="{{ route('admin.users.edit', $user) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium py-2 px-4 rounded-lg">
                    Edit Role
                </a>
                @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                          onsubmit="return confirm('Delete this user? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white text-sm font-medium py-2 px-4 rounded-lg">
                            Delete User
                        </button>
                    </form>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
