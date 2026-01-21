<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Member;

class MemberForm extends Component
{
    
    public ?Member $member = null;
    
    public $is_primary;
    public $full_name;
    public $member_id;
    public $phone_number;
    public $balance;

    public function mount(Member $member)
    {
        $this->member = $member ?? new Member();
        $this->full_name = $member->full_name;
        $this->member_id = $member->member_id;
        $this->phone_number = $member->phone_number;
        $this->balance = $member->balance;  
        $this->is_primary = $member->is_primary;
    }

    public function updateMember()
    {   
        dispatch('memberUpdated');
        return redirect()->route('members.show', $this->member);
        
    }
    public function save()
    {
        
        $validated = $this->validate([
            'full_name'     => 'required|string|max:255|unique:members,full_name,' . $this->member->id,
            'phone_number'  => 'required|string|max:20',
            'balance'       => 'required|numeric|min:0',
        ]);
       
        if ( empty($this->member_id) ) {
            do {
                $count = \App\Models\Member::count();
                $newMemberId = 'M' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
                $exists = \App\Models\Member::where('member_id', $newMemberId)->exists();
            } while ($exists);
            $validated['member_id'] = $newMemberId;
        }

        // Update or create member
        $this->member->fill($validated)->save();
        // Dispatch event and redirect
        return redirect()->route('members.show', $this->member)->with('status', 'Member info has been updated!');
    }

    public function render()
    {
        return view('members.form');
    }
}
