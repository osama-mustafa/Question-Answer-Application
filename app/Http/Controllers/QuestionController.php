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
        $questions = Question::latest()->paginate(10);
        return view('admin.questions.index', compact('questions'));
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
        $question->countViews();
        return view('front.single-question', compact('question'));
    }


    public function edit($id)
    {
        $question = Question::findOrFail($id);
        $question_tags = $question->tags()->get()->pluck('title')->toArray();
        $previous_tags_as_text = implode(",", $question_tags);
        return view('front.questions.edit', compact('question', 'previous_tags_as_text'));
    }


    public function update(StoreQuestionRequest $request, $question_id)
    {
        $question = Question::findOrFail($question_id);
        $question->title = $request->title;
        $question->body  = $request->body;
        if ($request->filled('tags')) {
            $this->handleTags($request, $question);
        }
        $question->save();
        return back()->with('message', 'Question has been updated successfully');
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
        return back()->with('message', 'Question has been deleted successfully');
    }

    public function showTrashedQuestions()
    {
        $questions = Question::onlyTrashed()->paginate(10);
        return view('admin.questions.trashed', compact('questions'));
    }


    public function restoreTrashed($id)
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
        $question->status = false;
        $question->save();
        return back()->with('message', 'Question has been closed and no longer accepting answers');
    }


    public function changeStatusToOpen($id)
    {
        $question = Question::findOrFail($id);
        $question->status = true;
        $question->save();
        return back()->with('message', 'Question has been opened for accepting answers');
    }


    public function showQuestionsAttachedWithTag($tag_name)
    {
        $tag = Tag::where('title', $tag_name)->first();
        $tagged_questions = $tag->questions()->paginate(10);
        return view('front.questions.questions-tagged', compact('tag', 'tagged_questions'));
    }


    public function reportAsInappropriate($id)
    {
        $question = Question::findOrFail($id);
        $users = User::where('is_admin', '1')->get();
        if ($users->count() >= 1) {
            foreach ($users as $user) {
                $user->notify(new ReportQuestionNotification($question));
            }    
        }
        return back()->with('report_success', 'Thanks for your report, we will take the approperiate action');
    }
}
