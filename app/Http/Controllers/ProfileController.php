<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Question;
use App\Traits\ImageUploadTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\StorePasswordRequest;

class ProfileController extends Controller
{
    use ImageUploadTrait;

    public function publicProfile($user_id, $user_name): View
    {
        $user = User::findOrFail($user_id);
        $userQuestions = $user->questions()->with('answers')->paginate(10);
        return view('front.profile.public-profile', [
            'user' => $user,
            'userQuestions' => $userQuestions
        ]);
    }


    public function edit(): View
    {
        return view('front.profile.edit', [
            'user' => Auth::user()
        ]);
    }


    public function update(StoreProfileRequest $request): RedirectResponse
    {
        Auth::user()->update($request->validated());
        if ($request->hasFile('image')) {
            $imageName = $this->handleUploadImage($request, 'image', 'public/images');
            Auth::user()->update([
                'image' => $imageName
            ]);
        };
        return back()->with([
            'message' => 'Profile has been updated successfully'
        ]);
    }


    public function editPassword(): View
    {
        $user = User::findOrFail(Auth::id());
        return view('front.profile.edit-password', compact('user'));
    }


    public function updatePassword(StorePasswordRequest $request): RedirectResponse
    {
        $user = User::findOrFail(Auth::id());
        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('message', 'Password has been updated successfully');
    }


    public function showMyQuestions(): View
    {
        $user = Auth::user();
        $user_questions = Question::where('user_id', $user->id)->paginate(10);
        return view('front.profile.my-questions', compact('user', 'user_questions'));
    }
}
