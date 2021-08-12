<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Answer;
use App\Models\Tag;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;
use App\Models\QuestionVote;


class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'status',
        'votes',
        'views',
        'slug'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function questionVotes()
    {
        return $this->hasMany(QuestionVote::class);
    }

    public function countViews()
    {
        $question_key = 'question' . $this->id;
        if (!Session::has($question_key)) {
            $this->increment('views');
            Session::put($question_key, 1);    
        }
        return $this->save();
    }
}
