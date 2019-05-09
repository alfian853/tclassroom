@extends('layouts.master')
@section('title')
List Tugas
@endsection

@section('add-script')
@parent
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{asset('Datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}">
<script src="{{asset('Datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
<script>
$(function () {
  $('#datetime').datetimepicker({
      format: 'YYYY-MM-DD HH:mm'
  });
});

</script>
@endsection

@section('content')
<h3>Kelas {{$agenda->namaAgenda}}</h3>
<h3>Pertemuan {{request()->no_pertemuan}}</h3>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    <i class="fa fa-plus"></i> Tambah Tugas
</button>

<!-- Modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-group" data-toggle="validator" action="{{route('post.agenda.tugas',['agenda_id' => request()->agenda_id,'pertemuan_id' => request()->no_pertemuan])}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mt-3">
                            <strong> <label for="judul">Judul Tugas : </label></strong>
                        </div>
                        <div class="col-md-8 mt-3">
                            <input type="text" class="form-control" name="judul" placeholder="Judul Tugas" minlength="8">
                        </div>
                        <div class="col-md-4 mt-3">
                            <strong> <label for="deskripsi">Deskripsi Tugas : </label></strong>
                        </div>
                        <div class="col-md-8 mt-3">
                            <textarea type="text" name="deskripsi" class="form-control"
                                      minlength="20"
                                      placeholder="Deskripsi Tugas"></textarea>
                        </div>
                        <div class="col-md-4 mt-3">
                            <strong> <label for="deadline">Deadline Tugas : </label></strong>
                        </div>
                        <div class="col-md-8 mt-3">
                            <input type="text" class="form-control" name="deadline" placeholder="Deadline" id="datetime">
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

<table class="table table-striped">
    <tr>
        <th>JudulTugas</th>
        <th>Deskripsi Tugas</th>
        <th>Deadline</th>
        <th>Action</th>
    </tr>
    @foreach($list_tugas as $tugas)
    <tr>
        <td>{{$tugas->judul}}</td>
        <td>{{$tugas->deskripsi}}</td>
        <td>{{$tugas->deadline}}</td>
        <td>                   
            <a href="{{route('get.detail.tugas',['agenda_id' => request()->agenda_id,'pertemuan_id' => request()->no_pertemuan])}}" class="btn btn-success">Detail tugas</a>
            <form method="post" action="{{route('post.tugas.delete',[
            'agenda_id' => request()->agenda_id,'pertemuan_id' => request()->no_pertemuan, 'tugas_id' => $tugas->id
            ])}}" >
                @csrf
                <button class="btn btn-danger" type="submit">Hapus tugas</button>
            </form>
        </td>
    </tr>
    @endforeach

</table>
@endsection