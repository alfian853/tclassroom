@extends('layouts.master')
@section('title')
    Pengumpulan Tugas
@endsection

@section('add-script')
@parent

<script>
    function viewDocument(link){
            $('#document-iframe').attr('src','/ViewerJS/index.html#..'+link);
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
<div class="modal fade" id="view-document-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe id="document-iframe" src="" width='470' height='680' allowfullscreen
                    webkitallowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>

    <h1>Pengumpulan Tugas</h1>
    <h3>Kelas {{$agenda->namaAgenda}}</h3>
    <h3>Pertemuan {{request()->no_pertemuan}}</h3>
    <table class="table table-striped">
        <tr>
            <th>No</th>
            <th>NRP Mahasiswa</th>
            <th>Nama Mahasiswa</th>
            <th>Waktu Pengumpulan</th>
            <th>nilai</th>
            <th>Action</th>
        </tr>
        @foreach($listPengumpulanTugas as $i => $pTugas)
            <tr>
                <td>{{$i+1}}</td>
                <td>{{$pTugas->mahasiswa->idUser}}</td>
                <td>{{$pTugas->mahasiswa->name}}</td>
                <td>{{$pTugas->waktu_submit}}</td>
                <td>{{$pTugas->nilai}}</td>
                <td>
                    @if($pTugas->filename == null)
                        <p style="color: red">Belum Mengumpulkan</p>
                    @else
                        <a href="/resources/tugas/{{$pTugas->filename}}" class="btn btn-success" target="_blank">Download</a>
                        <a class="btn btn-primary text-white" onclick="viewDocument('/resources/tugas/{{$pTugas->filename}}')">View</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
@endsection
