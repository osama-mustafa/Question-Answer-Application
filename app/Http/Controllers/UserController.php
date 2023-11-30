<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Traits\ImageTrait;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    use ImageTrait;

    public function index(): View
    {
        $users = User::latest()->with('questions')->paginate(10);
        return view('admin.users.index', ['users' => $users]);
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());
        return back()->with('message', 'User information has been updated successfully');
    }

    public function addToAdmins($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->update(['is_admin' => true]);
        return back()->with('message', 'User has been added to admins successfully');
    }

    public function removeFromAdmins($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->update(['is_admin' => false]);
        return back()->with('message', 'User has been removed from admins successfully');
    }
}
