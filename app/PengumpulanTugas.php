<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'pengumpulan_tugas';
    protected $fillable = ['tugas_id','mhs_id','filename','nilai','waktu_submit'];

    public $timestamps = false;

    function mahasiswa(){
        return $this->belongsTo('App\User','mhs_id','idUser');
    }
}