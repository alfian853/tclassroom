<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'pengumpulan_tugas';
    protected $fillable = ['tugas_id','mhs_id','filename','nilai'];
}