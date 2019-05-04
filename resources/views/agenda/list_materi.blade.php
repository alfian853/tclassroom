@extends('layouts.master')
@section('title')
    List Materi
@endsection

@section('add-script')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
    <script src="{{asset('js/file_upload.js')}}"></script>
    <script>
        $(document).ready(function () {
            let fileUploadModal = new FileUploadModal(
                '{{route('post.agenda.materi',['agenda_id' => request()->agenda_id,'no_pertemuan' => request()->no_pertemuan])}}',
                $('input[name=_token]').val(), 'Upload File'
            )

            fileUploadModal.setOnSuccessHandler(function () {
                // location.reload(true);
            })
            fileUploadModal.init();

            $('#upload-file-trigger').click(function () {
                console.log($('#post-editor').val());
                $('#' + fileUploadModal.getModalId()).modal('show')
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
    <table class="table table-striped">
        <tr>
            <th>Nama File</th>
            <th>Tanggal Upload</th>
            <th>Action</th>
        </tr>
        @foreach($list_materi as $materi)
            <tr>
                <td>{{$materi->filename}}</td>
                <td>{{$materi->created_at}}</td>
                <td><a href="/resources/materi/{{$materi->filename}}">download</a></td>
            </tr>
        @endforeach

    </table>
@endsection
