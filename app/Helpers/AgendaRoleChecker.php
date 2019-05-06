<?php

namespace App\Helpers;


use App\Agenda;
use Auth;
use Exception;

class AgendaRoleChecker
{
    public static function isPIC($idAgenda){
        $agenda = Agenda::where('idAgenda','=',$idAgenda)->first();
        if($agenda == null){
            throw new Exception('404 not found');
        }

        return $agenda->fk_idPIC == Auth::user()->idUser;
    }
}