<?php
namespace App;


use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $primaryKey='id';
    protected $table='courses';
    protected $fillable = ['course_code','name','teacher_id','description'];
    protected $attributes = [
        'description' => ''
    ];
    public $timestamps = false;

}