<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    //

    protected $table = 'questions_options';

    public function question()
    {
        return $this->hasOne('App\Models\Question', 'id', 'question_id');
    }
}
