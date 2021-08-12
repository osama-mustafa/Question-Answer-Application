<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Tag;

class HomepageController extends Controller
{

    public function homepage()
    {
        $questions              = Question::latest()->paginate(10);
        $most_viewed_questions  = Question::orderBy('views', 'DESC')->take(5)->get(); 
        return view('homepage', compact('questions', 'most_viewed_questions'));
    }


    public function tags()
    {
        $tags = Tag::paginate(12);
        return view('front.tags.index', compact('tags'));
    }


    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required|string|max:50'
        ]);
        $query      = $request->search;
        $results    = Question::where("title", "LIKE", "%$query%")->paginate(10);
        return view('front.search', compact('results', 'query'));
    }

}