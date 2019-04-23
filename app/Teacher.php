<?php

namespace App;
use Illuminate\Foundation\Auth\User;

class Teacher extends User
{
    protected $primaryKey = "id";
    protected $table = 'teachers';

    protected $fillable = [
        'email', 'nip', 'name','password'
    ];

    public $timestamps = false;
}