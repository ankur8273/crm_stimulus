<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
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

    public function tkt_details(): HasMany
    {
        return $this->HasMany(TicketDetail::class,'ticket_id','id');
    }
}
