<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Http\Requests\StoreAnswerRequest;
use App\Notifications\AnswerNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class AnswerController extends Controller
{
    public function index(): View
    {
        $answers = Answer::with('user')->paginate(10);
        return view('admin.answers.index', ['answers' => $answers]);
    }

    public function store(StoreAnswerRequest $request, $question_id): RedirectResponse
    {
        $question = Question::findOrFail($question_id);
        Answer::create([
            'body'        => $request->body,
            'user_id'     => Auth::id(),
            'question_id' => $question->id,
        ]);

        // $question->user->notify(new AnswerNotification($question));
        return back()->with([
            'success' => 'Your answer has been submitted successfully'
        ]);
    }

    public function edit($answer_id): View
    {
        $answer = Answer::findOrFail($answer_id);
        return view('front.answers.edit', ['answer' => $answer]);
    }

    public function update(StoreAnswerRequest $request, $answer_id): RedirectResponse
    {
        $answer = Answer::findOrFail($answer_id);
        $answer->update([
            'body' => $request->body,
        ]);
        return redirect()->route(
            'questions.show',
            ['id' => $answer->question->id, 'slug' => $answer->question->slug]
        )
            ->with('message', 'The answer has been updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        $answer = Answer::findOrFail($id);
        $answer->delete();
        return back()->with('message', 'Answer has been deleted successfully');
    }

    public function showTrashedAnswers(): View
    {
        $answers = Answer::onlyTrashed()->paginate(10);
        return view('admin.answers.trashed', ['answers' => $answers]);
    }

    public function restore($id): RedirectResponse
    {
        $answer = Answer::withTrashed()->findOrFail($id);
        $answer->restore();
        return back()->with('message', 'Answer has been restored successfully');
    }

    public function deletePermanently($id): RedirectResponse
    {
        $answer = Answer::withTrashed()->findOrFail($id);
        $answer->forceDelete();
        return back()->with('message', 'Answer has been deleted forever successfully');
    }
}