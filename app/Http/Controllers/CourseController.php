<?php

namespace App\Http\Controllers;


use App\Course;
use App\Posting;
use App\StudentCourse;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
use Validator;

class CourseController extends Controller
{

    function getCoursesView(){
        $myCourses = Course::where('teacher_id','=',Auth::user()->id)->get();
        $joinedCourses = StudentCourse::where('student_id','=',Auth::user()->id)->get();
        return view('course/index')->with([
            'myCourses' => $myCourses,
            'joinedCourses' => $joinedCourses
        ]);
    }

    function createCourse(Request $request){
        $validator = Validator::make(array(
            'course_name' => $request->course_name,
            'description' => $request->description
        ),['course_name' => 'required|min:4']);
        if($validator->fails()){
            Session::flash('alert',$validator->errors()->first());
            Session::flash('alert-type','failed');
            return redirect('courses');
        }

        Course::create([
            'course_code' => substr(md5(Carbon::now()->toAtomString()),0,5),
            'name' => $request->course_name,
            'description' => $request->description,
            'teacher_id' => Auth::user()->id
        ]);
        return redirect('courses');
    }

    function joinCourse(Request $request){
        $course = Course::where('course_code','=',$request->course_code)->first();
        if($course == null){
            Session::flash('alert','course tidak ditemukan');
            Session::flash('alert-type','failed');
            return redirect('courses');
        }
        else if($course->teacher_id == Auth::user()->id){
            return redirect('courses');
        }
        $studentCourse = StudentCourse::where('course_id','=',$course->id)
            ->where('student_id','=',Auth::user()->id)->first();

        if($studentCourse){
            return redirect('courses');
        }

        StudentCourse::create([
            'course_id' => $course->id,
            'student_id' => Auth::user()->id
        ]);

        Session::flash('alert','anda telah bergabung ke '.$course->name.'course');
        Session::flash('alert-type','success');
        return redirect('courses');
    }

    function getCourseDashboardView(Request $request){
        $course = Course::find($request->course_id);
        $postings = Posting::where('course_id','=',$course->id)->get();
        return view('course.dashboard')->with([
            'course' => $course,
            'postings' => $postings
        ]);
    }

}