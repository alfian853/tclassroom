<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'pertemuan';
    protected $fillable = ['agenda_id','no_pertemuan'];

    function agenda(){
        return $this->belongsTo('App\Agenda','agenda_id','idAgenda');
    }

    function tugas(){
        return $this->hasMany('App\Tugas','pertemuan_id','id');
    }
}