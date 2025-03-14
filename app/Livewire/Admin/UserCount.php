<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User; // ইউজার মডেল ইম্পোর্ট করুন

class UserCount extends Component
{
    public $totalUsers;

    public function mount()
    {
        $this->fetchUserCount();
    }

    public function fetchUserCount()
    {
        $this->totalUsers = User::count();
    }

    public function render()
    {
        return view('livewire.admin.user-count');
    }
}