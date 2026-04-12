@props(['warranty', 'messages', 'haveInquiries', 'id'])

@if ($haveInquiries)
    @php
        $latestInquiry = $warranty->inquiries->last();
        $currentStatus = $status[$latestInquiry->id] ?? 0;
    @endphp

    <div class="mt-6">
        <x-ui.progress :inquiryStatus="$latestInquiry->status->value" />
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

        <x-ui.chat-box :messages="$messages" />

        <x-forms.reply :action="route('inquiry-response')" buttonText="Response" placeholder="Response to the inquiry of the user">
            <x-slot name="hiddenInputs">
                <input type="hidden" name="warranty_inquiries_id" value="{{ $latestInquiry->id }}">
            </x-slot>
        </x-forms.reply>
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
                                <input x-ref="fileInput" name="attachments[]" type="file" class="sr-only" multiple
                                    accept="image/*,.pdf" @change="handleFiles">
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
