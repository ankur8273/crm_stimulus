<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne; 
use Tymon\JWTAuth\Contracts\JWTSubject;


class Employee extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $casts = [
        'permissions' => 'object',
    ];
	// public function newQuery($excludeDeleted = false)
    // {
    //     return parent::newQuery()
    //                  ->where('role', 2);
    // }

    public function department(): HasOne
    {
        return $this->hasOne(Department::class,'id','department_id');
    }

    public function designation(): HasOne
    {
        return $this->hasOne(Designation::class,'id','department_id');
    }
    public function reporting(): HasOne
    {
        return $this->hasOne(Employee::class,'id','reporting_to');
    }
	public function getJWTIdentifier()
    {
        return $this->getKey();  // Usually, this is the primary key (id)
    }

    /**
     * Return a key-value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
