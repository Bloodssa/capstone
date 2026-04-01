<aside 
    class="fixed left-0 top-0 z-50 h-screen w-60 flex flex-col bg-white border-r border-gray-300 transition-transform duration-300 ease-in-out"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
>
    <div class="sticky top-0 z-10 flex items-center h-19 px-6 border-b border-gray-300 bg-white shrink-0">
        <x-icons.logo size="w-40" />
    </div>

    <div class="flex flex-col overflow-y-auto no-scrollbar flex-1">
        <nav class="px-4 py-6">
            <h3 class="mb-4 ml-2 text-md font-semibold text-neutral-900 text-[15px]">Warranty Management</h3>
            <ul class="flex flex-col gap-1.5 -mt-2">
                <li>
                    <x-ui.manager-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        <svg fill="currentColor"
                            class="w-5 h-5 transition-colors {{ request()->routeIs('dashboard') ? 'text-neutral-900' : 'text-neutral-500 group-hover:text-neutral-900' }}"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        Dashboard
                    </x-ui.manager-link>
                </li>
                <li>
                    <x-ui.manager-link href="{{ route('register-warranty') }}" :active="request()->routeIs('register-warranty')">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"
                            class="w-5 h-5 transition-colors {{ request()->routeIs('register-warranty') ? 'text-neutral-900' : 'text-neutral-500 group-hover:text-neutral-900' }}"
                            fill="currentColor" stroke="currentColor">
                            <path
                                d="M183.5-183.5Q160-207 160-240t23.5-56.5Q207-320 240-320t56.5 23.5Q320-273 320-240t-23.5 56.5Q273-160 240-160t-56.5-23.5Zm0-240Q160-447 160-480t23.5-56.5Q207-560 240-560t56.5 23.5Q320-513 320-480t-23.5 56.5Q273-400 240-400t-56.5-23.5Zm0-240Q160-687 160-720t23.5-56.5Q207-800 240-800t56.5 23.5Q320-753 320-720t-23.5 56.5Q273-640 240-640t-56.5-23.5Zm240 0Q400-687 400-720t23.5-56.5Q447-800 480-800t56.5 23.5Q560-753 560-720t-23.5 56.5Q513-640 480-640t-56.5-23.5Zm240 0Q640-687 640-720t23.5-56.5Q687-800 720-800t56.5 23.5Q800-753 800-720t-23.5 56.5Q753-640 720-640t-56.5-23.5Zm-240 240Q400-447 400-480t23.5-56.5Q447-560 480-560t56.5 23.5Q560-513 560-480t-23.5 56.5Q513-400 480-400t-56.5-23.5ZM520-160v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-380L643-160H520Zm300-263-37-37 37 37ZM580-220h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z" />
                        </svg>
                        Register Warranty
                    </x-ui.manager-link>
                </li>

                <li>
                    <x-ui.manager-link href="{{ route('active-warranties') }}" :active="request()->routeIs('active-warranties')  ">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"
                            class="w-5 h-5 transition-colors {{ request()->routeIs('active-warranties') ? 'text-neutral-900' : 'text-neutral-500 group-hover:text-neutral-900' }}"
                            fill="currentColor">
                            <path
                                d="M200-200v-560 454-85 191Zm0 80q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v320h-80v-320H200v560h280v80H200Zm494 40L552-222l57-56 85 85 170-170 56 57L694-80ZM348.5-451.5Q360-463 360-480t-11.5-28.5Q337-520 320-520t-28.5 11.5Q280-497 280-480t11.5 28.5Q303-440 320-440t28.5-11.5Zm0-160Q360-623 360-640t-11.5-28.5Q337-680 320-680t-28.5 11.5Q280-657 280-640t11.5 28.5Q303-600 320-600t28.5-11.5ZM440-440h240v-80H440v80Zm0-160h240v-80H440v80Z" />
                        </svg>
                        Active Warranties
                    </x-ui.manager-link>
                </li>
                <li>
                    <x-ui.manager-link href="{{ route('warranty-inquiries') }}" :active="request()->routeIs('warranty-inquiries', 'inquiry-action')">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"    
                            class="w-5 h-5 transition-colors {{ request()->routeIs('warranty-inquiries', 'inquiry-action') ? 'text-neutral-900' : 'text-neutral-500 group-hover:text-neutral-900' }}"
                            fill="currentColor">
                            <path
                                d="M280-720v-40q0-33 23.5-56.5T360-840h240q33 0 56.5 23.5T680-760v40h28q24 0 43.5 13.5T780-672l94 216q3 8 4.5 16t1.5 16v184q0 33-23.5 56.5T800-160H160q-33 0-56.5-23.5T80-240v-184q0-8 1.5-16t4.5-16l94-216q9-21 28.5-34.5T252-720h28Zm80 0h240v-40H360v40Zm-80 240v-40h80v40h240v-40h80v40h96l-68-160H252l-68 160h96Zm0 80H160v160h640v-160H680v40h-80v-40H360v40h-80v-40Zm200-40Zm0-40Zm0 80Z" />
                        </svg>
                        Warranty Inquiries
                    </x-ui.manager-link>
                </li>
            </ul>

            <hr class="my-3 border-gray-300">
            <h3 class="mb-4 ml-2 text-md font-semibold text-neutral-900 text-[15px]">Resources</h3>

            <ul class="flex flex-col gap-1 -mt-2">
                <li>
                    <x-ui.manager-link href="{{ route('add-product') }}" :active="request()->routeIs('add-product')">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"
                            class="w-5 h-5 transition-colors {{ request()->routeIs('add-product') ? 'text-neutral-900' : 'text-neutral-500 group-hover:text-neutral-900' }}"
                            fill="currentColor">
                            <path
                                d="M160-120q-33 0-56.5-23.5T80-200v-560q0-33 23.5-56.5T160-840h560q33 0 56.5 23.5T800-760v80h80v80h-80v80h80v80h-80v80h80v80h-80v80q0 33-23.5 56.5T720-120H160Zm0-80h560v-560H160v560Zm80-80h200v-160H240v160Zm240-280h160v-120H480v120Zm-240 80h200v-200H240v200Zm240 200h160v-240H480v240ZM160-760v560-560Z" />
                        </svg>
                        Products
                    </x-ui.manager-link>
                </li>
                <li>
                    <x-ui.manager-link href="{{ route('customers') }}" :active="request()->routeIs('customers')">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"
                            class="w-5 h-5 transition-colors {{ request()->routeIs('customers') ? 'text-neutral-900' : 'text-neutral-500 group-hover:text-neutral-900' }}"
                            fill="currentColor">
                            <path
                                d="M555-435q-35-35-35-85t35-85q35-35 85-35t85 35q35 35 35 85t-35 85q-35 35-85 35t-85-35ZM400-160v-76q0-21 10-40t28-30q45-27 95.5-40.5T640-360q56 0 106.5 13.5T842-306q18 11 28 30t10 40v76H400Zm86-80h308q-35-20-74-30t-80-10q-41 0-80 10t-74 30Zm182.5-251.5Q680-503 680-520t-11.5-28.5Q657-560 640-560t-28.5 11.5Q600-537 600-520t11.5 28.5Q623-480 640-480t28.5-11.5ZM640-520Zm0 280ZM120-400v-80h320v80H120Zm0-320v-80h480v80H120Zm324 160H120v-80h360q-14 17-22.5 37T444-560Z" />
                        </svg>
                        Customers
                    </x-ui.manager-link>
                </li>
                <li>
                    <x-ui.manager-link href="{{ route('reports') }}" :active="request()->routeIs('reports')">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"
                            class="w-5 h-5 transition-colors {{ request()->routeIs('reports') ? 'text-neutral-900' : 'text-neutral-500 group-hover:text-neutral-900' }}"
                            fill="currentColor">
                            <path
                                d="M280-280h80v-200h-80v200Zm320 0h80v-400h-80v400Zm-160 0h80v-120h-80v120Zm0-200h80v-80h-80v80ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z" />
                        </svg>
                        Reports
                    </x-ui.manager-link>
                </li>
            </ul>

            <hr class="my-3 border-gray-300">
            <h3 class="mb-4 ml-2 text-md font-semibold text-neutral-900 text-[15px]">Administration</h3>

            <ul class="flex flex-col gap-1 -mt-2">
                <li>
                    <x-ui.manager-link href="{{ route('staff-accounts') }}" :active="request()->routeIs('staff-accounts')">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"
                            class="w-5 h-5 transition-colors {{ request()->routeIs('staff-accounts') ? 'text-neutral-900' : 'text-neutral-500 group-hover:text-neutral-900' }}"
                            fill="currentColor">
                            <path
                                d="M440-120v-80h320v-284q0-117-81.5-198.5T480-764q-117 0-198.5 81.5T200-484v244h-40q-33 0-56.5-23.5T80-320v-80q0-21 10.5-39.5T120-469l3-53q8-68 39.5-126t79-101q47.5-43 109-67T480-840q68 0 129 24t109 66.5Q766-707 797-649t40 126l3 52q19 9 29.5 27t10.5 38v92q0 20-10.5 38T840-249v49q0 33-23.5 56.5T760-120H440ZM331.5-411.5Q320-423 320-440t11.5-28.5Q343-480 360-480t28.5 11.5Q400-457 400-440t-11.5 28.5Q377-400 360-400t-28.5-11.5Zm240 0Q560-423 560-440t11.5-28.5Q583-480 600-480t28.5 11.5Q640-457 640-440t-11.5 28.5Q617-400 600-400t-28.5-11.5ZM241-462q-7-106 64-182t177-76q89 0 156.5 56.5T720-519q-91-1-167.5-49T435-698q-16 80-67.5 142.5T241-462Z" />
                        </svg>
                        Staff Accounts
                    </x-ui.manager-link>
                </li>
                <li>
                    <x-ui.manager-link href="{{ route('manager.profile') }}" :active="request()->routeIs('manager.profile')">
                        <svg fill="currentColor"
                            class="w-5 h-5 transition-colors {{ request()->routeIs('manager.profile') ? 'text-neutral-900' : 'text-neutral-500 group-hover:text-neutral-900' }}"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile
                    </x-ui.manager-link>
                </li>
            </ul>
        </nav>
    </div>
</aside>
