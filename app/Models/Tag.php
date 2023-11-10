<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description'
    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}
