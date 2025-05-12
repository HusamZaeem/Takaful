<section>
  <h3 class="text-lg text-white mb-4">Users</h3>

  <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center gap-3 flex-wrap mb-4">
    <select name="criteria" id="search-criteria" class="px-4 py-2 border border-gray-600 rounded-md text-white bg-gray-800 dark:bg-gray-700">
        <option value="user_id" {{ ($searchCriteria ?? 'user_id') === 'user_id' ? 'selected' : '' }}>Search by ID</option>
        <option value="name" {{ ($searchCriteria ?? '') === 'name' ? 'selected' : '' }}>Search by Name</option>
        <option value="email" {{ ($searchCriteria ?? '') === 'email' ? 'selected' : '' }}>Search by Email</option>
        <option value="city" {{ ($searchCriteria ?? '') === 'city' ? 'selected' : '' }}>Search by City</option>
    </select>

    <input
        type="text"
        name="search"
        id="search-input"
        placeholder="Search"
        value="{{ $searchTerm ?? '' }}"
        class="px-4 py-2 w-64 border border-gray-600 rounded-md text-white bg-gray-800 dark:bg-gray-700"
    >

    <button type="submit" id="search-button" class="px-4 py-2 bg-blue-600 text-white rounded-md">Search</button>

    <button type="button" id="clear-button-users" class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-600">Clear</button>
  </form>



  @if($users->isEmpty())
    <p>No users found.</p>
  @else
  <table class="w-full border border-gray-300 dark:border-gray-700 text-sm text-left text-white bg-gray-900 dark:bg-gray-800 rounded-md overflow-hidden">
    <thead class="bg-gray-800 dark:bg-gray-700 text-white">
      <tr>
        <th class="px-4 py-3 border-b border-gray-600">ID</th>
        <th class="px-4 py-3 border-b border-gray-600">Full Name</th>
        <th class="px-4 py-3 border-b border-gray-600">Email</th>
        <th class="px-4 py-3 border-b border-gray-600">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
      <tr class="hover:bg-gray-700 transition">
        <td class="px-4 py-3 border-t border-gray-700">{{ $user->user_id }}</td>
        <td class="px-4 py-3 border-t border-gray-700">{{ $user->first_name }} {{ $user->last_name }}</td>
        <td class="px-4 py-3 border-t border-gray-700">{{ $user->email }}</td>
        <td class="px-4 py-3 border-t border-gray-700 space-x-2">
          <button class="text-blue-400 hover:text-blue-300 font-medium" onclick="showModal({{ $user->user_id }})">Show</button>
          <form action="{{ route('admin.users.destroy', $user->user_id) }}?section=users" method="POST" style="display:inline;" id="delete-form-{{ $user->user_id }}">
            @csrf @method('DELETE')
            <button type="submit" class="text-red-400 hover:text-red-300 font-medium">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>  
  @endif
</section>

<!-- Modal for displaying user details -->
<div id="user-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-1/2 relative">
      <button onclick="closeModal()" class="absolute top-2 right-2 text-red-500 text-xl">✖</button>
      <div id="user-modal-content" class="text-center text-black dark:text-white flex flex-col items-center gap-2">
          <!-- User info will be loaded here dynamically -->
      </div>
  </div>
</div>

<input type="hidden" id="defaultProfileImage" value="{{ asset('images/default-profile.png') }}">



@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    
    // Handle the search functionality
    document.getElementById('search-button').addEventListener('click', function() {
        const searchTerm = document.getElementById('search-input').value;
        const searchCriteria = document.getElementById('search-criteria').value;

        // Redirect to the same page with the search query and criteria
        window.location.href = `/admin/users?search=${encodeURIComponent(searchTerm)}&criteria=${encodeURIComponent(searchCriteria)}`;
    });

    // Clear the search input and reset the criteria
    document.getElementById('clear-button-users').addEventListener('click', function() {
        document.getElementById('search-input').value = '';
        document.getElementById('search-criteria').value = 'user_id'; 
        window.location.href = '{{ route('admin.users.index') }}';
    });

    function showModal(userId) {
      const defaultImage = document.getElementById('defaultProfileImage').value;

      fetch(`/admin/users/${userId}`)
          .then(response => response.json())
          .then(data => {
              let profilePic = defaultImage;

              const pic = data.profile_picture?.trim(); 

              if (pic) {
                  if (pic.startsWith('http://') || pic.startsWith('https://')) {
                      profilePic = pic; 
                  } else {
                      profilePic = `/storage/${pic}`; 
                  }
              }

              const modalContent = `
              <div class="flex flex-col items-center text-center w-full">
                <img src="${profilePic}" alt="Profile Picture" 
                    class="w-24 h-24 rounded-full object-cover ring-2 ring-gray-300 dark:ring-gray-600 mb-4"
                    onerror="this.onerror=null;this.src='${defaultImage}';">
                <h2 class="text-2xl font-bold mb-4">${data.first_name} ${data.last_name}</h2>

                <table class="w-3/4 border border-gray-300 dark:border-gray-600 text-left text-sm">
                  <tbody>
                    <tr class="border-b border-gray-300 dark:border-gray-600">
                      <td class="py-2 px-4 font-semibold bg-gray-100 dark:bg-gray-700">Email</td>
                      <td class="py-2 px-4">${data.email}</td>
                    </tr>
                    <tr class="border-b border-gray-300 dark:border-gray-600">
                      <td class="py-2 px-4 font-semibold bg-gray-100 dark:bg-gray-700">Phone</td>
                      <td class="py-2 px-4">${data.phone || 'N/A'}</td>
                    </tr>
                    <tr class="border-b border-gray-300 dark:border-gray-600">
                      <td class="py-2 px-4 font-semibold bg-gray-100 dark:bg-gray-700">Gender</td>
                      <td class="py-2 px-4">${data.gender || 'N/A'}</td>
                    </tr>
                    <tr class="border-b border-gray-300 dark:border-gray-600">
                      <td class="py-2 px-4 font-semibold bg-gray-100 dark:bg-gray-700">Date of Birth</td>
                      <td class="py-2 px-4">${data.date_of_birth || 'N/A'}</td>
                    </tr>
                    <tr class="border-b border-gray-300 dark:border-gray-600">
                      <td class="py-2 px-4 font-semibold bg-gray-100 dark:bg-gray-700">Nationality</td>
                      <td class="py-2 px-4">${data.nationality || 'N/A'}</td>
                    </tr>
                    <tr class="border-b border-gray-300 dark:border-gray-600">
                      <td class="py-2 px-4 font-semibold bg-gray-100 dark:bg-gray-700">ID Number</td>
                      <td class="py-2 px-4">${data.id_number || 'N/A'}</td>
                    </tr>
                    <tr class="border-b border-gray-300 dark:border-gray-600">
                      <td class="py-2 px-4 font-semibold bg-gray-100 dark:bg-gray-700">Marital Status</td>
                      <td class="py-2 px-4">${data.marital_status || 'N/A'}</td>
                    </tr>
                    <tr class="border-b border-gray-300 dark:border-gray-600">
                      <td class="py-2 px-4 font-semibold bg-gray-100 dark:bg-gray-700">Residence Place</td>
                      <td class="py-2 px-4">${data.residence_place || 'N/A'}</td>
                    </tr>
                    <tr class="border-b border-gray-300 dark:border-gray-600">
                      <td class="py-2 px-4 font-semibold bg-gray-100 dark:bg-gray-700">Street Name</td>
                      <td class="py-2 px-4">${data.street_name || 'N/A'}</td>
                    </tr>
                    <tr class="border-b border-gray-300 dark:border-gray-600">
                      <td class="py-2 px-4 font-semibold bg-gray-100 dark:bg-gray-700">Building Number</td>
                      <td class="py-2 px-4">${data.building_number || 'N/A'}</td>
                    </tr>
                    <tr class="border-b border-gray-300 dark:border-gray-600">
                      <td class="py-2 px-4 font-semibold bg-gray-100 dark:bg-gray-700">City</td>
                      <td class="py-2 px-4">${data.city || 'N/A'}</td>
                    </tr>
                    <tr class="border-b border-gray-300 dark:border-gray-600">
                      <td class="py-2 px-4 font-semibold bg-gray-100 dark:bg-gray-700">ZIP Code</td>
                      <td class="py-2 px-4">${data.ZIP || 'N/A'}</td>
                    </tr>
                    <tr>
                      <td class="py-2 px-4 font-semibold bg-gray-100 dark:bg-gray-700">Joined</td>
                      <td class="py-2 px-4">${data.created_at}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            `;

              // Clear previous content and set new content
              document.getElementById('user-modal-content').innerHTML = ''; // Clear previous content

              document.getElementById('user-modal-content').innerHTML = modalContent;
              document.getElementById('user-modal').classList.remove('hidden');
          })
          .catch(error => {
              console.error('Error loading user data:', error);
          });
  }


    function closeModal() {
        document.getElementById('user-modal').classList.add('hidden');
    }

    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const formId = this.id;
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        });
    });
</script>
@endpush
