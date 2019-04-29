<?php

namespace App\Http\Controllers;

use App\CourseModule;
use Illuminate\Http\Request;
use Storage;
use Session;

class ModuleController extends Controller
{

    function uploadModule(Request $request){
        if($request->file('file') != null){
            $fileName = date('Y-m-d-H-m-s').'-'.$request->file('file')->getClientOriginalName();
            CourseModule::create([
                'file_name' => $fileName,
                'course_id' => $request->course_id
            ]);
            Storage::putFileAs('course_modules', $request->file('file'), $fileName);
            Session::flash('alert','Upload Success');
            Session::flash('alert-type','success');
        }
        else{
            Session::flash('alert','Upload Failed');
            Session::flash('alert-type','Failed');
        }
    }

}