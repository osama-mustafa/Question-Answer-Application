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
    const OPEN = 1;
    const CLOSED = 0;

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
        $questionKey = 'question ' . $this->id;
        $viewed = Session::get($questionKey, false);
        if (!$viewed) {
            $this->increment('views');
            Session::put($questionKey, true);
        }
        return $this->save();
    }
}
