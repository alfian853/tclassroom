@extends('layouts.master')
@section('title')
    Dashboard
@endsection

@section('add-script')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.3.3/viewer.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.3.3/viewer.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
    <script src="{{asset('js/file_upload.js')}}"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-te/1.4.0/jquery-te.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-te/1.4.0/jquery-te.js"></script>

    <script>
        $(document).ready(function () {
            let fileUploadModal = new FileUploadModal(
                '{{route('post.module.upload',['course_id' => $course->id])}}',
                $('input[name=_token]').val(),'Upload File'
            )

            fileUploadModal.setOnSuccessHandler(function () {
                location.reload(true);
            })
            fileUploadModal.init();

            $('#upload-file-trigger').click(function () {
                console.log($('#post-editor').val());
                $('#'+fileUploadModal.getModalId()).modal('show')
            })

            $('#post-editor').jqte();
            
            $('#submit-post').click(function () {

            })
        })
    </script>

@endsection

@section('content')
    @csrf

    <a class="btn btn-md btn-success" id="upload-file-trigger">
        <font color="white"><i class="fa fa-plus-circle"></i>
        <span class="padding-left:10px">Tambah Materi</span></font>
    </a>
    <div>
        <form method="post" action="{{route('post.posting',['course_id' => $course->id])}}">
            @csrf

            <textarea id="post-editor" style="width: 400px" name="content"></textarea>
            <button id="submit-post" type="submit">Post</button>
        </form>
    </div>
    @foreach($postings as $posting)
        <div style="color: #0b0b0b;">
            {!! html_entity_decode($posting->content) !!}
        </div>
    @endforeach
    <iframe src="https://docs.google.com/gview?url=http://localhost:8000/course_modules/2019-04-30-07-04-32-DraftProposalTA_Alfian.pdf&embedded=true"></iframe>
    {{--<iframe src = "/ViewerJS/index.html#../course_modules/Tugas_1_IMK.docx" width='400' height='300' allowfullscreen webkitallowfullscreen></iframe>--}}
    {{--<iframe src = "/course_modules/Interoperability2.ppt" width='400' height='300' allowfullscreen webkitallowfullscreen></iframe>--}}


@endsection
