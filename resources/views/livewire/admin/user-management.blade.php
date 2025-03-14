<div>
    <!-- Toaster Alert -->
    @if (session()->has('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <h2 class="mb-4 text-2xl font-bold text-center">সকল ইউজার</h2>

    <!-- ✅ Responsive Scrollable Table -->
    <div class="mx-4 overflow-x-auto">
        <table class="min-w-full overflow-hidden bg-white rounded-lg shadow-md">
            <thead class="text-white bg-gray-800">
                <tr>
                    <th class="px-4 py-2">নাম</th>
                    <th class="px-4 py-2">ইমেইল</th>
                    <th class="px-4 py-2">রোল</th>
                    <th class="px-4 py-2">অ্যাকশন</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">{{ $user->role }}</td>
                        <td class="flex px-4 py-2 space-x-2">
                            <button wire:click="editUser({{ $user->id }})" class="px-3 py-1 text-white bg-blue-500 rounded">
                                এডিট
                            </button>
                            <button wire:click="deleteUser({{ $user->id }})" class="px-3 py-1 text-white bg-red-500 rounded" onclick="return confirm('আপনি কি নিশ্চিতভাবে এই ইউজারকে ডিলিট করতে চান?')" >
                                ডিলিট
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $users->links() }}

    <!-- Edit Role Modal -->
    @if ($editMode)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <h2 class="mb-4 text-lg font-bold">রোল আপডেট করুন</h2>

                <label for="role" class="block text-gray-700">নতুন রোল</label>
                <select wire:model="role" class="w-full p-2 border rounded">
                    <option value="User">User</option>
                    <option value="Admin">Admin</option>
                    <option value="Editor">Editor</option>
                </select>

                <div class="flex justify-end mt-4 space-x-2">
                    <button wire:click="updateUserRole" class="px-4 py-2 text-white bg-green-500 rounded">
                        আপডেট
                    </button>
                    <button wire:click="$set('editMode', false)" class="px-4 py-2 text-white bg-gray-500 rounded">
                        বাতিল
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
