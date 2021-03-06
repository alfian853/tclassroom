<?php
namespace App;


use Illuminate\Database\Eloquent\Model;
//source : etc.if.its.ac.id
class Agenda extends Model
{
    protected $primaryKey = 'idAgenda';
    protected $table = 'agenda';
    protected $fillable = [
        'namaAgenda','singkatAgenda','tanggal','hari','fk_idRuang',
        'WaktuMulai','WaktuSelesai','fk_idPIC','notule'
    ];
    public $incrementing = false;
    public $timestamps = true;

    function mahasiswa(){
        return $this->hasMany('App\Kehadiran','idAgenda','idAgenda');
    }

    function pertemuan(){
        return $this->hasMany('App\Pertemuan','agenda_id','idAgenda');
    }

}