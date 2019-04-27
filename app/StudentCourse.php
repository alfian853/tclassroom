<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 4/27/19
 * Time: 4:24 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class StudentCourse extends Model
{
    protected $table = 'student_courses';

    protected $fillable = ['course_id','student_id'];

    public $incrementing = false;
    public $timestamps = false;

    function courseData(){
        return $this->hasOne('App\Course','id','course_id');
    }

    function studentData(){
        return $this->hasOne('App\User','id','student_id');
    }

}