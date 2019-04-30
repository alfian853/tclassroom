<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Posting extends Model
{
    protected $primaryKey = 'id';
    /*
     * types = [assignment,announcement,file]
     * */
    protected $fillable = ['course_id','content','type'];

    public $timestamps = true;
}