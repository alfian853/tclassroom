@extends('layouts.master')
@section('title')
List Tugas
@endsection

@section('add-script')
@parent
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<link rel="stylesheet" href="{{asset('Datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}">
<script src="{{asset('Datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
<script src="{{asset('js/file_upload.js')}}"></script>

<script>
    let fileUploadModal = null;
    $(document).ready(function () {
        fileUploadModal = new FileUploadModal(
            '/',
            $('input[name=_token]').val(), 'Upload File'
        )
        fileUploadModal.setOnSuccessHandler(function () {
            // location.reload(true);
        })
        fileUploadModal.init();

        $('#upload-file-trigger').click(function () {
            $('#' + fileUploadModal.getModalId()).modal('show');
        })
    });
</script>
@endsection


@section('content')

@csrf
<p style="padding-top:5px;"></p>
<h2 align="center"><strong> Kelas {{$agenda->namaAgenda}} </strong></h2>
<h3 align="center"><strong> Pertemuan {{request()->no_pertemuan}} </strong></h3>

<div class="table-responsive">
    <table class="table table-hover table-bordered">
        <thead class="thead-dark">
            <tr align="center">
                <th>Judul Tugas</th>
                <th>Deskripsi Tugas</th>
                <th>Deadline</th>
                <th>Sudah Kumpul</th>
                <th>Action</th>
            </tr>
        </thead>

        @foreach($list_tugas as $i => $tugas)
        <tr>
            <td align="center">{{$tugas->judul}}</td>
            <td id="deskripsi-{{$i}}">{{$tugas->deskripsi}}</td>
            <td align="center">{{$tugas->deadline}}</td>
            @if($tugas->pengumpulan(Auth::user()->idUser)->filename != null)
            <td align="center"><strong> <font color="green"> <i class="fa fa-check"></i> Sudah Mengumpulkan </font></strong></td>
            @else
            <td align="center"><strong> <font color="red"> <i class="fa fa-close"></i> Belum Mengumpulkan</font></strong></td>
            @endif
            <td align="center">
                <button class="btn btn-primary" onclick="(() => {
                $('#deskripsi-tugas').html( $('#deskripsi-{{$i}}').html());
                $('#deskripsiModal').modal('show');
            })()">Detail tugas</button>
                <button class="btn btn-success" type="submit" onclick="(() => {
                        fileUploadModal.setUploadUrl('{{route('post.tugas.submit',[
                            'agenda_id' => request()->agenda_id,
                            'no_pertemuan' => request()->no_pertemuan,
                            'tugas_id' => $tugas->id
                       ]
                       )}}');
                       $('#' + fileUploadModal.getModalId()).modal('show');
                })()">Kumpul tugas</button>
            </td>
        </tr>
        @endforeach

    </table>
</div>


<div class="modal fade" id="deskripsiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Deskripsi Tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="deskripsi-tugas"></p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection