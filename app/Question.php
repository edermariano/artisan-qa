<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $connection;
    protected $fillable = ['question', 'answer'];
}
