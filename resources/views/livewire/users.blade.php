<div class="container mx-auto my-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    <!-- Replace with dynamic data for users -->
    @foreach ($users as $user)
        <div class="bg-white shadow-md rounded-lg p-4">
            <!-- User details example -->
            <h2 class="text-xl font-bold mb-2">{{ $user->name }}</h2>
            <p class="text-gray-600 mb-4">{{ $user->email }}</p>
            <p class="text-gray-600">ID {{ $user->id }}</p>

            <a class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" wire:navigate href="{{ route('chat', ['receiver_id' => $user->id]) }}">
                Send Message
            </a>
        </div>
    @endforeach
    <!-- Repeat the above div structure for each user -->
</div>
