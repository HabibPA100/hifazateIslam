@php
    use App\Services\GoogleSheetsService;
@endphp

@volt
    use Livewire\WithFileUploads;
    use App\Services\GoogleSheetsService;
    use Illuminate\Support\Facades\Storage;

    public string $title = '';
    public string $description = '';
    public $image;

    public function savePost(GoogleSheetsService $googleSheets)
    {
        $this->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imageUrl = null;
        if ($this->image) {
            $imageUrl = $this->image->store('uploads', 'public');
            $imageUrl = asset('storage/' . $imageUrl);
        }

        $googleSheets->appendRow([$this->title, $this->description, $imageUrl]);

        session()->flash('message', 'Post Added Successfully!');
        $this->reset(['title', 'description', 'image']);
    }

    public function getPosts(GoogleSheetsService $googleSheets)
    {
        return $googleSheets->getRows();
    }
@endvolt

<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="mb-4 text-xl font-semibold">Create a New Post</h2>

    @if (session()->has('message'))
        <div class="p-3 mb-4 text-green-800 bg-green-300 rounded">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="savePost" class="space-y-4">
        <div>
            <label class="block text-gray-700">Title</label>
            <input type="text" wire:model="title" class="w-full px-3 py-2 border rounded">
        </div>

        <div>
            <label class="block text-gray-700">Description</label>
            <textarea wire:model="description" class="w-full px-3 py-2 border rounded"></textarea>
        </div>

        <div>
            <label class="block text-gray-700">Image</label>
            <input type="file" wire:model="image" class="w-full px-3 py-2 border rounded">
        </div>

        <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded">Submit</button>
    </form>

    <h2 class="mt-6 text-xl font-semibold">Posts</h2>
    @foreach (getPosts(resolve(App\Services\GoogleSheetsService::class)) as $post)
        <div class="p-4 bg-gray-100 rounded">
            <h3 class="text-lg font-semibold">{{ $post[0] }}</h3>
            <p>{{ $post[1] }}</p>
            @if (isset($post[2]))
                <img src="{{ $post[2] }}" class="h-20 mt-2">
            @endif
        </div>
    @endforeach
</div>
