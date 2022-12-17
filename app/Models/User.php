<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_id',
        'first_name',
        'last_name',
        'gender',
        'first_name',
        'email',
        'mobile_number',
        'type',
        'password',
        'patient_id',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * returns user by ID.
     *
     * @param $id
     *
     * @return mixed
     */
    public static function get($id)
    {
        return User::find($id);
    }
    
    /**
     * Add/update user.
     *
     * @throws \Exception
    */
    public function edit()
    {
        $postData = request()->except(['id']);
        unset($postData['_token']);
        $this->forceFill($postData);
        $this->save();
    }

    /**
     * Returns total users count
     * 
     * @return mixed 
     */
    public static function getUserCount()
    {
        return User::count();
    }

    /**
     * 
     * Returns last 5 added users
     * 
     *  @return mixed
     */
    public static function getRecentlyAdded()
    {
        return User::orderBy('id', 'DESC')->distinct()->limit(5)->get()->toArray();
    }
}