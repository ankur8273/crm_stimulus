<?php

namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeadExport implements FromCollection, WithMapping, WithHeadings
{

   protected $req_data;
    
    public function  __construct( $req_data) {
        $this->req_data= $req_data;
    }
        
    public function collection()
    {
        if(isset($this->req_data['from']) && isset($this->req_data['to'])){
            $leads = Lead::orderBy('id','desc')->where('created_at','>=',date('Y-m-d 00:00:00',strtotime($this->req_data['from'])))->where('created_at','<=',date('Y-m-d 23:59:59',strtotime($this->req_data['to'])))->get();
        }else{
            $leads = Lead::orderBy('id','desc')->get();
        }
        return $leads;
    }

    public function headings(): array
    {

        return [
            'Lead Owner',
            'name',
            'phone',
            'alt_phone',
            'email',
            'city',
            'source',
            'followup_type',
            'lead_type',
            'channel_partner',
            'lead_status',
            'budget',
            'occupation',
            'purpose',
            'location',
            'next_action_date',
            'next_followup',
            'status',
            'created_at',
        ];
    }

    /**
    * @var Lead $lead
    */
    public function map($lead): array
    {
        
        return [
            $lead->user?$lead->user->first_name.' '.$lead->user->last_name:'',
            $lead->name,
            $lead->phone,
            $lead->alt_phone,
            $lead->email,
            $lead->city,
            $lead->source,
            $lead->followup_type,
            $lead->lead_type,
            $lead->channel_partner,
            $lead->lead_status,
            $lead->budget,
            $lead->occupation,
            $lead->purpose,
            $lead->location,
            $lead->next_action_date,
            $lead->next_followup,
            $lead->status,
            $lead->created_at,
        ];
    }
}
