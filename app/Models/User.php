<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    /**
     * @param $permission Права пользователя из таблицы permissions
     * @param false $require Если true то у пользователя должны быть все права
     * содержащиеся в массиве $permission если false то совападать должно хотя бы
     * одно право.
     * @return bool|mixed
     * Метод для проверки прав и привелегий пользователя
     */

    public function canDo($permission, $require = false)
    {
        if (is_array($permission)) {
            foreach ($permission as $perName) {
                $perName = $this->canDo($perName);
                if ($perName && !$require) {
                    return true;
                } elseif (!$perName && $require) {
                    return false;
                }
            }
            return $require;
        } else {
            //Если передаётся не массив, то сравниваются строки
            //$this->roles и $role->permissions это методы из соотв моделей
            foreach ($this->roles as $role) {
                foreach ($role->permissions as $perm) {
                    if (Str::is($permission, $perm->name)) {
                        return true;
                    }
                }
            }
        }
    }


    /**
     * @param $name Имя роли в в иде строки либо массив со списком ролей
     * @param false $require
     * @return bool|mixed
     * Функкия проверяет наличие определённой роли у пользователя
     */
    public function hasRole($name, $require = false)
    {
        if (is_array($name)) {
            foreach ($name as $roleName) {
                $hasRole = $this->hasRole($roleName);
                if ($hasRole && !$require) {
                    return true;
                } elseif (!$hasRole && $require) {
                    return false;
                }
            }
            return $require;
        } else {
            foreach ($this->roles as $role) {
                if ($role->name == $name) {
                    return true;
                }
            }
        }
        return false;
    }


}
