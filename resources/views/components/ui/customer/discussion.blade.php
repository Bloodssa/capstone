@props(['warranty', 'messages', 'haveInquiries'])

@if ($haveInquiries)
    @php
        $status = [
            'open' => 0,
            'pending' => 1,
            'in-progress' => 2,
            'resolved' => 3,
            'replaced' => 3,
            'closed' => 3,
        ];

        $latestInquiry = $warranty->inquiries->last();
        $currentStatus = $status[$latestInquiry->status] ?? 0;

        $progress = [
            'open' => [
                'label' => 'Open',
                'path' =>
                    'M538.5-138.5Q480-197 480-280t58.5-141.5Q597-480 680-480t141.5 58.5Q880-363 880-280t-58.5 141.5Q763-80 680-80t-141.5-58.5ZM747-185l28-28-75-75v-112h-40v128l87 87Zm-547 65q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h167q11-35 43-57.5t70-22.5q40 0 71.5 22.5T594-840h166q33 0 56.5 23.5T840-760v250q-18-13-38-22t-42-16v-212h-80v120H280v-120h-80v560h212q7 22 16 42t22 38H200Zm308.5-651.5Q520-783 520-800t-11.5-28.5Q497-840 480-840t-28.5 11.5Q440-817 440-800t11.5 28.5Q463-760 480-760t28.5-11.5Z',
            ],
            'pending' => [
                'label' => 'Pending',
                'path' =>
                    'm612-292 56-56-148-148v-184h-80v216l172 172ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z',
            ],
            'processing' => [
                'label' => 'Processing',
                'path' =>
                    'M314-115q-104-48-169-145T80-479q0-26 2.5-51t8.5-49l-46 27-40-69 191-110 110 190-70 40-54-94q-11 27-16.5 56t-5.5 60q0 97 53 176.5T354-185l-40 70Zm306-485v-80h109q-46-57-111-88.5T480-800q-55 0-104 17t-90 48l-40-70q50-35 109-55t125-20q79 0 151 29.5T760-765v-55h80v220H620ZM594 0 403-110l110-190 69 40-57 98q118-17 196.5-107T800-480q0-11-.5-20.5T797-520h81q1 10 1.5 19.5t.5 20.5q0 135-80.5 241.5T590-95l44 26-40 69Z',
            ],
            'finished' => [
                'label' => 'Finished',
                'path' =>
                    'm424-296 282-282-56-56-226 226-114-114-56 56 170 170Zm56 216q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z',
            ],
        ];
    @endphp

    <div class="bg-white border border-gray-300 rounded-md py-6 mt-6">
        <div class="flex items-center justify-between max-w-4xl mx-auto relative">
            @foreach ($progress as $key => $prog)
                <div class="flex flex-col items-center z-10">
                    <div
                        class="w-14 h-14 rounded-full flex items-center justify-center border 
                            {{ $currentStatus >= $loop->index ? 'bg-neutral-900 border-neutral-500' : 'bg-white border-gray-300' }}">
                        <svg class="w-7 h-7 {{ $currentStatus >= $loop->index ? 'text-white' : 'text-gray-400' }}"
                            viewBox="0 -960 960 960" fill="currentColor">
                            <path d="{{ $prog['path'] }}" />
                        </svg>
                    </div>
                    <p
                        class="mt-2 text-sm font-semibold {{ $currentStatus >= $loop->index ? 'text-neutral-900' : 'text-neutral-500' }}">
                        {{ $prog['label'] }}
                    </p>
                </div>
                @if (!$loop->last)
                    <div class="flex-1 h-0.5 mx-2 bg-gray-300 relative -top-3">
                        <div
                            class="h-full bg-neutral-900 transition-all duration-300 {{ $currentStatus > $loop->index ? 'w-full' : 'w-0' }}">
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div
        class="lg:col-span-2 mt-6 flex flex-col bg-white border border-gray-300 rounded-md min-h-170 max-h-300 overflow-hidden">
        <div class="px-2 py-4 border-b border-gray-300">
            <div class="flex items-center gap-4 px-5">
                <div class="shrink-0">
                    <img class="h-16 w-16 object-contain border border-gray-300 rounded bg-white"
                        src="{{ asset('storage/' . $warranty->product->product_image_url) }}"
                        alt="{{ $warranty->product->name }}" />
                </div>
                <div class="min-w-0">
                    <p class="text-md font-bold text-neutral-900">
                        {{ $warranty->product->name }} Inquiry Discussion
                    </p>
                    <p class="text-sm text-neutral-500">Serial Number: {{ $warranty->serial_number }}</p>
                </div>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-5 space-y-4 bg-white">
            @foreach ($messages as $msg)
                @php
                    $isCustomer = $msg->type === 'message' && $msg->user?->id === auth()->id();
                @endphp

                @if ($msg->type === 'updates')
                    <div class="relative flex items-center justify-center my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative bg-white px-4 flex flex-col items-center text-center">
                            <span class="text-sm font-semibold text-neutral-500">
                                {{ $msg->message }}
                            </span>
                            <span class="text-xs text-neutral-400 mt-0.5">
                                {{ $msg->created_at->format('M d, g:i A') }}
                            </span>
                        </div>
                    </div>
                @elseif ($msg->type === 'solution')
                    <div class="my-10 flex justify-center px-4">
                        <div class="max-w-md w-full border border-gray-300 rounded-md p-6 bg-white">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-neutral-900 rounded-md text-white">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-neutral-900">Inquiry
                                        {{ $msg->status }}</h3>
                                    <p class="text-xs text-neutral-500">{{ $msg->created_at->format('F j, Y') }}</p>
                                </div>
                            </div>
                            <div class="text-sm text-neutral-900 font-medium">
                                "{{ $msg->message }}"
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-300 flex justify-between items-center">
                                <span class="text-sm font-semibold text-neutral-500">{{ $msg->user->name }}</span>
                                <x-icons.badge type="{{ $msg->status }}" size="sm">
                                    {{ $msg->status }}
                                </x-icons.badge>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex {{ $isCustomer ? 'justify-end' : 'justify-start' }}">
                        <div class="flex items-end gap-2 {{ $isCustomer ? 'flex-row-reverse' : 'items-start' }}">
                            @if (!$isCustomer)
                                <div class="shrink-0">
                                    <x-icons.avatar :name="$msg->user->name" size="sm" />
                                </div>
                            @endif

                            <div class="flex flex-col {{ $isCustomer ? 'items-end' : 'items-start' }}">
                                <div
                                    class="p-2 rounded-md text-sm max-w-md wrap-break-word {{ $isCustomer ? 'bg-neutral-900 text-white' : 'bg-gray-100 text-neutral-900' }}">
                                    {{ $msg->message }}
                                </div>

                                @isset($msg->attachments)
                                    <div
                                        class="flex flex-wrap max-w-100 gap-1 mt-2 {{ $isCustomer ? 'justify-end' : 'justify-start' }}">
                                        @foreach ($msg->attachments as $index => $path)
                                            <a href="{{ asset('storage/' . $path) }}" class="glightbox"
                                                data-gallery="msg-{{ $loop->parent->index ?? $loop->index }}"
                                                data-title="Attachment {{ $index + 1 }}">
                                                <img src="{{ asset('storage/' . $path) }}"
                                                    class="h-24 w-24 object-cover rounded-md border border-gray-200 hover:opacity-80 transition">
                                            </a>
                                        @endforeach
                                    </div>
                                @endisset
                                
                                <span class="text-xs text-gray-500 mt-1">
                                    @if ($msg->created_at->greaterThan(now()->subDay()))
                                        {{ $msg->created_at->diffForHumans() }}
                                    @else
                                        {{ $msg->created_at->format('F j, Y, g:i a') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <x-ui.reply :action="route('inquiry-response')" buttonText="Response" placeholder="Response to the inquiry of the user">
            <x-slot name="hiddenInputs">
                <input type="hidden" name="warranty_inquiries_id" value="{{ $warranty->id }}">
            </x-slot>
        </x-ui.reply>
    </div>
@else
    <div class="mx-auto mt-8">
        <div>
            <form action="{{ route('inquire-warranty') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="warranty_id" value="{{ $warranty->id }}">

                <div class="bg-white border border-gray-300 rounded-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-300 bg-white">
                        <h2 class="text-xl font-semibold text-neutral-900">New Warranty Inquiry</h2>
                    </div>

                    <div class="p-6 space-y-8">
                        <div>
                            <label for="message" class="block text-md font-semibold text-neutral-900 mb-2">
                                Describe the issue of your purchased product
                            </label>
                            <textarea name="message" id="message" rows="6"
                                class="block w-full rounded-md border-gray-300 focus:ring-1 focus:ring-neutral-900 focus:border-neutral-900 sm:text-sm placeholder-gray-400"
                                placeholder="Please detail the problem you are experiencing..."></textarea>
                            @error('message')
                                <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div x-data="{
                            images: [],
                            files: [],
                            handleFiles(event) {
                                const selectedFiles = Array.from(event.target.files)
                        
                                selectedFiles.forEach(file => {
                                    this.files.push(file)
                        
                                    const reader = new FileReader()
                                    reader.onload = (e) => {
                                        this.images.push({
                                            src: e.target.result,
                                            type: file.type
                                        })
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
                            <label for="message" class="block text-md font-semibold text-neutral-900 mb-2">
                                Attachments<span class="text-neutral-500 text-sm font-normal"> (Images)</span>
                            </label>
                            <div class="relative group border-2 border-dashed border-gray-300 rounded-md p-8 transition-all hover:border-neutral-900 hover:bg-neutral-50 cursor-pointer"
                                @click="$refs.fileInput.click()">
                                <div class="text-center space-y-2">
                                    <svg class="mx-auto h-10 w-10 text-neutral-500 group-hover:text-neutral-900 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-sm text-neutral-600 font-medium">
                                        Click to select files or drag and drop
                                    </p>
                                    <p class="text-xs text-neutral-400">
                                        PNG, JPG, JPEG (Max 10 images)
                                    </p>
                                </div>
                                <input x-ref="fileInput" name="attachments[]" type="file" class="sr-only"
                                    multiple accept="image/*,.pdf" @change="handleFiles">
                            </div>

                            <template x-if="images.length > 0">
                                <div class="mt-4 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
                                    <template x-for="(file, index) in images" :key="index">
                                        <div class="relative group">
                                            <template x-if="file.type.startsWith('image/')">
                                                <img :src="file.src"
                                                    class="h-24 w-full object-cover rounded-md border border-gray-200">
                                            </template>
                                            <button type="button" @click="removeImage(index)"
                                                class="absolute -top-1.5 -right-1.5 bg-neutral-900 text-white rounded-full p-0.5 hover:bg-neutral-800 shadow">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                        @if ($errors->has('attachments') || $errors->has('attachments.*'))
                            <div class="mt-2 space-y-1">
                                @foreach ($errors->get('attachments') as $message)
                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                @endforeach
                                @foreach ($errors->get('attachments.*') as $messages)
                                    @foreach ($messages as $message)
                                        <p class="text-red-500 text-xs">{{ $message }}</p>
                                    @endforeach
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="px-6 py-4 flex items-center justify-end gap-3">
                    <button @click="activeTab = 'records'"
                        :class="activeTab === 'records' ? 'bg-neutral-900 text-white' : 'bg-white hover:text-neutral-700'"
                        class="flex-1 font-semibold md:flex-none text-center px-4 py-2 rounded-md">
                        Cancel
                    </button>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2.5 bg-neutral-900 text-white text-sm font-bold rounded-md hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-900 transition-all">
                        Submit Inquiry
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif

<link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>
    const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
        zoomable: true,
    });
</script>
