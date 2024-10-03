<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasOne;

class TicketDetail extends Model
{
    use HasFactory;

    public function user(): HasOne
    {
        if($this->created_by == 'admin'){
            return $this->hasOne(Admin::class,'id','user_id');
        }else{
            return $this->hasOne(Employee::class,'id','user_id');
        }
        
    }

    public function ticket(): HasOne
    {
        return $this->hasOne(Ticket::class,'id','ticket_id');
    }
}
