<?php

namespace App\Http\Middleware;

use App\Agenda;
use App\Kehadiran;
use App\MhsAgenda;
use Auth;
use Closure;
use Session;

class AgendaAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $res = Agenda::find($request->agenda_id);
        if($res == null){
            Session::flash('alert','agenda_tidak_ditemukan');
            Session::flash('alert-type','warning');
            return redirect('/list_agenda');
        }

        $user = Auth::user();
        if($res->fk_idPIC == $user->idUser){
            return $next($request);
        }

        $res = Kehadiran::where('idAgenda','=',$request->agenda_id)
            ->where('idUser','=',$user->idUser)->first();

        if($res == null){
            Session::flash('alert','anda buka mahasiswa kelas ini');
            Session::flash('alert-type','failed');
            return redirect('/list_agenda');
        }

        return $next($request);
    }
}
