<?php
namespace App;


use Illuminate\Database\Eloquent\Model;
//source : etc.if.its.ac.id
class Kehadiran extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'kehadiran';
    protected $fillable = [
        'idUser','idAgenda'//p[1-20]
    ];
    public $timestamps = false;
}