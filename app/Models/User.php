<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class User extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'work',
        'facebook',
        'linkedin',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function isAdministrator()
    {
        return $this->is_admin;
    }

    public function exceedDailyQuestionLimit()
    {
        $questions  = Question::whereDate('created_at', Carbon::today())
            ->where('user_id', Auth::id())->get();
        if ($questions->count() >= 3) {
            return true;
        }
    }
}
