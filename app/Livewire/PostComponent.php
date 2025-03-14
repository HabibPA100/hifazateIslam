<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Services\GoogleSheetsService;

class PostComponent extends Component
{
    use WithFileUploads;

    public $posts = [];
    public $title;
    public $content;
    public $image;
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
        $rows = $this->googleSheetsService->getRows('post', 'Data');

        if ($rows) {
            $filteredPosts = [];
        
            foreach (array_slice($rows, 1) as $rowIndex => $row) { // রো নম্বর সংরক্ষণ
                if (isset($row[4]) && $row[4] == $userId) {
                    $row['original_index'] = $rowIndex + 2; // Google Sheets-এর আসল রো নম্বর সংরক্ষণ
                    $filteredPosts[] = $row;
                }
            }
        
            // সর্বশেষ পোস্ট সবার আগে দেখানোর জন্য সাজানো
            usort($filteredPosts, function ($a, $b) {
                return strtotime($b[3]) - strtotime($a[3]);
            });

            $this->posts = $filteredPosts;
        }
    }

    

    public function createPost()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:50',
            'image' => 'nullable|image|max:10240',
        ]);

        $imageUrl = null;

        if ($this->image) {
            $imagePath = $this->image->store('posts', 'public');
            $imageUrl = Storage::url($imagePath);
        }

        $userId = Auth::id(); // Get the user ID
        $user_name = Auth::user()->name;
        $user_image = Auth::user()->profile_image;
        $newRow = [$this->title, $this->content, $imageUrl ?? '', now()->toDateTimeString(), $userId, $user_name, $user_image];
        $this->googleSheetsService->appendRow('post', 'Data', $newRow);

        $this->reset(['title', 'content', 'image']);
        $this->loadPosts();
        $this->dispatch('toast', 'success', 'Post created successfully!');
        $this->showModal = false;
    }

    public function editPost($index)
    {
        if (isset($this->posts[$index])) {
            if ($this->posts[$index][4] != Auth::id()) {
                $this->dispatch('toast', 'error', 'You can only edit your own post!');
                return;
            }

            // সরাসরি 'original_index' ব্যবহার করো
            $this->selectedRowIndex = $this->posts[$index]['original_index'];

            $this->title = $this->posts[$index][0] ?? '';
            $this->content = $this->posts[$index][1] ?? '';
            $this->showModal = true;
        }
    }

    public function updatePost()  
    {  
        $this->validate([  
            'title' => 'required|string|max:255',  
            'content' => 'required|string|min:50',  
            'image' => 'nullable|image|max:10240',  
        ]);  
    
        // ✅ সঠিকভাবে Row Index সেট করো
        $rowIndex = $this->selectedRowIndex; 
    
        if (!$rowIndex || !isset($this->posts[array_search($rowIndex, array_column($this->posts, 'original_index'))])) {  
            $this->dispatch('toast', 'error', 'Invalid post selected!');  
            return;  
        }  
    
        // ✅ শুধুমাত্র নিজের পোস্ট এডিট করার অনুমতি দাও
        $postKey = array_search($rowIndex, array_column($this->posts, 'original_index'));
        if ($this->posts[$postKey][4] != Auth::id()) {  
            $this->dispatch('toast', 'error', 'You can only edit your own post!');  
            return;  
        }  
    
        // ✅ Google Sheets-এর রেঞ্জ নির্ধারণ করো
        $range = "Data!A{$rowIndex}:G{$rowIndex}";  
    
        // ✅ আপডেটের নতুন ডাটা প্রস্তুত করো
        $updatedRow = [  
            $this->title,  
            $this->content,  
            $this->posts[$postKey][2] ?? '',  // আগের ইমেজ থাকলে সেটি রাখা হবে
            now()->toDateTimeString(),  
            Auth::id()  
        ];  
    
        // ✅ নতুন ইমেজ থাকলে সেটিকে সংযুক্ত করো
        if ($this->image) {  
            $imagePath = $this->image->store('posts', 'public');  
            $updatedRow[2] = Storage::url($imagePath);  
        }  
    
        // ✅ ডিবাগ চেক (চাইলে এটি কমেন্ট করে দিতে পারো)
      //  dd($this->selectedRowIndex, $range, $updatedRow);
    
        // ✅ Google Sheets আপডেট করো
        $this->googleSheetsService->updateRow('post', $range, $updatedRow);  
    
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
        if ($this->posts[$index][4] != Auth::id()) {
            $this->dispatch('toast', 'error', 'You can only delete your own post!');
            return;
        }
    
        // আসল Google Sheets রো ইনডেক্স বের করুন
        $rowIndex = $this->posts[$index]['original_index'];
    
        // ✅ ডিবাগ চেক
        //dd("Deleting Row Index:", $rowIndex, "PenData:", $this->posts[$index]);
    
        // যদি ইমেজ থাকে, তাহলে সেটি ডিলিট করুন
        if (!empty($this->posts[$index][2]) && Storage::exists($this->posts[$index][2])) {
            Storage::delete($this->posts[$index][2]);
        }
    
        // Google Sheets থেকে রো ডিলিট করুন
        $this->googleSheetsService->deleteRow('post', $rowIndex);
    
        // নতুনভাবে পোস্ট লোড করুন
        $this->loadPosts();
          // ✅ ইনডেক্স রিসেট করা (গুরুত্বপূর্ণ)
        $this->selectedRowIndex = null;
        $this->dispatch('toast', 'success', 'Post deleted successfully!');
    }
    

    public function render()
    {
        return view('livewire.post-component', ['posts' => $this->posts]);
    }
}