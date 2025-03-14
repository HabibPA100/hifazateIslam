<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class FatwaCount extends Component
{
    public $totalPosts = 0;

    public function mount()
    {
        $this->fetchPostCount();
    }

    public function fetchPostCount()
    {
        try {
            $sheetId = config('services.google.sheet_id.fatwa');
            $apiKey = env('GOOGLE_API_KEY');
           // dd(env('GOOGLE_API_KEY'));

            $range = 'FatwaData!A:F';
    
            if (!$sheetId) {
                throw new \Exception("Google Sheet ID পাওয়া যায়নি।");
            }
    
            $url = "https://sheets.googleapis.com/v4/spreadsheets/{$sheetId}/values/{$range}?key={$apiKey}";
    
            $response = Http::get($url);
    
            if ($response->failed()) {
                throw new \Exception("API ব্যর্থ হয়েছে: " . $response->body());
            }
    
            $data = $response->json();
            
            if (!isset($data['values'])) {
                throw new \Exception("Google Sheet থেকে ডাটা পাওয়া যায়নি।");
            }
    
            $this->totalPosts = count($data['values']) - 1;
        } catch (\Exception $e) {
            dd("ত্রুটি: " . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.fatwa-count');
    }
}
