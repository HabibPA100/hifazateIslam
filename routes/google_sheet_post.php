<?php

use App\Services\GoogleSheetsService;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

Route::get('/', function (GoogleSheetsService $googleSheetsService, Request $request) {
    $rows = $googleSheetsService->getRows('post','Data');

    // প্রথম সারি (header) বাদ দিয়ে সমস্ত ডাটা `$posts`-এ সেট করা হলো
    $posts = $rows ? array_slice($rows, 1) : [];

    // `created_at` কলাম (index 5) অনুসারে সর্বশেষ পোস্ট সবার আগে দেখানোর জন্য সাজানো
    usort($posts, function ($a, $b) {
        return strtotime($b[3] ?? '1970-01-01') - strtotime($a[3] ?? '1970-01-01');
    });

    // Pagination সেটআপ (প্রতি পেজে ১০টি পোস্ট)
    $perPage = 4;
    $currentPage = $request->input('page', 1);
    $offset = ($currentPage - 1) * $perPage;
    $paginatedPosts = new LengthAwarePaginator(
        array_slice($posts, $offset, $perPage),
        count($posts),
        $perPage,
        $currentPage,
        ['path' => $request->url()]
    );

    return view('welcome', ['posts' => $paginatedPosts]);
});
