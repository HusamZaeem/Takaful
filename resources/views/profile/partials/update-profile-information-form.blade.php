<section>


    
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information.") }}
        </p>
    </header>

    {{-- Profile Photo Section --}}
    <div class="mt-6 flex justify-center items-center gap-4">
        <div class="relative flex justify-center items-center">
            <!-- Larger Profile Photo -->
            <img src="{{ $user->profile_photo_url }}"
                 class="h-32 w-32 rounded-full object-cover ring-4 ring-gray-300 dark:ring-gray-600" />
    
            <form method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data" class="absolute bottom-0 right-0">
                @csrf
                @method('PATCH')
                <label class="cursor-pointer">
                    <input type="file" name="profile_photo" class="hidden" onchange="this.form.submit()" />
                    <!-- Camera Icon -->
                    <img src="{{ asset('images/photo-camera.svg') }}" alt="Change Photo"
                         class="w-10 h-10 hover:w-12 hover:h-12 transition-all duration-200" />
                </label>
            </form>
    
            @if ($errors->has('profile_photo'))
                <p class="text-sm text-red-500 mt-1">{{ $errors->first('profile_photo') }}</p>
            @endif
        </div>
    </div>
    

    <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- First and Last Name --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <x-input-label for="first_name" :value="__('First Name')" />
                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full"
                              :value="old('first_name', $user->first_name)" required autofocus autocomplete="first_name" />
                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
            </div>

            <div>
                <x-input-label for="last_name" :value="__('Last Name')" />
                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full"
                              :value="old('last_name', $user->last_name)" required autocomplete="last_name" />
                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
            </div>
        </div>

        {{-- Father and Grandfather Name --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <x-input-label for="father_name" :value="__('Father Name')" />
                <x-text-input id="father_name" name="father_name" type="text" class="mt-1 block w-full"
                              :value="old('father_name', $user->father_name)" autocomplete="father_name" />
                <x-input-error class="mt-2" :messages="$errors->get('father_name')" />
            </div>

            <div>
                <x-input-label for="grandfather_name" :value="__('Grandfather Name')" />
                <x-text-input id="grandfather_name" name="grandfather_name" type="text" class="mt-1 block w-full"
                              :value="old('grandfather_name', $user->grandfather_name)" autocomplete="grandfather_name" />
                <x-input-error class="mt-2" :messages="$errors->get('grandfather_name')" />
            </div>
        </div>

        {{-- Email (hidden field + read-only UI field) --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email_display" type="email" class="mt-1 block w-full bg-gray-100 dark:bg-gray-800 text-gray-500"
                          :value="$user->email" disabled />
            <input type="hidden" name="email" value="{{ $user->email }}" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        {{-- Gender, Date of Birth --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <x-input-label for="gender" :value="__('Gender')" />
                <select id="gender" name="gender"
                        class="mt-1 block w-full rounded-md dark:bg-gray-800 dark:text-white dark:border-gray-700 border-gray-300 focus:ring-indigo-500">
                    <option value="">Select</option>
                    <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Female</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
            </div>

            <div>
                <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full"
                              :value="old('date_of_birth', $user->date_of_birth)" />
                <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
            </div>
        </div>

        {{-- Nationality and ID Number --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <x-input-label for="nationality" :value="__('Nationality')" />
                <x-text-input id="nationality" name="nationality" type="text" class="mt-1 block w-full"
                              :value="old('nationality', $user->nationality)" />
                <x-input-error class="mt-2" :messages="$errors->get('nationality')" />
            </div>

            <div>
                <x-input-label for="id_number" :value="__('ID Number')" />
                <x-text-input id="id_number" name="id_number" type="text" class="mt-1 block w-full"
                              :value="old('id_number', $user->id_number)" />
                <x-input-error class="mt-2" :messages="$errors->get('id_number')" />
            </div>
        </div>

        {{-- Marital Status and Phone --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <x-input-label for="marital_status" :value="__('Marital Status')" />
                <select id="marital_status" name="marital_status"
                        class="mt-1 block w-full rounded-md dark:bg-gray-800 dark:text-white dark:border-gray-700 border-gray-300 focus:ring-indigo-500">
                    <option value="">Select</option>
                    <option value="single" {{ old('marital_status', $user->marital_status) === 'single' ? 'selected' : '' }}>Single</option>
                    <option value="married" {{ old('marital_status', $user->marital_status) === 'married' ? 'selected' : '' }}>Married</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('marital_status')" />
            </div>

            <div>
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                              :value="old('phone', $user->phone)" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
        </div>

        {{-- Address Fields --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <x-input-label for="residence_place" :value="__('Residence Place')" />
                <x-text-input id="residence_place" name="residence_place" type="text" class="mt-1 block w-full"
                              :value="old('residence_place', $user->residence_place)" />
                <x-input-error class="mt-2" :messages="$errors->get('residence_place')" />
            </div>

            <div>
                <x-input-label for="street_name" :value="__('Street Name')" />
                <x-text-input id="street_name" name="street_name" type="text" class="mt-1 block w-full"
                              :value="old('street_name', $user->street_name)" />
                <x-input-error class="mt-2" :messages="$errors->get('street_name')" />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <x-input-label for="building_number" :value="__('Building Number')" />
                <x-text-input id="building_number" name="building_number" type="text" class="mt-1 block w-full"
                              :value="old('building_number', $user->building_number)" />
                <x-input-error class="mt-2" :messages="$errors->get('building_number')" />
            </div>

            <div>
                <x-input-label for="city" :value="__('City')" />
                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full"
                              :value="old('city', $user->city)" />
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>
        </div>

        <div class="w-full">
            <x-input-label for="ZIP" :value="__('ZIP Code')" />
            <x-text-input id="ZIP" name="ZIP" type="text" class="mt-1 block w-full"
                          :value="old('ZIP', $user->ZIP)" />
            <x-input-error class="mt-2" :messages="$errors->get('ZIP')" />
        </div>

        {{-- Save Button --}}
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
