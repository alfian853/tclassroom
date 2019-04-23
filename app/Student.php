<?php

namespace App;

use Illuminate\Foundation\Auth\User;

class Student extends User
{
    protected $primaryKey = "id";
    protected $table = 'students';

    protected $fillable = [
        'email', 'nrp', 'name','password'
    ];

    public $timestamps = false;
}