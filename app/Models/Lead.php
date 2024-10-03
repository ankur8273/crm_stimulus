<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    use HasFactory;
    protected $guarded = ['id']; 
    protected $appends = ['row'];

    public function user(): HasOne
    {
        return $this->hasOne(Employee::class,'id','user_id');
    }

    public function getRowAttribute()
    {
        return $this->where('id', '<', $this->id)->count();
    }
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(LeadNote::class);
    }
    public function callnotes(): HasMany
    {
        return $this->hasMany(CallNote::class);
    }
}
