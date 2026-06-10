<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRoleRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display a specific user.
     */
    public function show(User $user)
    {
        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form to edit a user's role.
     */
    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get();
        $user->load('roles');

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the user's role.
     */
    public function update(UpdateUserRoleRequest $request, User $user)
    {
        // syncRoles replaces all current roles with the newly selected one
        $user->syncRoles([$request->validated('role')]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User role updated successfully.');
    }

    /**
     * Delete a user account.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
