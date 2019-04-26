<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticable;

class User extends Authenticable
{
    protected $primaryKey = "id";
    protected $table = 'users';

    protected $fillable = [
        'idUser', 'name', 'email', 'email_verified_at',
        'password', 'remember_token'
    ];

    public $timestamps = true;
}