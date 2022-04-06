<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Employee extends Model implements AuthenticatableContract
{
    use Authenticatable;
    use SoftDeletes;

    // protected $guard = 'employee';

    // protected $guarded = ['id'];
    // protected $hidden = [
    //  'employee_password', 'remember_token',
    // ];
    // public function getAuthPassword()
    // {
    //  return $this->employee_password;
    // }
    use Notifiable;

    // protected $guard = 'employee';

    protected $table = 'employees';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','mobile','dob','designation','doj','profile_picture'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    ///////
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
    // public function setPasswordAttribute($password)
    // {
    // $this->attributes['password'] = bcrypt($password);
    // }

    // public function getAuthPassword()
    // {
    //  return $this->password;
    // }

    ///////

    public function project()
    {
        return $this->belongsToMany(Project::class, 'employee_project', 'employee_id', 'project_id')->withTimestamps();
    }
}

