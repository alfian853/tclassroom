<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mhs extends Model
{
    //
    protected $primaryKey = 'nrp';
    public $incrementing = false;

    protected $fillable = [
    'nrp','nama','nipdosenwali'
    ];

    public function dosen()
    {
        return $this->belongsTo('App\dosen','nipdosenwali','nip');
    }

}
