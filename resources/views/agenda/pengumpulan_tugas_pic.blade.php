@extends('layouts.master')
@section('title')
    Pengumpulan Tugas
@endsection

@section('content')
    <h1>Pengumpulan Tugas</h1>
    <table class="table table-striped">
        <tr>
            <th>NRP Mahasiswa</th>
            <th>Nama Mahasiswa</th>
            <th>Waktu Pengumpulan</th>
            <th>File Tugas</th>
            <th>Action</th>
        </tr>
        @foreach($listPengumpulanTugas as $pTugas)
            <tr>
                <td>{{$pTugas->mahasiswa->idUser}}</td>
                <td>{{$pTugas->mahasiswa->name}}</td>
                <td>{{$pTugas->updated_at}}</td>
                <td>{{$pTugas->nilai}}</td>
                <td>
                    @if($pTugas == null)
                        <p style="color: red">Belum Mengumpulkan</p>
                    @else
                        <a></a>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

@endsection
