<?php

namespace App\Http\Middleware;

use App\Course;
use Auth;
use Closure;
use Session;

class CourseAdminMiddleware
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

        Session::flash('alert','unauthorized');
        Session::flash('alert-type','failed');
        return redirect('courses/'.$request->course_id);
    }
}
