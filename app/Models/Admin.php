<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;
	protected $casts = [
        'permissions' => 'object',
    ];
	protected $fillable = [
        'name',
        'email',
        'password',
		'role_id',
		'status',
		'permissions'
        // Add other fields if necessary
    ];

     
    protected $hidden = [
        'password',
        // Add other hidden fields if necessary
    ];
}
