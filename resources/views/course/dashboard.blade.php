@extends('layouts.master')
@section('title')
    Dashboard
@endsection

@section('add-script')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
    <script src="{{asset('js/file_upload.js')}}"></script>

    <script>
        $(document).ready(function () {
            let fileUploadModal = new FileUploadModal(
                '{{route('post.module.upload',['course_id' => '3'])}}',
                $('input[name=_token]').val(),'Upload File'
            )

            fileUploadModal.setOnSuccessHandler(function () {
                location.reload(true);
            })

            fileUploadModal.init();
            $('#upload-file-trigger').click(function () {
                $('#'+fileUploadModal.getModalId()).modal('show')
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


@endsection
