<?php 
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', Dashboard::class)->name('admin.dashboard');
    Route::view('/admin/user/update','livewire.admin.user-show')->name('show.user');
    Route::view('/admin/all/news','livewire.admin.news-show')->name('news.show');
    Route::view('/admin/all/fatwa','livewire.admin.fatwa-show')->name('fatwa.show');
    Route::view('/admin/all/pen-post','livewire.admin.pen-post-show')->name('pen.post.show');
    Route::view('/admin/profile','livewire.admin.profile')->name('admin.profile');
});