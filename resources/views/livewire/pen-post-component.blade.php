<div>
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div>
        <!-- Modal Toggle Button -->
        <div class="flex justify-end">
            <button 
                class="px-4 py-2 text-white bg-red-700 text-xl rounded-md hover:bg-indigo-700 focus:outline-none"
                wire:click="$set('showModal', true)"
            >
               <span> নতুন কলাম লিখুন </span>
                <i class="fa-solid fa-pen-to-square"></i>
            </button>
        </div>        
    
        <!-- Modal -->
        <div 
            x-data="{ open: @entangle('showModal') }"
            x-show="open"
            @keydown.window.escape="open = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            style="display: none;"
        >
            <div class="relative w-full max-w-lg p-8 mx-auto bg-green-200 rounded-lg shadow-xl">
                <button 
                    class="absolute text-gray-500 top-4 text-2xl right-4 hover:text-gray-700"
                    @click="open = false"
                >
                    &times;
                </button>
    
                <!-- Form -->
                <form wire:submit.prevent="{{ $selectedRowIndex ? 'updatePost' : 'createPost' }}" enctype="multipart/form-data" class="space-y-6 p-6 bg-white rounded-lg shadow-xl max-w-lg mx-auto">
                    <!-- Heading Input -->
                    <div class="relative">
                        <label for="heading" class="text-gray-800 text-lg font-medium">Heading</label>
                        <input 
                            id="heading"
                            type="text" 
                            wire:model="heading" 
                            placeholder="Enter heading" 
                            required
                            class="w-full mt-2 px-4 py-3 text-lg placeholder-gray-500 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out"
                        >
                        @error('heading')
                            <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                
                    <!-- Message Textarea -->
                    <div class="relative">
                        <label for="message" class="text-gray-800 text-lg font-medium">Message</label>
                        <textarea 
                            id="message"
                            wire:model="message" 
                            placeholder="Write your message here..."
                            required
                            class="w-full h-40 mt-2 px-4 py-3 text-lg placeholder-gray-500 border border-gray-300 rounded-md resize-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out"
                        ></textarea>
                        @error('message')
                            <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                
                    <!-- Photo Upload -->
                    <div class="relative">
                        <label for="photo" class="text-gray-800 text-lg font-medium">Upload Photo</label>
                        <input 
                            id="photo"
                            type="file" 
                            wire:model="photo"
                            accept="image/*"
                            class="w-full mt-2 px-4 py-3 text-sm text-gray-600 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out"
                        >
                        <p class="mt-2 text-xs text-gray-500">Maximum file size: 10MB</p>
                
                        @if ($photo)
                            <div class="flex justify-center mt-4">
                                <img src="{{ $photo->temporaryUrl() }}" class="object-cover w-24 h-24 rounded-md shadow-md" />
                            </div>
                        @endif
                
                        @error('photo')
                            <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                
                    <!-- Submit Button -->
                    <div class="flex justify-center">
                        <button 
                            type="submit" 
                            class="w-full px-6 py-3 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 ease-in-out"
                        >
                            {{ $selectedRowIndex ? 'Update' : 'Create' }}
                            <div wire:loading>
                                <svg aria-hidden="true" role="status" class="inline w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                </svg>
                                Loading...
                            </div>
                        </button>
                    </div>
                </form>
                
                
            </div>
        </div>
    </div>
    
    <!-- Posts List -->
    <div class="p-2">
        <h3 class="mb-4 text-2xl font-semibold text-gray-800">📜 Pen Post</h3>
        <div class="grid grid-cols-1 gap-4 p-1 lg:p-6 sm:grid-cols-2 lg:grid-cols-4">
            @if (!empty($posts))
                @foreach ($posts as $index => $post)
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-lg">
                        <h2 class="mb-2 text-lg font-bold text-gray-800">{{ $post[0] ?? 'No header' }}</h2>
                        <p class="mb-3 text-gray-600">{{ $post[1] ?? 'No message' }}</p>
                        @if (!empty($post[2]))
                            <img src="{{ $post[2] }}" class="object-cover w-full h-40 mb-3 rounded-lg shadow">
                        @endif
                        <div class="flex justify-between">
                            <button wire:click="editPost({{ $index }})"
                                class="px-3 py-1 text-white transition bg-blue-500 rounded-md hover:bg-blue-700">
                                ✏️ Edit
                            </button>
                            <button wire:click="deletePost({{ $index }})"
                                class="px-3 py-1 text-white transition bg-red-500 rounded-md hover:bg-red-700"
                                onclick="return confirm('আপনি কি নিশ্চিতভাবে পোস্টটি ডিলিট করতে চান?')">
                                🗑️ Delete
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="col-span-full text-center text-gray-600">No pen post found for you!.</p>
            @endif
        </div>
    </div>
</div>
