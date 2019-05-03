<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'tugas';
    protected $fillable = ['pertemuan_id','deskripsi','deadline'];
}