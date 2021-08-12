<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $questions  = DB::table('questions')->get();
        $answers    = DB::table('answers')->get();
        $users      = DB::table('users')->get();
        $tags       = DB::table('tags')->get();
        return view('admin.index', compact('questions', 'answers', 'users', 'tags'));
    }

}
