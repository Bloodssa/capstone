<x-admin-layout title="Account Settings" subtitle="Manage your profile and security information">
    @php $user = auth()->user();@endphp
    @if (session('status'))
        <x-ui.toast type="success" message="{{ session('status') }}" />
    @endif
    <x-slot:controls>
        <div x-data="{ profileTab: $persist('profile') }" @change-tab.window="profileTab = $event.detail"
            class="bg-white border border-gray-200 rounded-xl p-1 inline-flex gap-1">
            <button @click="$dispatch('change-tab', 'profile')"
                :class="profileTab === 'profile' ? 'bg-neutral-900 text-white' : 'bg-white hover:text-neutral-700'"
                class="flex-1 font-semibold md:flex-none text-center px-4 py-2 rounded-md">
                <span>Profile</span>
            </button>
            <button @click="$dispatch('change-tab', 'security')"
                :class="profileTab === 'security' ? 'bg-neutral-900 text-white' : 'bg-white hover:text-neutral-700'"
                class="flex-1 font-semibold md:flex-none text-center px-4 py-2 rounded-md">
                <span>Security</span>
            </button>
        </div>
    </x-slot:controls>
    <div x-data="{
        profileTab: $persist('profile'),
        init() {
            if (!['profile', 'security'].includes(this.profileTab)) {
                this.profileTab = 'profile'
            }
        }
    }" @change-tab.window="profileTab = $event.detail" class="space-y-6">
        <div x-show="profileTab === 'profile'" x-cloak class="gap-6">
            <div class="space-y-6">
                <div class="bg-white border border-gray-300 rounded-md p-6 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center space-x-3">
                            <x-icons.avatar :name="$user->name" size="lg" />
                            <div>
                                <p class="font-semibold text-md">{{ $user->name }}</p>
                                <p class="font-normal text-sm text-neutral-500">
                                    {{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white border border-gray-300 rounded-md p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
            <div class="space-y-6 mt-6">
                <div class="bg-white border border-gray-300 rounded-md p-6">
                    <h3 class="font-semibold text-sm mb-4">Account Info</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Role</span>
                            <span class="font-medium">{{ ucfirst($user->role->value) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Joined</span>
                            <span class="font-medium">
                                {{ $user->created_at->format('M d, Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Email Verified</span>
                            <span class="font-medium">
                                {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div x-show="profileTab === 'security'" x-cloak class="space-y-6">
            <div class="bg-white border border-gray-300 rounded-md p-6">
                @include('profile.partials.update-password-form')
            </div>
            <div class="bg-white border border-gray-300 rounded-md p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-admin-layout>
