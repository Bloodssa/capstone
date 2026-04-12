@props([
    'action',
    'buttonText' => 'Send',
    'placeholder' => 'Write a message...',
    'name' => 'message',
    'hasAvatar' => true,
])

<form action="{{ $action }}" method="POST" enctype="multipart/form-data"
    class="space-y-4 border-t border-gray-300 p-5 bg-white" x-data="{
        images: [],
        files: [],
        handleFiles(event) {
            const selectedFiles = Array.from(event.target.files)
            selectedFiles.forEach(file => {
                this.files.push(file)
                const reader = new FileReader()
                reader.onload = (e) => { this.images.push(e.target.result) }
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
            this.files.forEach(file => { dt.items.add(file) })
            this.$refs.fileInput.files = dt.files
        }
    }">

    @csrf
    {{ $hiddenInputs ?? '' }}

    <div class="flex items-start space-x-3">
        @if ($hasAvatar)
            <div class="shrink-0 mt-1">
                <x-icons.avatar :name="Auth::user()->name" size="sm" />
            </div>
        @endif

        <div class="flex-1">
            <div :class="images.length > 0 || $el.querySelector('textarea:focus') ? 'border-neutral-900' : 'border-gray-300'"
                class="border rounded-md overflow-hidden bg-white transition-colors duration-200 focus-within:border-neutral-900">

                <template x-if="images.length > 0">
                    <div class="flex gap-3 p-3 overflow-x-auto bg-neutral-50/50 border-b border-gray-200">
                        <template x-for="(img,index) in images" :key="index">
                            <div class="relative shrink-0">
                                <img :src="img"
                                    class="h-20 w-20 object-cover rounded-md border border-gray-300">
                                <button type="button" @click="removeImage(index)"
                                    class="absolute -top-1.5 -right-1.5 bg-neutral-900 text-white rounded-full p-0.5 hover:bg-neutral-800">
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

                <textarea name="{{ $name }}" rows="3" placeholder="{{ $placeholder }}"
                    class="w-full p-4 text-sm text-neutral-900 placeholder-neutral-500 border-none focus:ring-0 resize-none"></textarea>

                <div class="flex items-center justify-between px-4 py-2.5 bg-neutral-50 border-t border-gray-200">
                    <div class="flex items-center gap-2">
                        <input type="file" name="attachments[]" x-ref="fileInput" class="hidden" accept="image/*"
                            multiple @change="handleFiles">
                        <button type="button" @click="$refs.fileInput.click()"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-neutral-500 hover:text-neutral-900 hover:bg-gray-200 rounded-md transition font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-xs">Add Photos</span>
                        </button>
                    </div>

                    <button type="submit"
                        class="hidden sm:inline-flex bg-neutral-900 text-white px-6 py-1.5 rounded-md text-sm font-semibold hover:bg-neutral-800 transition">
                        {{ $buttonText }}
                    </button>
                </div>
            </div>

            <div class="sm:hidden mt-3">
                <button type="submit"
                    class="w-full bg-neutral-900 text-white py-3 rounded-md text-sm font-semibold hover:bg-neutral-800 transition">
                    {{ $buttonText }}
                </button>
            </div>

            <x-forms.input-error :messages="$errors->get($name)" class="mt-2" />
        </div>
    </div>
</form>
