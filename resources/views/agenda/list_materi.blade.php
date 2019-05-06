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
        function viewDocument(link){
            $('#view-document-modal').modal('show');
        }

        $(document).ready(function () {
            let fileUploadModal = new FileUploadModal(
                '{{route('post.agenda.materi',['agenda_id' => request()->agenda_id,'no_pertemuan' => request()->no_pertemuan])}}',
                $('input[name=_token]').val(), 'Upload File'
            )

            fileUploadModal.setOnSuccessHandler(function () {
                location.reload(true);
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

    <div id="view-document-modal" class="modal fade">
        <div class="modal-body">
            <iframe id="document-iframe" src = "/ViewerJS/index.html#../resources/materi/2019-05-04-08-05-11-DraftProposalTA_Alfian.pdf"
                    width='400' height='300' allowfullscreen webkitallowfullscreen></iframe>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3>Apakah Anda Yakin Ingin Menghapus Materi? :</h3>
                    <h3 id="nama-materi"></h3>
                </div>
                <form id="form-delete-materi" class="modal-footer" method="post" action="">
                    @csrf
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

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
                <td>
                    <a class="btn btn-success" href="/resources/materi/{{$materi->filename}}">download</a>
                    <a class="btn btn-primary text-white" onclick="viewDocument('/resources/materi/{{$materi->filename}}')">view</a>
                    <a class="btn btn-danger text-white" data-toggle="modal" data-target="#exampleModalCenter"
                    onclick="(()=>{
                        $('#nama-materi').html('{{$materi->filename}}');
                        $('#form-delete-materi').attr('action','\
                    {{ route('delete.agenda.materi',
                    [
                        'materi_id' => $materi->id,
                        'agenda_id' => request()->agenda_id,
                        'no_pertemuan'=> request()->no_pertemuan
                    ] ) }}')

                    })()"
                    >delete</a>
                </td>
            </tr>
        @endforeach
    </table>

    {{--<iframe src = "/ViewerJS/index.html#../resources/materi/2019-05-04-08-05-11-DraftProposalTA_Alfian.pdf" width='400' height='300' allowfullscreen webkitallowfullscreen></iframe>--}}

@endsection
