<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'subject',
        'topic',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
