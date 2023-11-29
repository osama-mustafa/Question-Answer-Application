<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreQuestionRequest;
use Illuminate\Support\Str;
use App\Models\Tag;
use App\Models\User;
use App\Notifications\ReportQuestionNotification;


class QuestionController extends Controller
{

    public function index()
    {
        $questions = Question::latest()->with('user')->paginate(10);
        return view('admin.questions.index', ['questions' => $questions]);
    }

    public function create()
    {
        return view('front.ask');
    }

    public function store(StoreQuestionRequest $request)
    {
        $question = Question::create([
            'title'   => $request->title,
            'body'    => $request->body,
            'user_id' => Auth::id(),
            'slug'    => Str::slug($request->title)
        ]);

        if ($request->filled('tags')) {
            $this->handleTags($request, $question);
        }

        return back()->with('message', 'Your question has been submitted successfully');
    }

    public function handleTags(StoreQuestionRequest $request, $question)
    {
        $tagNames = explode(",", $request->input("tags"));
        if (count($tagNames) <= 5) {
            $tagIds = [];
            foreach ($tagNames as $tagName) {
                $tag = Tag::firstOrCreate([
                    'title' => $tagName
                ]);
                array_push($tagIds, $tag->id);
            }
            $question->tags()->sync($tagIds);
        } else {
            return back()->with('warning_message', 'You should not add more than 5 tags!');
        }
    }

    public function show($id, $slug)
    {
        $question = Question::findOrFail($id);
        incrementViewCount('questions', 'views', $id);
        return view('front.single-question', compact('question'));
    }

    public function edit($id)
    {
        $question = Question::findOrFail($id);
        $questionTags = $question->tags()->get()->pluck('title')->toArray();
        $tags = implode(",", $questionTags);
        return view('front.questions.edit', compact('question', 'tags'));
    }

    public function update(StoreQuestionRequest $request, $question_id)
    {
        $question = Question::findOrFail($question_id);
        $question->update($request->validated());
        if ($request->filled('tags')) {
            $this->handleTags($request, $question);
        }
        return back()->with('message', 'Question has been updated successfully');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return back()->with('message', 'Question has been deleted successfully');
    }

    public function showTrashedQuestions()
    {
        $questions = Question::onlyTrashed()->paginate(10);
        return view('admin.questions.trashed', compact('questions'));
    }

    public function restore($id)
    {
        $question = Question::withTrashed()->findOrFail($id);
        $question->restore();
        return back()->with('message', 'Question has been restored successfully');
    }

    public function deletePermanently($id)
    {
        $question = Question::withTrashed()->findOrFail($id);
        $question->forceDelete();
        return back()->with('message', 'Question has been deleted forever successfully');
    }

    public function changeStatusToClosed($id)
    {
        $question = Question::findOrFail($id);
        $question->status = Question::CLOSED;
        $question->save();
        return back()->with('message', 'Question has been closed and no longer accepting answers');
    }

    public function changeStatusToOpen($id)
    {
        $question = Question::findOrFail($id);
        $question->status = Question::OPEN;
        $question->save();
        return back()->with('message', 'Question has been opened for accepting answers');
    }

    public function showQuestionsAttachedWithTag($tagName)
    {
        $tag = Tag::where('title', $tagName)->first();
        $taggedQuestions = $tag->questions()->paginate(10);
        return view('front.questions.questions-tagged', compact('tag', 'taggedQuestions'));
    }

    public function reportAsInappropriate($id)
    {
        $question = Question::findOrFail($id);
        $admins = User::where('is_admin', '1')->get();
        if ($admins->count() >= 1) {
            foreach ($admins as $admin) {
                $admin->notify(new ReportQuestionNotification($question));
            }
        }
        return back()->with('report_success', 'Thanks for your report, we will take the appropriate action');
    }
}
