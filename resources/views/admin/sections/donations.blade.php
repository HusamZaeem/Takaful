{{-- Donations Section --}}
<section>
  
    <h3 class="text-lg text-white mb-4">Donations</h3>

  <div class="flex items-center justify-between mb-4">
        

        


        <form method="GET" action="{{ route('admin.donations.index') }}" class="mb-4 flex items-center space-x-2">
            
            <input
                id="search-input_donations"
                type="text"
                name="search"
                placeholder="Search donations..."
                value="{{ request('search') }}"
                class="px-3 py-1 rounded bg-gray-800 border border-gray-600 text-white"
            >

            <select name="criteria" id="search-criteria-donations" class="px-2 py-1 rounded bg-gray-800 border border-gray-600 text-white">
                <option value="name" {{ request('criteria') == 'name' ? 'selected' : '' }}>Name</option>
                <option value="email" {{ request('criteria') == 'email' ? 'selected' : '' }}>Email</option>
                <option value="reference" {{ request('criteria') == 'reference' ? 'selected' : '' }}>Payment Ref</option>
                <option value="status" {{ request('criteria') == 'status' ? 'selected' : '' }}>Status</option>
                <option value="method" {{ request('criteria') == 'method' ? 'selected' : '' }}>Method</option>
            </select>

            <button type="submit" id="search-donations" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded">
                Search
            </button>

            <button type="button" id="clear-donations" class="bg-gray-600 hover:bg-gray-500 text-white px-3 py-1 rounded">
                Clear
            </button>
    </form>

    </div>


  @if($donations->isEmpty())
      <p class="text-gray-400">No donations recorded.</p>
  @else
      <div class="overflow-x-auto">
          <table class="min-w-full border border-gray-300 dark:border-gray-700 text-sm text-left text-white bg-gray-900 dark:bg-gray-800 rounded-md overflow-hidden">
              <thead class="bg-gray-800 dark:bg-gray-700">
                  <tr>
                      <th class="px-4 py-3 border-b border-gray-600">#</th>
                      <th class="px-4 py-3 border-b border-gray-600">Donor</th>
                      <th class="px-4 py-3 border-b border-gray-600">Amount</th>
                      <th class="px-4 py-3 border-b border-gray-600">Status</th>
                      <th class="px-4 py-3 border-b border-gray-600">Date</th>
                      <th class="px-4 py-3 border-b border-gray-600">Actions</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($donations as $i => $donation)
                  <tr class="hover:bg-gray-700 transition">
                      <td class="px-4 py-3 border-t border-gray-700">{{ $i + 1 }}</td>
                      <td class="px-4 py-3 border-t border-gray-700">
                            @if ($donation->user) 
                                {{ $donation->user->first_name }} 
                                @if($donation->user->last_name) 
                                    {{ $donation->user->last_name }}
                                @endif
                            @elseif($donation->guestDonor)
                                {{ $donation->guestDonor->name }}
                                <span class="text-gray-400">(Guest)</span>
                            @else
                                'Guest'
                            @endif
                        </td>


                      <td class="px-4 py-3 border-t border-gray-700">
                          {{ $donation->amount }} {{ $donation->currency }}
                      </td>
                      <td class="px-4 py-3 border-t border-gray-700 capitalize">
                          {{ $donation->payment_status }}
                      </td>
                      <td class="px-4 py-3 border-t border-gray-700">
                          {{ $donation->created_at->format('Y-m-d') }}
                      </td>
                      <td class="px-4 py-3 border-t border-gray-700 space-x-2">
                          <button
                              class="open-donation-show text-blue-400 hover:text-blue-300 font-medium"
                              data-id="{{ $donation->id }}"
                              data-name="{{ $donation->user->name ?? $donation->guestDonor->name ?? 'Guest' }}"
                              data-email="{{ $donation->user->email ?? $donation->guestDonor->email ?? '-----' }}"
                              data-amount="{{ $donation->amount }}"
                              data-currency="{{ $donation->currency }}"
                              data-method="{{ ucfirst($donation->payment_method) }}"
                              data-status="{{ $donation->payment_status }}"
                              data-reference="{{ $donation->payment_reference ?? '-----' }}"
                              data-notes="{{ $donation->notes ?? '-----' }}"
                              data-date="{{ $donation->created_at->format('Y-m-d H:i') }}">
                              Show
                          </button>

                          <button 
                              class="open-donation-edit text-yellow-400 hover:text-yellow-300 font-medium"
                              data-id="{{ $donation->id }}"
                              data-status="{{ $donation->payment_status }}"
                              data-notes="{{ $donation->notes }}">
                              Edit
                          </button>

                          <form method="POST" action="{{ route('admin.donations.destroy', $donation->id) }}" class="inline-block delete-donation-form">
                              @csrf @method('DELETE')
                              <button class="text-red-400 hover:text-red-300 font-medium" type="submit">Delete</button>
                          </form>
                      </td>
                  </tr>
                  @endforeach
              </tbody>
          </table>
      </div>
  @endif
</section>

{{-- Show Donation Modal --}}
<div id="donation-show-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-[30rem]">
      <h4 class="font-semibold mb-4 text-gray-900 dark:text-gray-100">Donation Details</h4>
      <table class="w-full text-left text-sm text-black dark:text-white border border-gray-300 dark:border-gray-700 border-collapse">
          <tbody>
              @foreach([
                  'Donor' => 'donor-name',
                  'Email' => 'donor-email',
                  'Amount' => 'donor-amount',
                  'Method' => 'donor-method',
                  'Status' => 'donor-status',
                  'Reference' => 'donor-reference',
                  'Notes' => 'donor-notes',
                  'Date' => 'donor-date',
              ] as $label => $id)
                  <tr>
                      <th class="px-4 py-2 w-1/3 bg-gray-100 dark:bg-gray-700 border">{{ $label }}</th>
                      <td class="px-4 py-2 border" id="{{ $id }}"></td>
                  </tr>
              @endforeach
          </tbody>
      </table>
      <div class="flex justify-end mt-4">
          <button id="donation-show-cancel" class="px-3 text-white py-1">Close</button>
      </div>
  </div>
</div>

{{-- Edit Donation Modal --}}
<div id="donation-edit-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-96">
      <h4 class="font-semibold mb-4 text-gray-900 dark:text-gray-100">Edit Donation</h4>
      <form id="donation-edit-form" method="POST" action="">
          @csrf @method('PATCH')
          <div class="mb-3">
              <label class="block mb-1 text-white">Status</label>
              <select name="payment_status" id="edit-donation-status" class="w-full rounded border bg-white dark:bg-gray-700 text-black dark:text-white">
                  <option value="pending">Pending</option>
                  <option value="completed">Completed</option>
                  <option value="failed">Failed</option>
              </select>
          </div>
          <div class="mb-4">
              <label class="block mb-1 text-white">Admin Note</label>
              <textarea name="notes" id="edit-donation-notes" rows="3" class="w-full rounded border bg-white dark:bg-gray-700 text-black dark:text-white"></textarea>
          </div>
          <div class="flex justify-end space-x-2">
              <button type="button" id="donation-edit-cancel" class="px-3 py-1 text-white">Cancel</button>
              <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded">Save</button>
          </div>
      </form>
  </div>
</div>


@push('scripts')
<script>





    document.getElementById('search-donations').addEventListener('click', function (e) {
        e.preventDefault();
        const searchTerm = document.getElementById('search-input_donations').value;
        const searchCriteria = document.getElementById('search-criteria-donations').value;
        const url = new URL(window.location.href);
        url.searchParams.set('search', searchTerm);
        url.searchParams.set('criteria', searchCriteria);
        window.location.href = url.toString();
    });

    document.getElementById('clear-donations').addEventListener('click', function () {
        window.location.href = '{{ route('admin.donations.index') }}';
    });






document.addEventListener('DOMContentLoaded', () => {
  // Show modal
  document.querySelectorAll('.open-donation-show').forEach(btn => {
      btn.addEventListener('click', () => {
          const dataMap = {
              'donor-name': btn.dataset.name,
              'donor-email': btn.dataset.email,
              'donor-amount': `${btn.dataset.amount} ${btn.dataset.currency}`,
              'donor-method': btn.dataset.method,
              'donor-status': btn.dataset.status,
              'donor-reference': btn.dataset.reference,
              'donor-notes': btn.dataset.notes,
              'donor-date': btn.dataset.date,
          };
          for (const id in dataMap) {
              document.getElementById(id).textContent = dataMap[id] || '------';
          }
          document.getElementById('donation-show-modal').classList.remove('hidden');
          document.getElementById('donation-show-modal').classList.add('flex');
      });
  });

  // Edit modal
  document.querySelectorAll('.open-donation-edit').forEach(btn => {
      btn.addEventListener('click', () => {
          const form = document.getElementById('donation-edit-form');
          form.action = `/admin/donations/${btn.dataset.id}`;
          document.getElementById('edit-donation-status').value = btn.dataset.status;
          document.getElementById('edit-donation-notes').value = btn.dataset.notes;
          document.getElementById('donation-edit-modal').classList.remove('hidden');
          document.getElementById('donation-edit-modal').classList.add('flex');
      });
  });

  // Confirm edit
  document.getElementById('donation-edit-form').addEventListener('submit', function(e) {
      e.preventDefault();
      Swal.fire({
          title: 'Update Donation?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Yes, save',
      }).then(result => {
          if (result.isConfirmed) this.submit();
      });
  });

  // Cancel buttons
  document.getElementById('donation-show-cancel').onclick = () => {
      document.getElementById('donation-show-modal').classList.add('hidden');
  };
  document.getElementById('donation-edit-cancel').onclick = () => {
      document.getElementById('donation-edit-modal').classList.add('hidden');
  };

  // Delete confirmation
  document.querySelectorAll('.delete-donation-form').forEach(form => {
      form.addEventListener('submit', e => {
          e.preventDefault();
          Swal.fire({
              title: 'Delete this donation?',
              text: 'This cannot be undone.',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, delete it',
          }).then(result => {
              if (result.isConfirmed) form.submit();
          });
      });
  });
});
</script>
@endpush
