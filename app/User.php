<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'confirmed_at',
        'email_verified_at'
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

    protected $changes=[
        "email_verified_at",
        "updated_at"
    ];
    /**
     * Get the posts of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function posts() {
        return $this->hasMany('App\Post','user_id', 'id');
    }

    /**
     * Get the posts of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function identities() {
        return $this->hasMany('App\SocialIdentity');
    }

    /**
     * Get user's images.
     */
    public function files() {
        return $this->morphMany('App\File', 'fileable');
    }

    /**
     * Get user's cover photo.
     */
    public function cover_image() {
        return $this->morphOne('App\File', 'fileable')->where('category', 'cover');
    }

    /**
     * defines user admin or not
     * @return bool
     */
    public function isAdmin(){
        if($this->role=="admin"){
            return true;
        }
        return false;
    }
}
