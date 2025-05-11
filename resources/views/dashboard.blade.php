
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Your Submitted Cases</h3>

                    @if($cases->isEmpty())
                        <p>You have not submitted any cases yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-white bg-gray-900 border border-gray-700 rounded">
                                <thead class="bg-gray-700 text-gray-300">
                                    <tr>
                                        <th class="px-4 py-2 text-left">#</th>
                                        <th class="px-4 py-2 text-left">Incident Date</th>
                                        <th class="px-4 py-2 text-left">Status</th>
                                        <th class="px-4 py-2 text-left">Admin Note</th>
                                        <th class="px-4 py-2 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cases as $index => $case)
                                        <tr class="border-t border-gray-700">
                                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                                            <td class="px-4 py-2">{{ $case->incident_date }}</td>
                                            <td class="px-4 py-2 capitalize">{{ $case->status }}</td>
                                            <td class="px-4 py-2">{{ $case->admin_note ?? '—' }}</td>
                                            <td class="px-4 py-2 space-x-2">
                                                @if($case->status === 'pending')
                                                    {{-- Edit Button --}}
                                                    <a href="{{ route('case.edit', $case->case_id) }}"
                                                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded">
                                                        Edit
                                                    </a>

                                                    {{-- Delete Form --}}
                                                    <form action="{{ route('case.destroy', $case->case_id) }}"
                                                          method="POST"
                                                          class="inline-block delete-case-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="inline-block bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-1 rounded">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-500 text-xs">Locked</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert2 Delete Confirmation --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.delete-case-form').forEach(form => {
          form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
              title: 'Are you sure?',
              text: "This will permanently delete your case!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Yes, delete it!',
              cancelButtonText: 'Cancel'
            }).then((result) => {
              if (result.isConfirmed) {
                form.submit();
              }
            });
          });
        });
      });
    </script>
    @endpush

</x-app-layout>
