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
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }


    public function update(UpdateUserRequest $request, $id)
    {
        $user           = User::findOrFail($id);
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->work     = $request->work;
        $user->facebook = $request->facebook;
        $user->linkedin = $request->linkedin;

        $user->save();
        return back()->with('message', 'User information has been updated successfully');
    }


    public function addToAdmins($id)
    {
        $user = User::findOrFail($id);
        $user->is_admin = true;
        $user->save();
        return back()->with('message', 'User has been added to admins successfully');
    }


    public function removeFromAdmins($id)
    {
        $user = User::findOrFail($id);
        $user->is_admin = false;
        $user->save();
        return back()->with('message', 'User has been removed from admins successfully');
    }
    
}
