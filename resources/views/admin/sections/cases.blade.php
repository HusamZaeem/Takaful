{{-- Cases Section --}}

<section>
    <h3 class="text-lg text-white mb-4">Cases</h3>

    <form method="GET" action="{{ route('admin.cases.index') }}" class="mb-4 flex items-center space-x-2">
        <input type="hidden" name="section" value="cases">

        <input
            id="search-input"
            type="text"
            name="search"
            placeholder="Search cases..."
            value="{{ request('search') }}"
            class="px-3 py-1 rounded bg-gray-800 border border-gray-600 text-white"
        >

        <select name="criteria" id="search-criteria" class="px-2 py-1 rounded bg-gray-800 border border-gray-600 text-white">
            <option value="case_id" {{ request('criteria') == 'case_id' ? 'selected' : '' }}>Case ID</option>
            <option value="name" {{ request('criteria') == 'name' ? 'selected' : '' }}>User Name</option>
            <option value="status" {{ request('criteria') == 'status' ? 'selected' : '' }}>Status</option>
            <option value="admin_note" {{ request('criteria') == 'admin_note' ? 'selected' : '' }}>Admin Note</option>
        </select>

        <button type="submit" id="search-button" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded">Search</button>

        <button type="button" id="clear-button" class="bg-gray-600 hover:bg-gray-500 text-white px-3 py-1 rounded">
            Clear
        </button>
    </form>



    @if($cases->isEmpty())
        <p class="text-gray-400">No cases have been submitted.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 dark:border-gray-700 text-sm text-left text-white bg-gray-900 dark:bg-gray-800 rounded-md overflow-hidden">
                <thead class="bg-gray-800 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 border-b border-gray-600">#</th>
                        <th class="px-4 py-3 border-b border-gray-600">User</th>
                        <th class="px-4 py-3 border-b border-gray-600">Incident Date</th>
                        <th class="px-4 py-3 border-b border-gray-600">Status</th>
                        <th class="px-4 py-3 border-b border-gray-600">Admin Note</th>
                        <th class="px-4 py-3 border-b border-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cases as $index => $case)
                    <tr class="hover:bg-gray-700 transition">
                        <td class="px-4 py-3 border-t border-gray-700">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 border-t border-gray-700">{{ optional($case->user)->first_name ?? '' }} {{ optional($case->user)->last_name ?? '' }}</td>
                        <td class="px-4 py-3 border-t border-gray-700">{{ optional($case->incident_date)->format('M d, Y') ?? $case->incident_date ?? '' }}</td>
                        <td class="px-4 py-3 border-t border-gray-700 capitalize">{{ $case->status }}</td>
                        <td class="px-4 py-3 border-t border-gray-700">{{ optional($case->admin_note)->take(30) ?? ($case->admin_note), $case->admin_note, 30 ?? 'No Notes Added' }}</td>
                        <td class="px-4 py-3 border-t border-gray-700 space-x-2">
                            {{-- Show --}}
                            <button 
                                class="open-show-modal text-blue-400 hover:text-blue-300 font-medium"
                                data-id="{{ optional($case->case_id)->case_id ?? $case->case_id }}"
                                data-user="{{ optional($case->user)->user_id ?? $case->user->user_id }}" data-name="{{ $case->user->first_name }} {{ $case->user->last_name }}"
                                data-email="{{ optional($case->user)->email ?? $case->user->email }}"
                                data-phone="{{ optional($case->user)->phone ?? $case->user->phone }}"
                                data-dob="{{ optional($case->user)->date_of_birth ?? $case->user->date_of_birth }}"
                                data-nationality="{{ optional($case->user)->nationality ?? $case->user->nationality }}"
                                data-incident-date="{{ optional($case->incident_date)->format('M d, Y') ?? $case->incident_date }}"
                                data-description="{{ optional($case->description)->description ?? $case->short_description }}"
                                data-notes="{{ optional($case->notes)->notes ?? $case->notes }}"
                                data-status="{{ optional($case->status)->status ?? $case->status }}"
                                data-admin-note="{{ optional($case->admin_note)->admin_note ?? $case->admin_note }}">
                                Show
                            </button>

                            {{-- Edit --}}
                            <button 
                                class="open-edit-modal text-yellow-400 hover:text-yellow-300 font-medium"
                                data-id="{{ $case->case_id }}"
                                data-status="{{ $case->status }}"
                                data-admin-note="{{ $case->admin_note }}">
                                Edit
                            </button>

                            {{-- Delete --}}
                            <form method="POST" action="{{ route('admin.cases.destroy', $case->case_id) }}" class="inline-block delete-form">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-400 hover:text-red-300 font-medium" type="submit" >Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>            
        </div>
    @endif
</section>





{{-- Show Case Modal --}}
<div id="show-case-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-[30rem]"> <!-- Increased width here -->
        <h4 class="font-semibold mb-4 text-gray-900 dark:text-gray-100">Case Information</h4>
        <div id="show-case-info">
            <table class="w-full text-left text-sm text-black dark:text-white border border-gray-300 dark:border-gray-700 border-collapse">
                <tbody>
                    @php
                        $rows = [
                            ['label' => 'User', 'id' => 'show-user'],
                            ['label' => 'Email', 'id' => 'show-email'],
                            ['label' => 'Phone', 'id' => 'show-phone'],
                            ['label' => 'Date of Birth', 'id' => 'show-dob'],
                            ['label' => 'Nationality', 'id' => 'show-nationality'],
                            ['label' => 'Incident Date', 'id' => 'show-incident-date'],
                            ['label' => 'Description', 'id' => 'show-description'],
                            ['label' => 'Notes', 'id' => 'show-notes'],
                            ['label' => 'Status', 'id' => 'show-status'],
                            ['label' => 'Admin Note', 'id' => 'show-admin-note'],
                        ];
                    @endphp

                    @foreach($rows as $row)
                        <tr>
                            <th class="px-4 py-2 w-1/3 bg-gray-100 dark:bg-gray-700 text-black dark:text-white border border-gray-300 dark:border-gray-500">
                                {{ $row['label'] }}
                            </th>
                            <td class="px-4 py-2 border border-gray-300 dark:border-gray-700" id="{{ $row['id'] }}"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex justify-end space-x-2 mt-4">
            <button type="button" id="show-modal-cancel" class="px-3 text-white py-1">Close</button>
        </div>
    </div>
</div>


  


  {{-- Edit Case Modal --}}
<div id="edit-case-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-96 text-white">
      <h4 class="font-semibold mb-4 text-gray-900 dark:text-gray-100">Edit Case</h4>
      <form id="case-edit-form" method="POST" action="">
        @csrf @method('PATCH')
        <div class="mb-3">
          <label class="block mb-1">Status</label>
          <select name="status" id="edit-status" class="w-full rounded border bg-white dark:bg-gray-700 text-black dark:text-white">
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="block mb-1">Admin Note</label>
          <textarea name="admin_note" id="edit-admin-note" rows="3" class="w-full rounded border bg-white dark:bg-gray-700 text-black dark:text-white"></textarea>
        </div>
        <div class="flex justify-end space-x-2">
          <button type="button" id="edit-modal-cancel" class="px-3 py-1">Cancel</button>
          <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded">Save</button>
        </div>
      </form>
    </div>
  </div>

  


  @push('scripts')
<script>


    
    document.getElementById('search-button').addEventListener('click', function () {
    const searchTerm = document.getElementById('search-input').value;
    const searchCriteria = document.getElementById('search-criteria').value;
    window.location.href = `/admin/cases?search=${encodeURIComponent(searchTerm)}&criteria=${encodeURIComponent(searchCriteria)}`;
    });


    document.getElementById('clear-button').addEventListener('click', function () {
        window.location.href = '/admin/cases'; 
    });





    document.addEventListener('DOMContentLoaded', () => {

        
    function displayOrDash(value) {
        return value?.trim() !== '' ? value : '------';
    }

    document.querySelectorAll('.open-show-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('show-user').innerText = displayOrDash(btn.dataset.user);
            document.getElementById('show-email').innerText = displayOrDash(btn.dataset.email);
            document.getElementById('show-phone').innerText = displayOrDash(btn.dataset.phone);
            document.getElementById('show-dob').innerText = displayOrDash(btn.dataset.dob);
            document.getElementById('show-nationality').innerText = displayOrDash(btn.dataset.nationality);
            document.getElementById('show-incident-date').innerText = displayOrDash(btn.dataset.incidentDate);
            document.getElementById('show-description').innerText = displayOrDash(btn.dataset.description);
            document.getElementById('show-notes').innerText = displayOrDash(btn.dataset.notes);
            document.getElementById('show-status').innerText = displayOrDash(btn.dataset.status);
            document.getElementById('show-admin-note').innerText = displayOrDash(btn.dataset.adminNote);

            document.getElementById('show-case-modal').classList.remove('hidden');
            document.getElementById('show-case-modal').classList.add('flex');
        });
    });


    // === Edit Modal Logic ===
    document.querySelectorAll('.open-edit-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const form = document.getElementById('case-edit-form');
            form.action = `/admin/cases/${id}`;
            document.getElementById('edit-status').value = btn.dataset.status;
            document.getElementById('edit-admin-note').value = btn.dataset.adminNote;

            document.getElementById('edit-case-modal').classList.remove('hidden');
            document.getElementById('edit-case-modal').classList.add('flex');
        });
    });

    // === Edit Form Confirmation ===
    const editForm = document.getElementById('case-edit-form');
    editForm.addEventListener('submit', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Confirm Update',
            text: 'Are you sure you want to update this case?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                editForm.submit();
            }
        });
    });

    // === Delete Confirmation ===
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'This case will be deleted!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // === Close Modals ===
    document.getElementById('show-modal-cancel').onclick = () => {
        document.getElementById('show-case-modal').classList.add('hidden');
    };
    document.getElementById('edit-modal-cancel').onclick = () => {
        document.getElementById('edit-case-modal').classList.add('hidden');
    };
});

</script>
@endpush

