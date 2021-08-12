<?php

namespace App\Http\Livewire;
use App\Models\Question;
use App\Models\QuestionVote;
use Illuminate\Support\Facades\Auth;


use Livewire\Component;

class QuestionVotes extends Component
{
    public $question;

    public function mount($question)
    {
        $this->question = $question;
    }

    public function render()
    {
        return view('livewire.question-votes');
    }

    public function vote($vote)
    {
        if (!$this->question->questionVotes->where('user_id', Auth::id())->count()
        && in_array($vote, [-1, 1]) && $this->question->user_id != Auth::id() && Auth::check()) {

            QuestionVote::create([
                'question_id' => $this->question->id,
                'user_id'     => Auth::id(),
                'vote'        => $vote
            ]);

            $this->question->increment('votes', $vote);           
        }
    }
}
