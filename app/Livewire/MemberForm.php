<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

class MemberForm extends Component
{
    
    public ?Member $member = null;
    
    public $is_primary;
    public $full_name;
    public $phone_number;
    public $balance;

    public function mount(Member $member)
    {
        $this->member = $member ?? new Member();
        $this->full_name = $member->full_name;
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
            'phone_number'  => 'nullable|string|max:20',
            'balance'       => 'required|numeric|min:0',
        ]);

        // 如果是更新现有会员，则不更新 balance 字段
        if (!Auth::user()->isAdmin()) {
            unset($validated['balance']); // 不更新 balance 字段
        }
        // Update or create member
        $this->member->fill($validated)->save();
        // Dispatch event and redirect
        return redirect()->route('members.show', $this->member)->with('status', __("messages.member_info_updated"));
    }

    public function render()
    {
        return view('members.form');
    }
}
