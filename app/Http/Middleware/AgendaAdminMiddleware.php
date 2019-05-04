<?php

namespace App\Http\Middleware;

use App\Agenda;
use Auth;
use Closure;
use Session;

class AgendaAdminMiddleware
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
            Session::flash('alert','agenda tidak ditemukan');
            Session::flash('alert-type','warning');
            return redirect('/list_agenda');
        }

        $user = Auth::user();
        if($res->fk_idPIC == $user->idUser){
            return $next($request);
        }

        Session::flash('alert','unauthorized');
        Session::flash('alert-type','failed');
        return redirect('/list_agenda');
    }
}
