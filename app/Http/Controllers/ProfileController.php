<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePasswordRequest;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Traits\ImageTrait;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use ImageTrait;

    public function publicProfile($user_id, $user_name)
    {
        $user = User::findOrFail($user_id);
        $user_questions = $user->questions()->paginate(10);
        return view('front.profile.public-profile', compact(['user', 'user_questions']));
    }


    public function edit()
    {
        $user    = User::findOrFail(Auth::id());
        return view('front.profile.edit', compact('user'));
    }


    public function update(StoreProfileRequest $request)
    {
        $user           = Auth::user();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->work     = $request->work;
        $user->facebook = $request->facebook;
        $user->linkedin = $request->linkedin;
        $formInput      = $request->all();
        $image = $formInput['image'] = $this->upload($request);
        $user->image    = $image;
        $user->save();
        
        return back()->with([
            'message' => 'Profile has been updated successfully'
        ]);
    }


    public function editPassword()
    {
        $user = User::findOrFail(Auth::id());
        return view('front.profile.edit-password', compact('user'));
    }


    public function updatePassword(StorePasswordRequest $request)
    {
        $user = User::findOrFail(Auth::id());
        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('message', 'Password has been updated successfully');
    }

    
    public function showMyQuestions()
    {
        $user = Auth::user();
        $user_questions = Question::where('user_id', $user->id)->paginate(10);
        return view('front.profile.my-questions', compact('user', 'user_questions'));
    }

}
