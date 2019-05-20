<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }

    protected $fillable = [
        'name', 'email', 'password','organization_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
