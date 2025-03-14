<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UserManagement extends Component
{
    use WithPagination;

    public $role, $user_id;
    public $editMode = false;

    // ইউজার এডিট মোড চালু
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->role = $user->role; // শুধুমাত্র রোল আপডেট করার জন্য
        $this->editMode = true;
    }

    // শুধুমাত্র রোল আপডেট
    public function updateUserRole()
    {
        $this->validate([
            'role' => 'required|in:User,Admin,Editor',
        ]);

        $user = User::findOrFail($this->user_id);
        $user->update(['role' => $this->role]);
        $this->dispatch('toast', 'success', 'ইউজারের রোল সফলভাবে আপডেট হয়েছে!');
        $this->resetForm();
    }

    // ইউজার ডিলিট
    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        $this->dispatch('toast', 'success', 'ইউজার সফলভাবে Delete হয়েছে!');
    }

    // ফর্ম রিসেট
    private function resetForm()
    {
        $this->role = '';
        $this->editMode = false;
    }

    public function render()
    {
        return view('livewire.admin.user-management', [
            'users' => User::paginate(10),
        ]);
    }
}
