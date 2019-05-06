<?php

namespace App\Http\Controllers;


use App\Agenda;
use App\Helpers\AgendaRoleChecker;
use App\Kehadiran;
use App\Materi;
use App\PengumpulanTugas;
use App\Pertemuan;
use Auth;
use Illuminate\Http\Request;
use Session;
use Storage;

class AgendaController extends Controller
{

    function getListAgenda(){
        $createdAgenda = Agenda::where('fk_idPIC','=',Auth::user()->idUser)->get();
        $joinedAgenda = Agenda::whereHas('mahasiswa',function($query){
            $query->where('idUser','=',Auth::user()->idUser);
        })->get();

        return view('agenda.list_agenda')->with([
            'createdAgenda' => $createdAgenda,
            'joinedAgenda' => $joinedAgenda
        ]);
    }

    function getAgendaDetail(Request $request){
        $list_pertemuan = Pertemuan::where('agenda_id','=',$request->agenda_id)->get();
        if(count($list_pertemuan) == 0){
            for($i = 0; $i <= 16; $i++){
                Pertemuan::create([
                    'agenda_id' => $request->agenda_id,
                    'no_pertemuan' => $i
                ]);
            }
            $list_pertemuan = Pertemuan::where('agenda_id','=',$request->agenda_id)->get();
        }
        return view('agenda.agenda_detail')->with([
            'list_pertemuan' => $list_pertemuan
        ]);
    }

    function getListMateri(Request $request){
        $pertemuan = Pertemuan::where('agenda_id','=',$request->agenda_id)
            ->where('no_pertemuan','=',$request->no_pertemuan)->first();
        $list_materi = Materi::where('pertemuan_id','=',$pertemuan->id)->get();
        return view('agenda.list_materi')->with([
            'list_materi' => $list_materi
        ]);
    }

    function uploadMateri(Request $request){
        if($request->file('file') != null){
            $originalName = $request->file('file')->getClientOriginalName();
            $fileName = date('Y-m-d-H-m-s').'-'.$originalName;
            Materi::create([
                'filename' => $fileName,
                'pertemuan_id' => Pertemuan::where('no_pertemuan','=',$request->no_pertemuan)
                    ->where('agenda_id','=',$request->agenda_id)->first()->id,
                'course_id' => $request->course_id
            ]);

            Storage::putFileAs('resources/materi', $request->file('file'), $fileName);
            Session::flash('alert','Upload Success');
            Session::flash('alert-type','success');
        }
        else{
            Session::flash('alert','Upload Failed');
            Session::flash('alert-type','Failed');
        }
    }

    function deleteMateri(Request $request){
        $materi = Materi::where('id','=',$request->materi_id)->first();
        if($materi == null){
            Session::flash('alert', 'file tidak ditemukan');
            Session::flash('alert-type', 'failed');
            return back();
        }
        Storage::delete('resources/materi/'.$materi->filename);
        $materi->delete();
        Session::flash('alert','file '.$materi->filename.' telah dihapus');
        Session::flash('alert-type','success');
        return back();
    }

    function getListPengumpulanTugas(Request $request){
        if(AgendaRoleChecker::isPIC($request->agenda_id)){
            $pertemuan = Pertemuan::where('agenda_id','=',$request->agenda_id)
            ->where('no_pertemuan','=',$request->no_pertemuan)->first();
            if($pertemuan == null){
                abort(404);
            }
            $listPengumpulanTugas = PengumpulanTugas::where('pertemuan_id','=',$pertemuan->id)->get();

            
        }
        else{
            $pertemuan = Pertemuan::where('agenda_id','=',$request->agenda_id);

            if($pertemuan == null){
                abort(404);
            }
            $pengumpulanTugas = PengumpulanTugas::where('pertemuan_id','=',$pertemuan->id)
            ->where('mhs_id','=',Auth::user()->idUser)->first();
        }
    }

}