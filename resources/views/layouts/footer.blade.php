<footer class="py-6 text-white bg-gray-800">
    <div class="container grid grid-cols-1 gap-6 px-4 mx-auto text-center md:grid-cols-3 md:text-left">
        
        <!-- About Section -->
        <div>
            <h2 class="mb-2 text-xl font-semibold">About Us</h2>
            <p class="text-lg text-left text-gray-400">হিফাজতে ইসলাম বাংলাদেশ একটি অ-রাজনৈতিক ইসলামী সংগঠন, যা দেশের ধর্মপ্রাণ মুসলমানদের ঈমান-আকিদা, ইসলামি শিক্ষা ও সংস্কৃতির সুরক্ষা নিশ্চিত করার লক্ষ্যে কাজ করে। আমাদের সংগঠন সুন্নাতের অনুসরণ, শুদ্ধ ইসলামী আদর্শ প্রচার এবং সমাজে ন্যায়বিচার প্রতিষ্ঠার জন্য নিরলস প্রচেষ্টা চালিয়ে যাচ্ছে।</p>
        </div>

        <!-- Quick Links -->
        <div>
            <h2 class="mb-2 text-xl font-semibold">Quick Links</h2>
            <ul class="space-y-2">
                <li><a href="/" class="text-gray-400 hover:text-white">Home</a></li>
                <li><a href="{{ url('/about') }}" class="text-gray-400 hover:text-white">About</a></li>
                <li><a href="{{ url('/privacy') }}" class="text-gray-400 hover:text-white">Privacy</a></li>
                <li><a href="{{ url('/terms') }}" class="text-gray-400 hover:text-white">Terms</a></li>
            </ul>
        </div>

        <!-- Social Media -->
        <div>
            <h2 class="mb-2 text-xl font-semibold">Follow Us</h2>
            <div class="flex justify-center space-x-4 md:justify-start">
                <a href="#" class="text-gray-400 transition hover:text-blue-500"><i class="text-2xl fab fa-facebook"></i></a>
                <a href="#" class="text-gray-400 transition hover:text-blue-400"><i class="text-2xl fab fa-twitter"></i></a>
                <a href="#" class="text-gray-400 transition hover:text-red-500"><i class="text-2xl fab fa-youtube"></i></a>
                <a href="#" class="text-gray-400 transition hover:text-pink-500"><i class="text-2xl fab fa-instagram"></i></a>
            </div>
        </div>

    </div>

    <!-- Copyright Section -->
    <div class="pt-4 mt-6 text-sm text-center text-gray-400 border-t border-gray-700">
        &copy; {{ date('Y') }} Hifazate Islam. All Rights Reserved.
    </div>
</footer>