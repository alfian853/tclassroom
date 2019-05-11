@extends('layouts.master') 
@section('title') Agenda
@endsection
 
@section('add-script') @parent
<link rel="stylesheet" href="{{asset('css/style.css')}}">
<link rel="stylesheet" href="{{asset('fonts/ionicons/css/ionicons.min.css')}}">
<link rel="stylesheet" href="{{asset('fonts/flaticon/font/flaticon.css')}}">
@endsection
 
@section('content')
<a class="btn btn-success" href="{{route('get.agenda.rekap_nilai',['agenda_id' => request()->agenda_id])}}">Download Rekap Nilai</a>
<p style="padding-top:10px;"></p>
<div class="container">
    <div class="card bg-light">
        <div class="card-body">
            <h2 align="center"><strong>LIST PERTEMUAN</strong></h2>
            <hr>
            @foreach ($list_pertemuan as $pertemuan)
            <div class="row align-items-center p-4">
                <div class="col-sm-3" align="center">
                    <span class="episode-number">{{$pertemuan->no_pertemuan}}</span>
                    <p></p>
                </div>

                <div class="col-sm-4" align="center">
                    <p align="center" style="font-size:24px;">List tugas dan materi pertemuan ke - {{$pertemuan->no_pertemuan}}</p>
                </div>
                <div class="col-sm-5" align="center">
                    <a href="{{route('get.agenda.materi',['agenda_id' => request()->agenda_id,'pertemuan' => $pertemuan->no_pertemuan])}}" class="btn btn-lg btn-outline-success">Lihat Materi</a>
                    <a href="{{route('get.agenda.tugas',['agenda_id' => request()->agenda_id,'pertemuan' => $pertemuan->no_pertemuan])}}" class="btn btn-lg btn-outline-danger">Lihat Tugas</a>
                </div>
            </div>
            <hr>
            @endforeach
        </div>
    </div>
</div>
@endsection