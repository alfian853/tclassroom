@extends('layouts.master')
@section('title')
    Agenda
@endsection

@section('content')
    <table class="table table-striped">
        <tr>
            <th>nomor pertemuan</th>
            <th>action</th>
        </tr>
        @foreach($list_pertemuan as $pertemuan)
            <tr>
                <td>{{$pertemuan->no_pertemuan}}</td>
                <td>
                    <a href="{{route('get.agenda.materi',['agenda_id' => request()->agenda_id,'pertemuan' => $pertemuan->no_pertemuan])}}"
                        class="btn btn-success">lihat materi</a>
                    <a href="{{route('get.agenda.tugas',['agenda_id' => request()->agenda_id,'pertemuan' => $pertemuan->no_pertemuan])}}" class="btn btn-success">lihat tugas</a>
                </td>
            </tr>
        @endforeach

    </table>

@endsection
