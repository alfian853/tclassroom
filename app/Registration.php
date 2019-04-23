<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $primaryKey='email';
    protected $table='registrations';
	protected $fillable = ['email','token', 'data'];
	public $timestamps = false;

    public $incrementing = false;
}
