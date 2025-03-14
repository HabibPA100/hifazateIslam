<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Services\GoogleSheetsService;

class FatwaComponent extends Component
{
    use WithFileUploads;

    public $posts = [];
    public $heading;
    public $message;
    public $selectedRowIndex;
    public $showModal = false;

    protected $googleSheetsService;

    public function __construct()
    {
        $this->googleSheetsService = app(GoogleSheetsService::class);
    }

    public function mount()
    {
        $this->loadPosts();
    }

    public function loadPosts()
    {
        $userId = Auth::id();
        $rows = $this->googleSheetsService->getRows('fatwa', 'FatwaData');

        if ($rows) {
            $filteredPosts = [];
        
            foreach (array_slice($rows, 1) as $rowIndex => $row) { // রো নম্বর সংরক্ষণ
                if (isset($row[3]) && $row[3] == $userId) {
                    $row['original_index'] = $rowIndex + 2; // Google Sheets-এর আসল রো নম্বর সংরক্ষণ
                    $filteredPosts[] = $row;
                }
            }
        
            // সর্বশেষ পোস্ট সবার আগে দেখানোর জন্য সাজানো
            usort($filteredPosts, function ($a, $b) {
                return strtotime($b[2]) - strtotime($a[2]);
            });

            $this->posts = $filteredPosts;
        }
    }

    

    public function createPost()
    {
        $this->validate([
            'heading' => 'required|string|max:255',
            'message' => 'required|string|min:50',
        ]);

        $userId = Auth::id(); // Get the user ID
        $user_name = Auth::user()->name;
        $user_image = Auth::user()->profile_image;
        $newRow = [$this->heading, $this->message, now()->toDateTimeString(), $userId, $user_name, $user_image];
        $this->googleSheetsService->appendRow('fatwa', 'FatwaData', $newRow);

        $this->reset(['heading', 'message']);
        $this->loadPosts();
        $this->dispatch('toast', 'success', 'Post created successfully!');
        $this->showModal = false;
    }

    public function editPost($index)
    {
        if (isset($this->posts[$index])) {
            if ($this->posts[$index][3] != Auth::id()) {
                $this->dispatch('toast', 'error', 'You can only edit your own post!');
                return;
            }

            // সরাসরি 'original_index' ব্যবহার করো
            $this->selectedRowIndex = $this->posts[$index]['original_index'];

            $this->heading = $this->posts[$index][0] ?? '';
            $this->message = $this->posts[$index][1] ?? '';
            $this->showModal = true;
        }
    }

    public function updatePost()  
    {  
        $this->validate([  
            'heading' => 'required|string|max:255',  
            'message' => 'required|string|min:50',  
        ]);  
    
        // ✅ সঠিকভাবে Row Index সেট করো
        $rowIndex = $this->selectedRowIndex; 
    
        if (!$rowIndex || !isset($this->posts[array_search($rowIndex, array_column($this->posts, 'original_index'))])) {  
            $this->dispatch('toast', 'error', 'Invalid post selected!');  
            return;  
        }  
    
        // ✅ শুধুমাত্র নিজের পোস্ট এডিট করার অনুমতি দাও
        $postKey = array_search($rowIndex, array_column($this->posts, 'original_index'));
        if ($this->posts[$postKey][3] != Auth::id()) {  
            $this->dispatch('toast', 'error', 'You can only edit your own post!');  
            return;  
        }  
    
        // ✅ Google Sheets-এর রেঞ্জ নির্ধারণ করো
        $range = "FatwaData!A{$rowIndex}:F{$rowIndex}";  
    
        // ✅ আপডেটের নতুন ডাটা প্রস্তুত করো
        $updatedRow = [  
            $this->heading,  
            $this->message,  
            now()->toDateTimeString(),  
            Auth::id()  
        ];  
    
        // ✅ ডিবাগ চেক (চাইলে এটি কমেন্ট করে দিতে পারো)
      //  dd($this->selectedRowIndex, $range, $updatedRow);
    
        // ✅ Google Sheets আপডেট করো
        $this->googleSheetsService->updateRow('fatwa', $range, $updatedRow);  
    
        // ✅ আপডেটের পর নতুনভাবে পোস্ট লোড করো
        $this->loadPosts();  
        $this->selectedRowIndex = null;  
    
        // ✅ ইউজারকে মেসেজ পাঠাও
        $this->dispatch('toast', 'success', 'Post updated successfully!');  
        $this->showModal = false;  
    }

    public function deletePost($index)
    {
        // চেক করুন পোস্ট সঠিক আছে কিনা
        if (!isset($this->posts[$index])) {
            $this->dispatch('toast', 'error', 'Invalid post selected!');
            return;
        }
    
        // শুধুমাত্র নিজের পোস্ট ডিলিট করতে অনুমতি দিন
        if ($this->posts[$index][3] != Auth::id()) {
            $this->dispatch('toast', 'error', 'You can only delete your own post!');
            return;
        }
    
        // আসল Google Sheets রো ইনডেক্স বের করুন
        $rowIndex = $this->posts[$index]['original_index'];
    
        // ✅ ডিবাগ চেক
        //dd("Deleting Row Index:", $rowIndex, "PenData:", $this->posts[$index]);
    
        // Google Sheets থেকে রো ডিলিট করুন
        $this->googleSheetsService->deleteRow('fatwa', $rowIndex);
    
        // নতুনভাবে পোস্ট লোড করুন
        $this->loadPosts();
          // ✅ ইনডেক্স রিসেট করা (গুরুত্বপূর্ণ)
        $this->selectedRowIndex = null;
        $this->dispatch('toast', 'success', 'Post deleted successfully!');
    }
    

    public function render()
    {
        return view('livewire.fatwa-component', ['posts' => $this->posts]);
    }
}