@extends('layouts.master')
@section('title')
    List Agenda
@endsection

@section('content')
    
    <div class="container">

        <div class="row" align="middle"> 
            @if(count($createdAgenda))
                <div class="col align-self-center"><h1>Kelas Mengajar</h1></div>
                <table class="table table-bordered table-hover">
                    <thead class="thead-light" align="middle">
                    <tr>
                        <th>ID Agenda</th>
                        <th>Nama Agenda</th>
                        <th>Hari</th>
                        <th>Ruang</th>
                        <th>W-Mulai</th>
                        <th>W-Selesai</th>
                        <th>action</th>
                    </tr>
                    </thead>
                    @foreach($createdAgenda as $agenda)
                    <tr align="middle">
                        <td>{{$agenda->idAgenda}}</td>
                        <td align="left">{{$agenda->namaAgenda}}</td>
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
            @endif
        </div>  

        <div class="row" align="middle">
            @if(count($joinedAgenda))
                <div class="col align-self-center"><h1>Kelas Yang Diikuti</h1></div>
                <table class="table table-striped table-bordered table-hover">
                    <tr align="middle">
                        <th>ID Agenda</th>
                        <th>Nama Agenda</th>
                        <th>Hari</th>
                        <th>Ruang</th>
                        <th>W-Mulai</th>
                        <th>W-Selesai</th>
                        <th>action</th>
                    </tr>
                    @foreach($joinedAgenda as $agenda)
                    <tr align="middle">
                        <td>{{$agenda->idAgenda}}</td>
                        <td align="left">{{$agenda->namaAgenda}}</td>
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
            @endif
            </div>
        </div>
@endsection
