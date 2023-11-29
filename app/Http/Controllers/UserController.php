<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Traits\ImageTrait;
use App\Models\User;


class UserController extends Controller
{
    use ImageTrait;

    public function index()
    {
        $users = User::latest()->with('questions')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return back()->with('message', 'User information has been updated successfully');
    }

    public function addToAdmins($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_admin' => true]);
        return back()->with('message', 'User has been added to admins successfully');
    }

    public function removeFromAdmins($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_admin' => false]);
        return back()->with('message', 'User has been removed from admins successfully');
    }
}
