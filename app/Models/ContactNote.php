<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactNote extends Model
{
    use HasFactory;
    
    protected $appends = ['row'];

    public function user(): HasOne
    {
        return $this->hasOne(Employee::class,'id','user_id');
    }

    public function getRowAttribute()
    {
        return $this->where('id', '<', $this->id)->count();
    }
    public function contact(): HasOne
    {
        return $this->HasOne(Contact::class);
    }
}
