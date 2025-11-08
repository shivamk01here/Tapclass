@extends('layouts.student')

@section('title', 'Settings - Htc')

@section('content')
<div class="max-w-4xl mx-auto px-8 py-8">
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
            {{ session('success') }}
        </div>
        @endif

        <!-- Tabs -->
        <div class="bg-white rounded-lg border mb-6">
            <div class="flex border-b">
                <button onclick="showTab('profile')" id="profileTab" class="px-6 py-4 font-semibold border-b-2 border-primary text-primary">
                    Profile & Picture
                </button>
                <button onclick="showTab('password')" id="passwordTab" class="px-6 py-4 font-semibold text-gray-500 hover:text-gray-700">
                    Change Password
                </button>
            </div>

            <!-- Profile Tab -->
            <div id="profileContent" class="p-6">
                <h3 class="text-lg font-bold mb-4">Profile Picture</h3>
                <div class="flex items-center gap-6 mb-6">
                    @if($student->profile_picture)
                        <img src="{{ asset('storage/' . $student->profile_picture) }}" class="w-24 h-24 rounded-full object-cover border-4 border-primary/20" alt="Profile"/>
                    @else
                        <div class="w-24 h-24 rounded-full bg-primary/10 flex items-center justify-center border-4 border-primary/20">
                            <span class="text-primary font-black text-4xl">{{ substr($student->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <div>
                        <form method="POST" action="{{ route('student.settings.picture') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="profile_picture" accept="image/*" class="hidden" id="pictureInput" onchange="this.form.submit()"/>
                            <label for="pictureInput" class="px-4 py-2 bg-primary text-white rounded-lg cursor-pointer hover:bg-primary/90 inline-block">
                                Upload Photo
                            </label>
                            <p class="text-sm text-gray-500 mt-2">JPG, PNG Max 2MB</p>
                        </form>
                        @error('profile_picture')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <h3 class="text-lg font-bold mb-4">Personal Information</h3>
                <form method="POST" action="{{ route('student.profile.update') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block font-semibold mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $student->name) }}" class="w-full px-4 py-2 border rounded-lg" required/>
                        </div>
                        <div>
                            <label class="block font-semibold mb-2">Email</label>
                            <input type="email" value="{{ $student->email }}" class="w-full px-4 py-2 border rounded-lg bg-gray-50" disabled/>
                            <p class="text-sm text-gray-500 mt-1">Email cannot be changed</p>
                        </div>
                        <div>
                            <label class="block font-semibold mb-2">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $student->phone) }}" class="w-full px-4 py-2 border rounded-lg"/>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold mb-2">Grade Level</label>
                                <input type="text" name="grade" value="{{ old('grade', $profile->grade ?? '') }}" class="w-full px-4 py-2 border rounded-lg" placeholder="e.g., Class 10"/>
                            </div>
                            <div>
                                <label class="block font-semibold mb-2">Location</label>
                                <input type="text" name="location" value="{{ old('location', $profile->location ?? '') }}" class="w-full px-4 py-2 border rounded-lg"/>
                            </div>
                        </div>
                        <button type="submit" class="px-6 py-3 bg-primary text-white rounded-lg font-bold hover:bg-primary/90">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Password Tab -->
            <div id="passwordContent" class="p-6 hidden">
                <h3 class="text-lg font-bold mb-4">Change Password</h3>
                <form method="POST" action="{{ route('student.settings.password') }}">
                    @csrf
                    <div class="space-y-4 max-w-md">
                        <div>
                            <label class="block font-semibold mb-2">Current Password</label>
                            <input type="password" name="current_password" class="w-full px-4 py-2 border rounded-lg" required/>
                            @error('current_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-semibold mb-2">New Password</label>
                            <input type="password" name="new_password" class="w-full px-4 py-2 border rounded-lg" required/>
                            <p class="text-sm text-gray-500 mt-1">Minimum 8 characters</p>
                        </div>
                        <div>
                            <label class="block font-semibold mb-2">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="w-full px-4 py-2 border rounded-lg" required/>
                        </div>
                        <button type="submit" class="px-6 py-3 bg-primary text-white rounded-lg font-bold hover:bg-primary/90">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
</div>
@endsection

@push('scripts')
<script>
function showTab(tab) {
    // Hide all
    document.getElementById('profileContent').classList.add('hidden');
    document.getElementById('passwordContent').classList.add('hidden');
    
    // Remove active from all tabs
    document.getElementById('profileTab').classList.remove('border-primary', 'text-primary');
    document.getElementById('passwordTab').classList.remove('border-primary', 'text-primary');
    document.getElementById('profileTab').classList.add('text-gray-500');
    document.getElementById('passwordTab').classList.add('text-gray-500');
    
    // Show selected
    if (tab === 'profile') {
        document.getElementById('profileContent').classList.remove('hidden');
        document.getElementById('profileTab').classList.add('border-primary', 'text-primary');
        document.getElementById('profileTab').classList.remove('text-gray-500');
    } else {
        document.getElementById('passwordContent').classList.remove('hidden');
        document.getElementById('passwordTab').classList.add('border-primary', 'text-primary');
        document.getElementById('passwordTab').classList.remove('text-gray-500');
    }
}
</script>
@endpush
