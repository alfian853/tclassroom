<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'tugas';
    protected $fillable = ['pertemuan_id','deskripsi','deadline','judul'];

    function pertemuan(){
        return $this->belongsTo('App\Pertemuan','pertemuan_id','id');
    }

    function pengumpulan($userId = null){
        if($userId == null){
            return $this->hasMany('App\PengumpulanTugas','tugas_id','id');
        }
        return $this->hasOne('App\PengumpulanTugas','tugas_id','id')
            ->where('mhs_id','=',$userId)->first();
    }

}