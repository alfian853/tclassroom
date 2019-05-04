<?php

namespace App\Http\Controllers;

use App\Materi;
use App\Helpers\ResourceUrlHelper;
use App\Posting;
use Auth;
use Illuminate\Http\Request;
use Storage;
use Session;

class ModuleController extends Controller
{
    function uploadModule(Request $request){
        if($request->file('file') != null){
            $originalName = $request->file('file')->getClientOriginalName();
            $fileName = date('Y-m-d-H-m-s').'-'.$originalName;
            Materi::create([
                'file_name' => $fileName,
                'course_id' => $request->course_id
            ]);
            Posting::create([
                'course_id' => $request->course_id,
                'content' => Auth::user()->name.' telah menambahkan materi kursus : <a href="/course_modules/'.$fileName.'">'
                    .$originalName.'</a>',
                'type' => 'file'
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