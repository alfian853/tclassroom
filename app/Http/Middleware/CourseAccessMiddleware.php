<?php

namespace App\Http\Middleware;

use App\Course;
use App\StudentCourse;
use Auth;
use Closure;
use Session;

class CourseAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $res = Course::find($request->course_id);
        if($res == null){
            Session::flash('alert','course tidak ditemukan');
            Session::flash('alert-type','warning');
            return redirect('/courses');
        }

        $userId = Auth::user()->id;
        if($res->teacher_id == $userId){
            return $next($request);
        }

        $res = StudentCourse::where('student_id','=',$userId)->first();
        if($res == null){
            Session::flash('alert','silahkan join course terlebih dahulu');
            Session::flash('alert-type','failed');
            return redirect('/courses');
        }

        return $next($request);
    }
}
