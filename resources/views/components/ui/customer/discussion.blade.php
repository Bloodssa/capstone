<div class="w-full rounded-md border overflow-hidden border-gray-300 bg-white oveflow-hidden">
    <div class="px-6 border-b py-4 border-gray-300 flex justify-between items-center">
        <h1 class="text-neutral-900 font-semibold">Support Discussion</h1>
        <a href=""
            class="group font-semibold flex items-center justify-center text-sm text-neutral-500 hover:underline hover:text-neutral-900">
            <span>View All</span><svg class="w-3.5 h-3.5 rtl:rotate-180 text-neutral-500" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m9 5 7 7-7 7" />
            </svg></a>
    </div>

    <div class="p-6 space-y-6 max-h-130 overflow-y-auto">
        {{-- Auth Comment --}}
        @forelse ($warranty->inquiries as $inquiry)
            <div class="space-y-8" x-data="{ replyInput: false }">
                <div class="space-y-5">
                    <div class="flex gap-4">
                        <x-icons.avatar :name="$inquiry->user->name" />

                        <div class="space-y-1 max-w-[85%] md:max-w-[90%]">
                            <div class="flex items-center gap-2">
                                <span
                                    class="text-sm font-semibold text-neutral-900">{{ $inquiry->user->name ?? 'Guest' }}</span>
                                <span
                                    class="text-xs text-neutral-500">{{ $inquiry->created_at->diffForHumans() }}</span>
                            </div>
                            <p
                                class="w-max max-w-full text-sm text-gray-700 bg-white p-3 rounded-md border border-gray-300">
                                {{ $inquiry->message }}
                            </p>
                            @if ($inquiry->attachments)
                                <div class="flex gap-2 flex-wrap">
                                    @foreach ($inquiry->attachments as $path)
                                        <a href="{{ asset('storage/' . $path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $path) }}"
                                                class="h-30 w-30 object-cover rounded border border-gray-200 hover:opacity-80 transition">
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                            <span @click="replyInput = !replyInput"
                                class="ml-3 text-sm text-neutral-500 hover:text-neutral-900 hover:underline cursor-pointer">Reply</span>
                            <form x-show="replyInput" action="{{ route('inquiry-response') }}" method="POST"
                                class="space-y-2 mt-4 ml-3">
                                @csrf
                                <input type="hidden" name="warranty_inquiries_id" value="{{ $inquiry->id }}" />
                                <x-forms.text-input id="message" name="message" class="w-full"
                                    placeholder="Reply message" />
                                <x-forms.input-error :messages="$errors->get('message')" class="mt-2" />

                                <x-ui.primary-button class="w-full sm:w-auto justify-center whitespace-nowrap">
                                    {{ __('Send Reply') }}
                                </x-ui.primary-button>
                            </form>
                        </div>
                    </div>
                    @foreach ($inquiry->responses as $reply)
                        <div class="flex gap-4 ml-12">
                            <x-icons.avatar :name="$reply->user->name" />
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-semibold text-neutral-900">{{ $reply->user->name }}</span>
                                    <span
                                        class="text-xs text-neutral-500">{{ $reply->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-md border border-gray-200">
                                    {{ $reply->message }}
                                </p>
                                @if ($reply->attachments)
                                    <div class="flex gap-2 flex-wrap">
                                        @foreach ($reply->attachments as $path)
                                            <a href="{{ asset('storage/' . $path) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $path) }}"
                                                    class="h-30 w-30 object-cover rounded border border-gray-200 hover:opacity-80 transition">
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                                <span @click="replyInput = !replyInput"
                                    class="ml-3 text-sm text-neutral-500 hover:text-neutral-900 hover:underline cursor-pointer">Reply</span>
                                <form x-show="replyInput" action="{{ route('inquiry-response') }}" method="POST"
                                    class="space-y-2 mt-4 ml-3">
                                    @csrf
                                    <input type="hidden" name="warranty_inquiries_id" value="{{ $inquiry->id }}" />
                                    <x-forms.text-input id="message" name="message" class="w-full"
                                        placeholder="Reply message" />
                                    <x-forms.input-error :messages="$errors->get('message')" class="mt-2" />

                                    <x-ui.primary-button class="w-full sm:w-auto justify-center whitespace-nowrap">
                                        {{ __('Send Reply') }}
                                    </x-ui.primary-button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-center text-neutral-500 py-4">No Inquiries Available</p>
        @endforelse
    </div>

    <form action="{{ route('inquire-warranty') }}" method="POST" enctype="multipart/form-data"
        class="space-y-4 border-t border-gray-300 p-5 bg-gray-50/30" x-data="{
            images: [],
            files: [],
            handleFiles(event) {
                const selectedFiles = Array.from(event.target.files)
        
                selectedFiles.forEach(file => {
                    this.files.push(file)
        
                    const reader = new FileReader()
                    reader.onload = (e) => {
                        this.images.push(e.target.result)
                    }
        
                    reader.readAsDataURL(file)
                })
        
                this.syncFiles()
            },
            removeImage(index) {
                this.images.splice(index, 1)
                this.files.splice(index, 1)
                this.syncFiles()
            },
            syncFiles() {
                const dt = new DataTransfer()
        
                this.files.forEach(file => {
                    dt.items.add(file)
                })
        
                this.$refs.fileInput.files = dt.files
            }
        }">
        <input type="hidden" name="warranty_id" value="{{ $warranty->id }}">
        @csrf

        <div class="flex items-start space-x-3">
            <div class="shrink-0 mt-1">
                <x-icons.avatar :name="Auth::user()->name" />
            </div>

            <div class="flex-1">
                <div :class="images.length > 0 || $el.querySelector('textarea:focus') ? 'border-neutral-900' : 'border-gray-300'"
                    class="border rounded-md overflow-hidden bg-white transition-colors duration-200 focus-within:border-neutral-900">

                    <template x-if="images.length > 0">
                        <div class="flex gap-3 p-3 overflow-x-auto">
                            <template x-for="(img,index) in images" :key="index">
                                <div class="relative shrink-0">
                                    <img :src="img"
                                        class="h-20 w-20 object-cover rounded-md border border-gray-300">

                                    <button type="button" @click="removeImage(index)"
                                        class="absolute -top-1.5 -right-1.5 bg-neutral-900 text-white rounded-full p-0.5 hover:bg-neutral-800 shadow">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </template>

                    <textarea name="message" rows="3" placeholder="Describe the issue of your purchased product..."
                        class="w-full p-4 text-sm text-neutral-900 placeholder-neutral-400 border-none focus:ring-0 resize-none"></textarea>

                    <div class="flex items-center justify-between px-4 py-2.5 bg-neutral-50 border-t border-gray-300">
                        <div class="flex items-center gap-2">
                            <input type="file" name="attachments[]" x-ref="fileInput" class="hidden"
                                accept="image/*" multiple @change="handleFiles">
                            <button type="button" @click="$refs.fileInput.click()"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-neutral-500 hover:text-neutral-900 hover:bg-gray-200 rounded-md transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs font-semibold">Add Photos</span>
                            </button>
                        </div>
                    </div>
                </div>
                <x-forms.input-error :messages="$errors->get('message')" class="mt-2" />
            </div>
        </div>

        <div class="flex justify-end">
            <x-ui.primary-button class="w-full sm:w-auto px-10">
                Report Issue
            </x-ui.primary-button>
        </div>

    </form>
</div>
