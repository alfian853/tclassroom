<?php
namespace App;


use Illuminate\Database\Eloquent\Model;

class CourseModule extends Model
{
    protected $primaryKey='id';
    protected $table='course_modules';
    protected $fillable = ['course_id','file_name'];
    public $timestamps = true;
}