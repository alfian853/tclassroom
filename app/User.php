<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
//source : etc.if.its.ac.id
class User extends Authenticable
{
    use Notifiable;

    protected $primaryKey = "id";
    protected $table = 'users';

    protected $fillable = [
        'idUser', 'name', 'email'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    public $timestamps = true;
}