@extends('layouts.master')
@section('title')
    List Agenda
@endsection

@section('content')

    <table class="table table-striped">
        <tr>
            <th>ID Agenda</th>
            <th>Nama Agenda</th>
            <th>Hari</th>
            <th>Ruang</th>
            <th>W-Mulai</th>
            <th>W-Selesai</th>
            <th>action</th>
        </tr>
        @foreach($createdAgenda as $agenda)
        <tr>
            <td>{{$agenda->idAgenda}}</td>
            <td>{{$agenda->namaAgenda}}</td>
            <td>{{$agenda->hari}}</td>
            <td>{{$agenda->fk_idRuang}}</td>
            <td>{{$agenda->WaktuMulai}}</td>
            <td>{{$agenda->WaktuSelesai}}</td>
            <td>
                <a href="{{route('get.agenda.detail',['agenda_id' => $agenda->idAgenda])}}" class="btn btn-success">detail</a>
            </td>
        </tr>
        @endforeach

    </table>
@endsection
