<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Contracts\View\View;

class HomepageController extends Controller
{

    public function homepage(): View
    {
        $questions              = Question::latest()->paginate(10);
        $mostViewedQuestions  = Question::orderBy('views', 'DESC')->take(5)->get();
        return view('homepage', [
            'questions' => $questions,
            'mostViewedQuestions' => $mostViewedQuestions
        ]);
    }

    public function tags(): View
    {
        $tags = Tag::paginate(12);
        return view('front.tags.index', compact('tags'));
    }

    public function search(Request $request): View
    {
        $request->validate([
            'search' => 'required|string|max:50'
        ]);
        $query      = $request->search;
        $results    = Question::where("title", "LIKE", "%$query%")->paginate(10);
        return view('front.search', compact('results', 'query'));
    }
}
