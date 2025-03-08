<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- component -->
                <div class="flex h-screen antialiased text-gray-800">
                    <div class="flex flex-row h-full w-full overflow-x-hidden">


                        {{-- chat list start --}}
                        <div class="flex flex-col py-8 pl-6 pr-2 w-64 bg-white flex-shrink-0">


                            {{-- auth profile start --}}
                            <div class="flex flex-row items-center justify-center h-12 w-full">
                                <div
                                    class="flex items-center justify-center rounded-2xl text-indigo-700 bg-indigo-100 h-10 w-10">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="ml-2 font-bold text-2xl">QuickChat</div>
                            </div>

                            <div
                                class="flex flex-col items-center bg-indigo-100 border border-gray-200 mt-4 w-full py-6 px-4 rounded-lg">
                                <div class="h-20 w-20 rounded-full border overflow-hidden">
                                    <img src="https://avatars3.githubusercontent.com/u/2763884?s=128" alt="Avatar"
                                        class="h-full w-full" />
                                </div>
                                <div class="text-sm font-semibold mt-2">Aminos Co.</div>
                                <div class="text-xs text-gray-500">Lead UI/UX Designer</div>
                                <div class="flex flex-row items-center mt-3">
                                    <div class="flex flex-col justify-center h-4 w-8 bg-indigo-500 rounded-full">
                                        <div class="h-3 w-3 bg-white rounded-full self-end mr-1"></div>
                                    </div>
                                    <div class="leading-none ml-1 text-xs">Active</div>
                                </div>
                            </div>
                            {{-- auth profile end --}}




                            <div class="flex flex-col mt-8">
                                <div class="flex flex-row items-center justify-between text-xs">
                                    <span class="font-bold">Active Conversations</span>
                                    <span
                                        class="flex items-center justify-center bg-gray-300 h-4 w-4 rounded-full">4</span>
                                </div>



                                {{-- chat list start --}}
                                <div class="flex flex-col space-y-1 mt-4 -mx-2 h-48 overflow-y-auto"
                                    x-data="{ receiver_id: {{ request()->query('receiver_id') ? request()->query('receiver_id') : 'false' }} }">

                                    @if (!is_null($all_user_lists) && count($all_user_lists) > 0)
                                        @foreach ($all_user_lists as $item)
                                            <a wire:navigate
                                                href="{{ route('chat', ['receiver_id' => $item->receiver->id]) }}"
                                                class="flex flex-row items-center hover:bg-gray-100 rounded-xl p-2"
                                                x-bind:class="{ 'bg-gray-100': receiver_id == {{ $item->receiver->id }} }">
                                                <div
                                                    class="flex items-center justify-center h-8 w-8 bg-gray-200 rounded-full">
                                                    {{ substr($item->receiver->name, 0, 1) }}
                                                </div>
                                                <div class="ml-2 text-sm font-semibold">{{ $item->receiver->name }}
                                                </div>
                                                @php
                                                    $unread_msg_count = App\Models\Message::getUnreadMessagesCount(
                                                        $item->receiver->id,
                                                    );
                                                @endphp
                                                @if ($unread_msg_count > 0)
                                                    <div
                                                        class="flex items-center justify-center ml-auto text-xs text-white bg-red-500 h-4 w-4 rounded leading-none">
                                                        {{ $unread_msg_count }}
                                                    </div>
                                                @endif
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                                {{-- chat list end --}}





                                {{-- archive chat start --}}
                                <div class="flex flex-row items-center justify-between text-xs mt-6">
                                    <span class="font-bold">Archivied</span>
                                    <span
                                        class="flex items-center justify-center bg-gray-300 h-4 w-4 rounded-full">7</span>
                                </div>
                                <div class="flex flex-col space-y-1 mt-4 -mx-2">
                                    <button class="flex flex-row items-center hover:bg-gray-100 rounded-xl p-2">
                                        <div
                                            class="flex items-center justify-center h-8 w-8 bg-indigo-200 rounded-full">
                                            H
                                        </div>
                                        <div class="ml-2 text-sm font-semibold">Henry Boyd</div>
                                    </button>
                                </div>
                                {{-- archive chat end --}}




                            </div>
                        </div>
                        {{-- chat list end --}}




                        {{-- conversation div start --}}
                        <div class="flex flex-col flex-auto h-full p-6">
                            <h2 class=" text-center">{{ $current_receiver_user?->name }}</h2>
                            <div id="conversation_container"
                                class="flex flex-col flex-auto flex-shrink-0 rounded-2xl bg-gray-100 h-full p-4">

                                <div class="flex flex-col h-full overflow-x-auto mb-4">
                                    <div class="flex flex-col h-full">


                                        <div class="grid grid-cols-12 gap-y-2">

                                            @if (count($all_conversations) > 0)
                                                @foreach ($all_conversations as $key => $item)
                                                    @if ($item['sender_id'] !== auth()->user()->id)
                                                        {{-- receiver conversation start --}}
                                                        <div class="col-start-1 col-end-8 p-3 rounded-lg">
                                                            <div class="flex flex-row items-center">
                                                                <div
                                                                    class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0 text-white">
                                                                    {{ ucwords(substr(App\Models\User::getSenderNameBySenderId($item['sender_id']), 0, 1)) }}
                                                                </div>
                                                                <div
                                                                    class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                                                                    <div>{{ $item['message'] }}</div>
                                                                </div>
                                                            </div>

                                                            <img src="{{ asset('./storage/' . $item['file']) }}"
                                                                alt="">


                                                        </div>
                                                        {{-- receiver conversation end --}}
                                                    @else
                                                        {{-- sender conversation start --}}
                                                        <div class="col-start-6 col-end-13 p-3 rounded-lg">
  
                                                            @if (!empty($item['file']))
                                                                <div class="my-2">
                                                                    <img src="{{ asset('./storage/' . $item['file']) }}"
                                                                        alt="">
                                                                </div>
                                                            @endif

                                                            <div
                                                                class="flex items-center justify-start flex-row-reverse">
                                                                <div
                                                                    class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0 text-white">
                                                                    {{ ucwords(substr(App\Models\User::getSenderNameBySenderId($item['sender_id']), 0, 1)) }}
                                                                </div>
                                                                <div
                                                                    class="relative mr-3 text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl">
                                                                    <div>{{ $item['message'] }}</div>
                                                                </div>
                                                            </div>
                                                          
                                                        </div>
                                                        {{-- sender conversation end --}}
                                                    @endif
                                                @endforeach

                                            @endif




                                            {{--
                            <div class="col-start-1 col-end-8 p-3 rounded-lg">
                                <div class="flex flex-row items-center">
                                    <div
                                        class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0">
                                        A
                                    </div>
                                    <div class="relative ml-3 text-sm bg-white py-2 px-4 shadow rounded-xl">
                                        <div class="flex flex-row items-center">
                                            <button
                                                class="flex items-center justify-center bg-indigo-600 hover:bg-indigo-800 rounded-full h-8 w-10">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <div class="flex flex-row items-center space-x-px ml-4">
                                                <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-4 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-8 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-8 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-10 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-10 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-12 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-10 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-6 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-5 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-4 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-3 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-10 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-10 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-8 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-8 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-1 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-1 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-8 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-8 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-2 w-1 bg-gray-500 rounded-lg"></div>
                                                <div class="h-4 w-1 bg-gray-500 rounded-lg"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}


                                        </div>
                                    </div>
                                </div>





                                {{-- typing indecator start --}}
                                <div class="ticontainer pe-4 flex justify-end" style="display: none;">
                                    <div class="tiblock">
                                        <div class="tidot"></div>
                                        <div class="tidot"></div>
                                        <div class="tidot"></div>
                                    </div>
                                </div>
                                {{-- typing indecator end --}}


                                {{-- message form start --}}
                                <div x-data="{ visible: {{ request()->query('receiver_id') ? 'true' : 'false' }} }" x-cloak>
                                    <form x-show="visible" wire:submit.prevent="sendMessage"
                                        class="flex flex-row items-center h-16 rounded-xl bg-white w-full px-4">


                                        @if ($file)

                                            @php
                                                $is_type_image = str_starts_with($file->getMimeType(), 'image/')
                                                    ? true
                                                    : false;
                                            @endphp

                                            @if ($is_type_image)
                                                <div class="relative">
                                                    <img src="{{ $file->temporaryUrl() }}" alt=""
                                                        class="w-12 h-12 me-3">
                                                    <button type="button" wire:click='removeImage'
                                                        class=" text-xl text-red-500 absolute top-[-5px] left-1">x</button>
                                                </div>
                                            @else
                                                <div class=" flex items-center">
                                                    <button type="button" wire:click='removeImage'
                                                        class=" text-xl text-red-500 mb-1 me-1">x</button>
                                                    <span>{{ $file->getClientOriginalName() }}</span>

                                                </div>
                                            @endif



                                        @endif


                                        <div x-data>

                                            {{-- file --}}
                                            <input type="file" class="hidden" wire:model='file' name=""
                                                id="file">
                                            <button type="button" @click="document.getElementById('file').click()"
                                                class="flex items-center justify-center text-gray-400 hover:text-gray-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>



                                        <div class="flex-grow ml-4">
                                            <div class="relative w-full">
                                                {{-- message field start --}}
                                                <input wire:keydown='userTyping' type="text"
                                                    wire:model.defer="text"
                                                    class="flex w-full border rounded-xl focus:outline-none focus:border-indigo-300 pl-4 h-10"
                                                    placeholder="Enter new message" />

                                                <button
                                                    class="absolute flex items-center justify-center h-full w-12 right-0 top-0 text-gray-400 hover:text-gray-600">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <div>
                                                    @error('text')
                                                        <span class="error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <button type="submit"
                                                class="flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded-xl text-white px-4 py-1 flex-shrink-0">
                                                <span>Send</span>
                                                <span class="ml-2">
                                                    <svg class="w-4 h-4 transform rotate-45 -mt-px" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </button>
                                        </div>
                                    </form>

                                    <div x-show="!visible">
                                        <h1 class=" text-center font-bold">Select User First</h1>
                                    </div>
                                </div>
                                {{-- message form end --}}



                            </div>
                        </div>
                        {{-- conversation div end --}}



                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<script type="module">
    let timeout = null;
    window.Echo.private(`chat-typing-channel.{{ $sender_id }}`).listen('UserTypingEvent', (event) => {

        let typingIndicator = document.querySelector('.ticontainer');
        if (typingIndicator) {
            typingIndicator.style.display = 'block';

            clearTimeout(timeout);
            timeout = setTimeout(() => {
                typingIndicator.style.display = 'none';
            }, 2000);
        }

    });



    let chatContainer = document.getElementById('conversation_container');

    function scrollToBottom() {
        if (chatContainer) {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    }

    Livewire.on('message-updated', function() {
        setTimeout(scrollToBottom, 100); // Ensure DOM updates first
    });

    // Ensure chat scrolls to the bottom on page load
    window.addEventListener('load', scrollToBottom);
</script>
