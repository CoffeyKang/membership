<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Staff;

class StaffInfo extends Component
{   
    public ?Staff $staff = null;

    public $full_name;
    public $nick_name;
    public $phone_number;
    public $base_salary;
    public $monthly_minimum_sales_amount;
    public $commission_rate;
    public $is_left;
    public $created_at;

    protected $rules = [
        'full_name' => 'required|string|max:255',
        'nick_name' => 'nullable|string|max:255',
        'phone_number' => 'required|string|max:20',
        'base_salary' => 'required|numeric|min:0',
        'monthly_minimum_sales_amount' => 'required|numeric|min:0',
        'commission_rate' => 'required|numeric|min:0|max:1',
    ];

    protected $messages = [
        'full_name.required' => 'Full name is required.',
        'nick_name.string' => 'Nick name must be a string.',
        'phone_number.required' => 'Phone number is required.',
        'base_salary.required' => 'Base salary is required.',
        'monthly_minimum_sales_amount.required' => 'Monthly minimum sales amount is required.',
        'commission_rate.required' => 'Commission rate is required.',
        'commission_rate.min' => 'Commission rate must be at least 0.',
        'commission_rate.max' => 'Commission rate must be at most 1.',
    ];

    public function mount(Staff $staff)
    {   
        $this->staff = $staff;
        $this->full_name = $staff->full_name;
        $this->nick_name = $staff->nick_name;
        $this->phone_number = $staff->phone_number;
        $this->base_salary = $staff->base_salary;
        $this->monthly_minimum_sales_amount = $staff->monthly_minimum_sales_amount;
        $this->commission_rate = $staff->commission_rate;
        $this->is_left = $staff->is_left;
        $this->created_at = $staff->created_at;
    }

    public function toggleLeft( )
    {   
        $this->staff->is_left = !$this->staff->is_left;
        $this->staff->save();
        $this->is_left = $this->staff->is_left;
    }

    public function save()
    {
        $this->staff->fill($this->validate())->save();
        $this->staff->refresh();
        session()->flash('success', 'Staff info updated successfully!');
    }
    
    public function render()
    {
        return view('livewire.staff-info');
    }
}
