<x-admin-layout :admin="$admin">
    @push('scripts')
    <script>
        function showSection(id) {
            document.querySelectorAll('.admin-section').forEach(s => s.classList.add('hidden'));
            const sectionEl = document.getElementById(`${id}-section`);
            if (sectionEl) {
                sectionEl.classList.remove('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.querySelector('.toggle-sidebar');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');

            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('w-64');
                sidebar.classList.toggle('w-16');
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('ml-64');
                mainContent.classList.toggle('ml-16');
                document.querySelectorAll('.nav-label').forEach(label => {
                    label.classList.toggle('hidden');
                });
            });

            const urlParams = new URLSearchParams(window.location.search);
            const section = urlParams.get('section') || '{{ $activeSection }}';
            showSection(section);

            const logoutBtn = document.getElementById('logout-button');
            const logoutForm = document.getElementById('logout-form');

            if (logoutBtn && logoutForm) {
                logoutBtn.addEventListener('click', function () {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You will be logged out.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, logout'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            logoutForm.submit();
                        }
                    });
                });
            }
        });
    </script>
    @endpush

    <div class="flex min-h-screen h-screen relative">

        <!-- Sidebar -->
        <aside id="sidebar" class="fixed z-40 top-0 left-0 h-full w-64 bg-gray-900 text-white transition-all duration-300 ease-in-out flex flex-col">

            <!-- Toggle Button -->
            <button class="absolute top-4 left-4 bg-gray-800 text-white p-2 rounded-md hover:bg-gray-700 toggle-sidebar z-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <div class="p-4 flex flex-col h-full mt-12 space-y-4">

                <!-- Admin Info -->
                <div class="mb-6">
                    <p class="text-lg font-bold nav-label">{{ $admin->first_name }} {{ $admin->last_name }}</p>
                    <p class="text-sm text-gray-400 nav-label">{{ $admin->role->type }}</p>
                </div>

                <!-- Navigation -->
                <nav class="space-y-3 flex-1">
                    @if($admin->role->type === 'General Manager')
                        <button onclick="showSection('users')" class="group flex items-center w-full px-3 py-2 rounded hover:bg-gray-700 transition">
                    <svg class="sidebar-icon text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.936 13.936 0 0112 15c2.761 0 5.304.842 7.379 2.273M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="ml-3 nav-label">Users</span>
                </button>

                <!-- Cases Button -->
                <button onclick="showSection('cases')" class="flex items-center w-full px-3 py-2 rounded hover:bg-gray-700 transition">
                    <svg class="sidebar-icon text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9 5 9-5-9-5-9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 17l9 5 9-5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9 5 9-5" />
                    </svg>
                    <span class="ml-3 nav-label">Cases</span>
                </button>

                <!-- Donations Button -->
                <button onclick="showSection('donations')" class="group flex items-center w-full px-3 py-2 rounded hover:bg-gray-700 transition">
                    <svg class="sidebar-icon text-white transition-all duration-300 mr-3 group-[.collapsed]:mr-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.104 0-2 .896-2 2 0 .457.163.873.434 1.199l1.099 1.304A1.992 1.992 0 0012 15a2 2 0 002-2c0-.457-.163-.873-.434-1.199l-1.099-1.304A1.992 1.992 0 0012 8z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v2m0-16v2" />
                    </svg>
                    <span class="nav-label">Donations</span>
                </button>
                    @endif
                </nav>

                <!-- Logout -->
                <form method="POST" action="{{ route('admin.logout') }}" id="logout-form" class="mt-6">
                    @csrf
                    <button type="button" id="logout-button" class="group flex items-center text-red-400 hover:text-red-300 transition">
                        <svg class="w-6 h-6 text-white mr-2 group-[.collapsed]:mr-0 transition-all duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                        </svg>
                        <span class="nav-label">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main id="main-content" class="flex-1 ml-64 transition-all duration-300 ease-in-out bg-gray-900 p-6 overflow-y-auto">
            @if($canViewUsers)
                <div id="users-section" class="admin-section hidden">
                    @include('admin.sections.users')
                </div>
            @endif

            @if($canViewCases)
                <div id="cases-section" class="admin-section hidden">
                    @include('admin.sections.cases')
                </div>
            @endif

            @if($canViewDonations)
                <div id="donations-section" class="admin-section hidden">
                    @include('admin.sections.donations')
                </div>
            @endif
        </main>
    </div>
</x-admin-layout>
