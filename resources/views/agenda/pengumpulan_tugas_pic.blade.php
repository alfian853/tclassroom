@extends('layouts.master')
@section('title')
    Pengumpulan Tugas
@endsection

@section('content')
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
                        <a href="/resources/tugas/{{$pTugas->filename}}" target="_blank">Download</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

@endsection
