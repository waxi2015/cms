<?php

namespace App;

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
            if (isset(\Auth::guard('admin')->user()->status) && \Auth::guard('admin')->user()->status == 0) {
                \Auth::guard('admin')->logout();
                return 'inactive';
            } else {
                return true;
            }
        }

        return false;
    }
}
