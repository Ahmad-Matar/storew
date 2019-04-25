<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $table = 'users';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
    /**
     * The attributes that are mass assignable.

     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'admin',
    ];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Make a boot function to listen
     * to any model events that are fired below.
     */
    public static function boot() {
       
        parent::boot();

       
       
        static::creating(function($user) {
            $user->token = str_random(30);
        });
    }


    /**
     * Confirm the users email by
     * setting verified to true,
     * token to a NULL value,
     * then save the results.
     */
    public function confirmEmail() {
        $this->verified = true;
        $this->token = null;
        $this->save();
    }
    
    
}
