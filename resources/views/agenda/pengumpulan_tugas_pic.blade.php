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

<h1 align="center"><strong> PENGUMPULAN TUGAS</strong></h1>
<h3 align="center"><strong> Kelas {{$agenda->namaAgenda}}</strong></h3>
<h3 align="center"><strong> Pertemuan {{request()->no_pertemuan}}</strong></h3>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr align="center">
                <th>No</th>
                <th>NRP Mahasiswa</th>
                <th>Nama Mahasiswa</th>
                <th>Waktu Pengumpulan</th>
                <th>Nilai</th>
                <th>Action</th>
            </tr>
        </thead>

        @foreach($listPengumpulanTugas as $i => $pTugas)
        <tr>
            <td align="center" style="padding-top:25px;">{{$i+1}}</td>
            <td align="center" style="padding-top:25px;">{{$pTugas->mahasiswa->idUser}}</td>
            <td style="padding-top:25px;">{{$pTugas->mahasiswa->name}}</td>
            <td align="center" style="padding-top:25px;">{{$pTugas->waktu_submit}}</td>
            <td align="center" style="padding-top:25px;">{{$pTugas->nilai}}</td>
            <td align="center">
                @if($pTugas->filename == null)
                <p style="color: red" ><strong><i class="fa fa-close"></i> Belum Mengumpulkan</strong></p>
                @else
                <a href="/resources/tugas/{{$pTugas->filename}}" class="btn btn-success" target="_blank">Download</a>
                <a class="btn btn-primary text-white"
                    onclick="viewDocument('/resources/tugas/{{$pTugas->filename}}')">View</a>
                <button class="btn btn-danger" type="submit" onclick="(() => {
                      $('#modalnilai').modal('show');
                      $('#mhs-id-input').val('{{$pTugas->mahasiswa->idUser}}');
                    })()">Beri Nilai</button>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</div>


<div class="modal fade" id="modalnilai" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Input Nilai Tugas</h5>
            </div>
            <div class="modal-body">
                    <form
                        action="{{route('post.tugas.nilai',['agenda_id' => request()->agenda_id
                        ,'pertemuan' => request()->no_pertemuan, 'tugas_id' => request()->tugas_id])}}"
                        method="post" class="form-group">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mt-2">
                                <label for="nilai"><strong> Nilai Tugas : </strong></label>
                            </div>
                            <input id="mhs-id-input" type="hidden" name="mhs_id">
                            <div class="col-md-8">
                                <input type="number" min="0" max="100" class="form-control" placeholder="Masukkan Nilai Tugas" name="nilai">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>                
            </div>
        </div>
    </div>
</div>

@endsection