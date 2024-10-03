<?php

namespace App\Imports; 

use App\User;
use Illuminate\Support\Collection;

use App\Models\Lead;

use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Validation\Rule;

class LeadsImport implements ToCollection, WithHeadingRow, WithValidation, ToModel
{
    private $rows = 0;
    protected $added_by;
    protected $result = [
		'total_count' => 0,
		'exit_count_records' => 0,
		'exit_data' => []
	];
    public function  __construct($added_by) {
            $this->added_by= $added_by;
        }
        
    public function collection(Collection $rows)
	{
		// Determine the added_by_id based on the guard (employee or admin)
		$added_by_id = $this->added_by == 'employee' ? Auth::guard('employee')->user()->id : Auth::guard('admin')->user()->id;

		$exit_count_records = 0;
		$count = 1;
		$array = [];

		foreach ($rows as $row) {
			// Check if the lead already exists by email or phone
			$lead = Lead::where('email', $row['email'])->orWhere('phone', $row['phone'])->first();

			if ($lead) {
				// If lead exists, update its email
				$lead->email = $row['email'];
				$lead->save();

				// Store the row number and email for reporting
				$array[] = ['row_no' => $count, 'email' => $row['email']];
				$exit_count_records++;
			} else {
				// Create a new lead if it doesn't exist
				Lead::create([
					'source' => $row['source'] ?? '',
					'added_by' => $this->added_by ?? '',
					'added_by_id' => $added_by_id ?? '',
					'name' => $row['name'] ?? '',
					'email' => $row['email'] ?? '',
					'phone' => $row['phone'] ?? '',
					'alt_phone' => $row['alt_phone'] ?? '',
					'city' => $row['city'] ?? '',
					'lead_type' => $row['lead_type'] ?? '',
					'budget' => $row['budget'] ?? '',
					'occupation' => $row['occupation'] ?? '',
					'purpose' => $row['purpose'] ?? '',
					'location' => $row['location'] ?? '',
					'note' => $row['note'] ?? '',
				]);
			}
			$count++;
		}


		// Prepare the result data
		$this->result['total_count'] = $count - 1; // Subtract 1 since the counter is incremented after loop
		$this->result['exit_count_records'] = $exit_count_records;
		$this->result['exit_data'] = $array;
	}

    public function model(array $row)
    {
        ++$this->rows;
    }

    public function rules(): array
    {
        return [
             // Can also use callback validation rules
             // 'email' => Rule::unique('leads', 'email'), // Table name, field in your db
            
        ];
    }
    
    public function customValidationMessages()
        {
            return [
                // 'email.unique' => 'Emails Must be unique',
            ];
        }
        
    public function getResult()
	{
		return $this->result;
	}
}