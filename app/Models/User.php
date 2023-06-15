<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Authenticatable implements AuthenticatableContract, CanResetPasswordContract
{
    use HasFactory, Notifiable;

    protected $table = 'tb_jmf_usuario';
    protected $primaryKey = 'usuario_id';

    protected $fillable = [
        'usuario_nome',
        'usuario_login',
        'usuario_senha',
        'usuario_perfil',
    ];

    protected $hidden = [
        'usuario_senha',
    ];

    public function getAuthIdentifierName()
    {
        return $this->primaryKey;
    }

    public function getAuthIdentifier()
    {
        return $this->getAttribute($this->primaryKey);
    }

    public function getAuthPassword()
    {
        return $this->usuario_senha;
    }

    public function getRememberToken()
    {
        return $this->getAttribute($this->getRememberTokenName());
    }

    public function setRememberToken($value)
    {
        $this->setAttribute($this->getRememberTokenName(), $value);
    }

    public function getRememberTokenName()
    {
        return 'usuario_remember_token';
    }
}
