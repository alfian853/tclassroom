<?php
namespace App;


use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $primaryKey='id';
    protected $table='materi';
    protected $fillable = ['pertemuan_id','filename'];
    public $timestamps = true;
}