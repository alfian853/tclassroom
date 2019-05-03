<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'pertemuan';
    protected $fillable = ['agenda_id','no_pertemuan'];
}