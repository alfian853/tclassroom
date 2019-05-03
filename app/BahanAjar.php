<?php
namespace App;


use Illuminate\Database\Eloquent\Model;

class BahanAjar extends Model
{
    protected $primaryKey='id';
    protected $table='bahan_ajar';
    protected $fillable = ['pertemuan_id','filename'];
    public $timestamps = true;
}