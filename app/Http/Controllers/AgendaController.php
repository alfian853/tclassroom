<?php

namespace App\Http\Controllers;
use App\Agenda;
use App\Helpers\RekapNilaiExcel;
use App\Tugas;
use App\Materi;
use App\Helpers\AgendaRoleChecker;
use App\Kehadiran;
use App\PengumpulanTugas;
use App\Pertemuan;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Phalcon\Flash;
use Session;
use Storage;
use Validator;

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

    function getListTugas(Request $request){
        $pertemuan = Pertemuan::where('agenda_id','=',$request->agenda_id)
            ->where('no_pertemuan','=',$request->no_pertemuan)->first();
        $list_tugas = Tugas::where('pertemuan_id','=',$pertemuan->id)->get();
        $agenda = Agenda::where('idAgenda','=',$request->agenda_id)->first();

        if(AgendaRoleChecker::isPIC($request->agenda_id)){
            return view('agenda.list_tugas_pic')->with([
                'list_tugas' => $list_tugas,
                'agenda' => $agenda
            ]);
        }
        else{
            return view('agenda.list_tugas_mhs')->with([
                'list_tugas' => $list_tugas,
                'agenda' => $agenda
            ]);
        }
    }

    function createTugas(Request $request) {
        $tugas = Tugas::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
            'pertemuan_id' => Pertemuan::where('no_pertemuan','=',$request->no_pertemuan)
                ->where('agenda_id','=',$request->agenda_id)->first()->id
        ]);

        $listMahasiswa = $tugas->pertemuan->agenda->mahasiswa;

        foreach ($listMahasiswa as $mhs){
            PengumpulanTugas::create([
                'tugas_id' => $tugas->id,
                'mhs_id' => $mhs->idUser
            ]);
        }

        return redirect()->back()->with('success', 'Tugas telah ditambahkan'); 
    }

    function deleteTugas(Request $request){
        Tugas::where('id','=',$request->tugas_id)->first()->delete();
        Session::flash('alert','tugas berhasil dihapus');
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

            $listPengumpulanTugas = Tugas::where('id','=',$request->tugas_id)->first()->pengumpulan;
            return view('agenda.pengumpulan_tugas_pic')->with([
                'listPengumpulanTugas' => $listPengumpulanTugas,
                'agenda' => $pertemuan->agenda
            ]);   

        }
        else{
            abort(401);
        }
    }

    function submitTugas(Request $request){
        if($request->file('file') != null){
            $tugas = Tugas::where('id','=',$request->tugas_id)->first();

            $deadLine = $tugas->deadline;
            $now = Carbon::now();
            if($now > $deadLine){
                Session::flash('alert','Batas waktu pengumpulan tugas telah berakhir!');
                Session::flash('alert-type','failed');
                return back();
            }

            $originalName = $request->file('file')->getClientOriginalName();
            $fileName = date('Y-m-d-H-m-s').'-'.$originalName;

            $pTugas = PengumpulanTugas::where('tugas_id','=',$request->tugas_id)
            ->where('mhs_id','=',Auth::user()->idUser)
            ->update([
                'filename' => $fileName,
                'waktu_submit' => Carbon::now()
            ]);

            Storage::putFileAs('resources/tugas', $request->file('file'), $fileName);
            Session::flash('alert','Tugas berhasil dikumpulkan');
            Session::flash('alert-type','success');
        }
        else{
            Session::flash('alert','Upload Failed');
            Session::flash('alert-type','Failed');
        }
    }

    function exportNilai(Request $request){
        $helper = new RekapNilaiExcel($request->agenda_id);
        $agenda = Agenda::where('idAgenda','=',$request->agenda_id)->first();
        $filename = 'Rekap-Nilai-'.$agenda->singkatAgenda.'.csv';
        return Excel::download($helper,$filename);
    }

    function submitNilai(Request $request) {
        PengumpulanTugas::where('tugas_id','=',$request->tugas_id)
        ->where('mhs_id','=',$request->mhs_id)
        ->update([
         'nilai' => $request->nilai
        ]);
        return back();
    }

    function submitPesan(Request $request) {
        $tugas = Tugas::where('id','=',$request->tugas_id)->first();
        $pTugas = PengumpulanTugas::where('tugas_id','=',$request->tugas_id)
        ->where('mhs_id','=',Auth::user()->idUser)
        ->update([
            'pesan' => $request->pesan
        ]);
        return back();
    }

}
