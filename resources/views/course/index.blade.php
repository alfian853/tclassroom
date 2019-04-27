@extends('layouts/master')
@section('title')
    Courses
@endsection

@section('add-script')
@parent

<script>
$(document).ready(function () {

    $('#create-course-trigger').click(function () {
        $('#new-course-modal').modal('show')
    })

    $('#join-course-trigger').click(function () {
        $('#join-course-modal').modal('show')
    })

})


</script>

@endsection

@section('content')
    <div class="top-menu">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div id="fh5co-logo"><a href=""><i class="icon-study"></i> TClassroom</a></div>
                </div>
                @guest
                    <div class="col-sm-10 text-right">
                        <ul>
                            <li class="btn btn-md btn-info"><a href="{{url('/login')}}">Login</li>
                            <li class="btn btn-md btn-success"><a href="{{url('/course')}}">Create a Course</a></li>
                        </ul>
                    </div>
                @else
                    <div class="col-sm-10 text-right">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </div>
                @endguest
            </div>
        </div>
    </div>
    <div class="modal fade" id="new-course-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <form action="{{route('post.course.create')}}" method="post" class="modal-content">
                {{csrf_field()}}
                <div class="modal-header">
                    <h4 class="modal-title">Create Course</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Course Name:</label>
                    <input type="text" name="course_name" placeholder="Course Name"/>
                </div>
                <div class="modal-body">
                    <label>Description:</label>
                    <textarea name="description" placeholder="Description"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Create</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="join-course-modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <form action="{{route('post.course.join')}}" method="post" class="modal-content">
                {{csrf_field()}}
                <div class="modal-header">
                    <h4 class="modal-title">Join Course</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label>Course Code: (ask your teacher for the code)</label>
                    <input type="text" name="course_code" placeholder="Course Code"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Join</button>
                </div>
            </form>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <h4><i class="fa fa-user"></i>Courses</h4><hr>
            <div class=row>
                <div class="col-md-6">
                <a class="btn btn-primary" id="create-course-trigger">
                    <i class="fa fa-plus-circle"></i>Create Course
                </a>
                <a class="btn btn-primary" id="join-course-trigger">
                    <i class="fa fa-plus-circle"></i>Join Course
                </a>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4"></div>
            </div>
            <br>
            @if(count($myCourses))
                <h1>Created courses</h1>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-condensed tfix">
                        <thead align="center">
                            <td><b>Course</b></td>
                            <td><b>Course Code</b></td>
                            <td><b>Action</b></td>
                            @foreach($myCourses as $course)
                            <tr>
                                <td align="center" width="30px">
                                    <p>{{$course->name}}</p>
                                </td>
                                <td align="center" width="30px">
                                    {{$course->course_code}}
                                </td>
                                <td align="center" width="30px">
                                    <a href="/courses/{{$course->id}}" class="btn btn-warning btn-sm" role="button">
                                        <i class="fa fa-pencil-square"></i>detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
            @if(count($joinedCourses))
                <h1>Joined courses</h1>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-condensed tfix">
                        <thead align="center">
                            <td><b>Course</b></td>
                            <td><b>Course Code</b></td>
                            <td><b>Action</b></td>
                            @foreach($joinedCourses as $course)
                            <tr>
                                <td align="center" width="30px">
                                    <p>{{$course->courseData->name}}</p>
                                </td>
                                <td align="center" width="30px">
                                    {{$course->courseData->course_code}}
                                </td>
                                <td align="center" width="30px">
                                    <a href="/courses/{{$course->courseData->id}}" class="btn btn-warning btn-sm" role="button">
                                        <i class="fa fa-pencil-square"></i>detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
        </div>
@endsection
