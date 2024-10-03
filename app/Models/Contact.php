<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasOne;

class Contact extends Model
{
    use HasFactory;
    
    protected $appends = ['row'];

    public function user(): HasOne
    {
        return $this->hasOne(Employee::class,'id','user_id');
    }
    public function lead(): HasOne
    {
        return $this->hasOne(Lead::class,'id','lead_id');
    }

    public function getRowAttribute()
    {
        return $this->where('id', '<', $this->id)->count();
    }
}
