@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-lg mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit User Role</h1>
            <a href="{{ route('admin.users.index') }}"
               class="text-sm text-blue-600 hover:underline font-medium">
                ← Back to Users
            </a>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-800">{{ $user->name }}</h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ $user->email }}</p>
            </div>

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="p-5 flex flex-col gap-5">

                    {{-- Current Role --}}
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Current Role</p>
                        <div class="flex gap-2">
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

                    {{-- Select New Role --}}
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                            Assign New Role
                        </label>
                        <select name="role" id="role"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800
                                       focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="px-5 py-4 border-t border-gray-100 flex gap-3">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-5 rounded-lg">
                        Save Changes
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium py-2 px-5 rounded-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
