<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
//source : etc.if.its.ac.id
class Pic extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'tugas';
    protected $fillable = ['pertemuan_id','deskripsi','deadline'];
}