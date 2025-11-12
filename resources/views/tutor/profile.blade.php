@extends('layouts.tutor')

@section('title', 'Settings - Htc')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8">
    @if(session('success'))
      <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 flex items-center gap-2">
        <span class="material-symbols-outlined">check_circle</span>
        <span>{{ session('success') }}</span>
      </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Left: Identity & Photo -->
      <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-2xl border p-6">
          <div class="flex items-center gap-4">
            @if($tutor->profile_picture)
              <img src="{{ asset('storage/' . ltrim($tutor->profile_picture,'/')) }}" class="w-20 h-20 rounded-full object-cover border-4 border-primary/20" />
            @else
              <div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center border-4 border-primary/20">
                <span class="text-primary font-black text-2xl">{{ substr($tutor->name,0,1) }}</span>
              </div>
            @endif
            <div>
              <div class="text-xl font-bold">{{ $tutor->name }}</div>
              <div class="text-xs text-gray-500">Email: {{ $tutor->email }} • Phone: {{ $tutor->phone ?? '—' }}</div>
            </div>
          </div>
          <div class="mt-4">
            <form method="POST" action="{{ route('tutor.settings.picture') }}" enctype="multipart/form-data" class="inline-block">
              @csrf
              <input type="file" id="pictureInput" name="profile_picture" accept="image/*" class="hidden" onchange="this.form.submit()"/>
              <label for="pictureInput" class="px-4 py-2 bg-primary text-white rounded-lg cursor-pointer hover:bg-primary/90 inline-flex items-center gap-2">
                <span class="material-symbols-outlined">photo_camera</span> Change Photo
              </label>
            </form>
            <p class="text-xs text-gray-500 mt-2">Name, email, phone and ratings are not editable.</p>
          </div>
        </div>

        <div class="bg-white rounded-2xl border p-6">
          <h3 class="text-lg font-bold mb-3">Security</h3>
          <form method="POST" action="{{ route('tutor.settings.password') }}" class="space-y-3">
            @csrf
            <div>
              <label class="text-sm font-semibold">Current Password</label>
              <input type="password" name="current_password" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="text-sm font-semibold">New Password</label>
                <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg" required>
              </div>
              <div>
                <label class="text-sm font-semibold">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded-lg" required>
              </div>
            </div>
            <button class="px-4 py-2 bg-gray-900 text-white rounded-lg">Update Password</button>
          </form>
        </div>
      </div>

      <!-- Right: Editable Profile -->
      <div class="lg:col-span-2">
        <form method="POST" action="{{ route('tutor.profile.update') }}" class="space-y-6">
          @csrf

          <div class="bg-white rounded-2xl border p-6">
            <h3 class="text-lg font-bold mb-4">Basics</h3>
            <div class="grid sm:grid-cols-2 gap-4">
              <div class="sm:col-span-2">
                <label class="text-sm font-semibold">Bio</label>
                <textarea name="bio" rows="4" class="w-full px-3 py-2 border rounded-lg" placeholder="Tell students about your teaching style...">{{ old('bio', $profile->bio) }}</textarea>
              </div>
              <div>
                <label class="text-sm font-semibold">Qualification</label>
                <input type="text" name="qualification" value="{{ old('qualification',$profile->qualification) }}" class="w-full px-3 py-2 border rounded-lg">
              </div>
              <div>
                <label class="text-sm font-semibold">Gender</label>
                <select name="gender" class="w-full px-3 py-2 border rounded-lg">
                  <option value="">Prefer not to say</option>
                  <option value="male" @selected($profile->gender==='male')>Male</option>
                  <option value="female" @selected($profile->gender==='female')>Female</option>
                  <option value="other" @selected($profile->gender==='other')>Other</option>
                </select>
              </div>
              <div>
                <label class="text-sm font-semibold">Experience (years)</label>
                <input type="number" min="0" max="60" name="experience_years" value="{{ old('experience_years',$profile->experience_years) }}" class="w-full px-3 py-2 border rounded-lg">
              </div>
              <div class="sm:col-span-2">
                <label class="text-sm font-semibold">Languages</label>
                <select multiple name="languages[]" class="w-full px-3 py-2 border rounded-lg">
                  @foreach($languages as $lang)
                    <option value="{{ $lang->id }}" @selected(in_array($lang->id, $selectedLanguageIds))>{{ $lang->name }}</option>
                  @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Hold Ctrl/Cmd to select multiple</p>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-2xl border p-6">
            <h3 class="text-lg font-bold mb-4">Teaching & Rates</h3>
            <div class="grid sm:grid-cols-3 gap-4">
              <div>
                <label class="text-sm font-semibold">Teaching Mode</label>
                <select name="teaching_mode" class="w-full px-3 py-2 border rounded-lg">
                  <option value="online" @selected($profile->teaching_mode==='online')>Online</option>
                  <option value="offline" @selected($profile->teaching_mode==='offline')>Offline</option>
                  <option value="both" @selected($profile->teaching_mode==='both')>Both</option>
                </select>
              </div>
              <div>
                <label class="text-sm font-semibold">Consultation Fee (₹/hr)</label>
                <input type="number" step="1" name="hourly_rate" value="{{ old('hourly_rate',$profile->hourly_rate) }}" class="w-full px-3 py-2 border rounded-lg">
              </div>
              <div>
                <label class="text-sm font-semibold">Travel Radius (km)</label>
                <input type="number" step="1" min="0" max="50" name="travel_radius_km" value="{{ old('travel_radius_km',$profile->travel_radius_km) }}" class="w-full px-3 py-2 border rounded-lg">
              </div>
              <div class="sm:col-span-3">
                <label class="text-sm font-semibold">Grades/Levels</label>
                <div class="flex flex-wrap gap-2 mt-1">
                  @foreach($gradeBands as $key=>$label)
                    <label class="inline-flex items-center gap-1 text-sm bg-gray-50 border rounded-lg px-2 py-1">
                      <input type="checkbox" name="grade_levels[]" value="{{ $key }}" class="accent-primary" @checked(is_array($profile->grade_levels) && in_array($key,$profile->grade_levels))>
                      <span>{{ $label }}</span>
                    </label>
                  @endforeach
                </div>
              </div>
            </div>
          </div>

          <div class="bg-white rounded-2xl border p-6">
            <h3 class="text-lg font-bold mb-4">Location</h3>
            <div class="grid sm:grid-cols-3 gap-4">
              <div class="sm:col-span-2">
                <label class="text-sm font-semibold">City</label>
                <select name="city_id" class="w-full px-3 py-2 border rounded-lg">
                  <option value="">Select City</option>
                  @foreach($cities as $c)
                    <option value="{{ $c->id }}" @selected($profile->city === $c->name)>{{ $c->name }}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <label class="text-sm font-semibold">PIN Code</label>
                <input type="text" name="pin_code" value="{{ old('pin_code',$profile->pin_code) }}" class="w-full px-3 py-2 border rounded-lg">
              </div>
            </div>
          </div>

          <div class="flex justify-end">
            <button class="px-6 py-2.5 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
</div>
@endsection

