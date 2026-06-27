<?php

namespace App\Livewire;

use Livewire\Component;

class MemberList extends Component
{
    public $members;

    public $searchTerm = '';

    public function mount()
    {
        $this->members = \App\Models\Member::orderBy('id')->get();
    }

    public function updatedSearchTerm()
    {
        $this->members = \App\Models\Member::where(function ($query) {
            $query
                ->where('full_name', 'like', '%'.$this->searchTerm.'%')
                ->orWhere('phone_number', 'like', '%'.$this->searchTerm.'%');
        })->get();
    }

    public function showMember($memberId)
    {
        return $this->redirectRoute('members.show', $memberId);
    }

    public function render()
    {
        return view('livewire.member-list', [
            'members' => $this->members,
        ]);
    }
}
