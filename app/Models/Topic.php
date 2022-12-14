<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    //

    protected $table = 'topics';

    public function questions() {
        return $this->hasMany('App\Models\Question', 'topic_id', 'id');
    }

}
