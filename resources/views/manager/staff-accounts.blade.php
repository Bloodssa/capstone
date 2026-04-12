<x-admin-layout title="Team Management" subtitle="Manage staff and technicians">
    <div x-data="{
        tab: $persist('list'),
        users: @js($users->items()),
        get filteredUsers() {
            // filters for tab
            if (this.tab === 'list') return this.users;
            if (this.tab === 'staff') return this.users.filter(u => u.role === 'staff');
            if (this.tab === 'tech') return this.users.filter(u => u.role === 'technician');
            return [];
        },
    }" class="space-y-6">
        <div class="flex flex-col-reverse md:flex-row items-center justify-between gap-4 mb-6 border-b border-gray-300">
            <div class="flex gap-2">
                <template x-for="t in ['list', 'staff', 'tech', 'create']">
                    <button @click="tab = t"
                        :class="tab === t ? 'border-b-2 border-neutral-900 text-neutral-900' : 'text-neutral-500'"
                        class="px-4 py-3 text-sm font-semibold capitalize transition-all"
                        x-text="t === 'tech' ? 'Technicians' : (t === 'list' ? 'Team List' : t)">
                    </button>
                </template>
            </div>
            <div class="w-full md:w-auto flex items-center" x-show="tab !== 'create'">
                <x-ui.manager.table-search :px="true" route="staff-accounts" placeholder="Search employee name or email" :dropdown="true" />
            </div>
        </div>
        <div x-show="tab === 'list'" x-cloak class="bg-white border border-gray-300 rounded-md overflow-hidden">
            <div class="overflow-x-auto">
                @php $headers = ['Name', 'Email', 'Role']; @endphp
                <x-ui.manager.table :headers="$headers" :borderTop="false" :action="true" :datas="$users">
                    <template x-for="user in filteredUsers" :key="user.id">
                        <tr class="hover:bg-gray-50">
                            <td class="table-text">
                                <div class="flex items-center space-x-2">
                                    <x-icons.avatar name="" size="sm" x-bind:name="user.name" />
                                    <span class="font-semibold" x-text="user.name"></span>
                                </div>
                            </td>
                            <td class="table-text" x-text="user.email"></td>
                            <td class="table-text capitalize" x-text="user.role">
                            </td>
                            <td class="table-text text-right">
                                <button
                                    class="text-gray-400 hover:text-gray-600 transition p-2 rounded-full hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="19" cy="12" r="1"></circle>
                                        <circle cx="5" cy="12" r="1"></circle>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </template>
                </x-ui.manager.table>
            </div>
            <div x-show="filteredUsers.length === 0" class="p-12">
                <x-ui.is-empty title="No team members found" subTitle="Try adjusting your search or add a new member in the 'Create' tab." />
            </div>
        </div>
        <div x-show="tab === 'staff' || tab === 'tech'" x-cloak class="space-y-4">
            <div class="grid md:grid-cols-2 gap-4">
                <template x-for="user in filteredUsers" :key="user.id">
                    <div class="p-4 bg-white border border-gray-300 rounded-md flex justify-between items-center">
                        <div class="flex items-center space-x-2">
                            <x-icons.avatar name="" size="sm" x-bind:name="user.name" />
                            <div>
                                <p class="font-semibold" x-text="user.name"></p>
                                <p class="font-normal tmext-neutral-500" x-text="user.email"></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-1">
                            <span class="text-sm px-2 py-1 rounded-md capitalize font-semibold bg-gray-200"
                                x-text="user.role"></span>
                            <button
                                class="text-gray-400 hover:text-gray-600 transition p-2 rounded-full hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="1"></circle>
                                    <circle cx="19" cy="12" r="1"></circle>
                                    <circle cx="5" cy="12" r="1"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
            <div x-show="filteredUsers.length === 0" class="bg-white border border-gray-300 rounded-md p-12">
                <x-ui.is-empty title="No employee found" subTitle="Try adjusting your search or add a new member in the 'Create' tab." />
            </div>
            @if ($users->hasPages())
                <div class="px-4 py-3 border-t border-gray-300 bg-gray-50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

        <div x-show="tab === 'create'" x-cloak class="bg-white border border-gray-300 rounded-md p-6">
            <h2 class="text-lg font-bold text-neutral-900 mb-6">Create New Team Member</h2>
            <form action="{{ route('create-employee') }}" method="POST" class="grid md:grid-cols-2 gap-6">
                @csrf
                <div class="space-y-1">
                    <x-forms.input-label for="name" :value="__('Name')" />
                    <x-forms.text-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" autofocus />
                    <x-forms.input-error :messages="$errors->get('name')" class="mt-1" />
                </div>
                <div class="space-y-1">
                    <x-forms.input-label for="email" :value="__('Email')" />
                    <x-forms.text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" />
                    <x-forms.input-error :messages="$errors->get('email')" class="mt-1" />
                </div>
                <div class="space-y-1">
                    <x-forms.input-label for="role" :value="__('Role')" />
                    <select id="role" name="role" class="w-full border-gray-300 rounded-md focus:ring-black focus:border-black py-2">
                        <option value="">Select Role</option>
                        <option value="staff">Staff</option>
                        <option value="technician">Technician</option>
                    </select>
                    <x-forms.input-error :messages="$errors->get('role')" class="mt-1" />
                </div>
                <div class="space-y-1">
                    <x-forms.input-label for="password" :value="__('Password')" />
                    <x-forms.text-input id="password" class="block w-full mt-1" type="password" name="password" autocomplete="new-password" />
                    <x-forms.input-error :messages="$errors->get('password')" class="mt-1" />
                </div>
                <div class="md:col-span-2 flex justify-end pt-4">
                    <button type="submit" class="px-4 py-2.5 bg-neutral-900 text-white text-sm font-semibold rounded-md hover:bg-neutral-900 transition-all">
                        Create Employee
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
