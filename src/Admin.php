<?php

namespace Waxis\Cms;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function login ($params, $data) {
        $login = \Auth::guard('admin')
                    ->attempt([
                        'email' => $params['email'], 
                        'password' => $params['password']
                    ], $params['remember']);

        if ($login) {
            return true;
        }

        return false;
    }

    public static function emailNotExists ($email) {
        return !(bool) \DB::table('admins')->where('email', $email)->count();
    }
}
