<x-app-layout>
    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="p-4 mb-3 text-blue-700 bg-blue-100 border-l-4 border-blue-500 rounded-md">
                        ⚠️ <strong>দয়া করে নিশ্চিত হোন:</strong> আপনি যে তথ্য লিখছেন ও শেয়ার করছেন, তা সম্পূর্ণ সঠিক ও নির্ভেজাল। 
                        এই ওয়েবসাইটে শুধুমাত্র সত্য ও নির্ভরযোগ্য তথ্য প্রকাশের অনুমতি দেওয়া হয়। ভুল বা বিভ্রান্তিকর তথ্য এড়িয়ে চলুন। 
                        ধন্যবাদ আপনার সততা ও দায়িত্বশীলতার জন্য!
                    </p>
                    @if (auth()->user()->role === 'Editor')
                    <livewire:post-component />
                    @endif                    
                    <livewire:pen-post-component />
                    <livewire:fatwa-component />
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
