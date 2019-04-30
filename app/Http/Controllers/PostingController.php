<?php

namespace App\Http\Controllers;
use App\Posting;
use Illuminate\Http\Request;

class PostingController extends Controller
{
    function createPosting(Request $request){
        Posting::create([
            'course_id' => $request->course_id,
            'content' => $request->get('content'),
            'type' => 'announcement'
        ]);

        return redirect('courses/'.$request->course_id);
    }
}