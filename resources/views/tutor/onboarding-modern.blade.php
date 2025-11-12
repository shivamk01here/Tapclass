<!DOCTYPE html>
<html class="light" lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Tutor Onboarding - Htc</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <script>
    tailwind.config = { theme: { extend: { colors: { primary: '#13a4ec', secondary: '#FFA500', 'background-light':'#f6f7f8' }, fontFamily:{ display:['Manrope','sans-serif'] } } } }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-background-light font-display text-sm">
  <div class="min-h-screen p-4 md:p-8">
    <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow border grid grid-cols-1 md:grid-cols-5 overflow-hidden">
      <!-- Left progress -->
      <aside class="bg-gray-50 p-6 md:col-span-2">
        <div class="mb-6 flex items-center gap-2 text-primary"><span class="material-symbols-outlined">school</span><span class="font-bold">Htc</span></div>
        <h2 class="text-xl font-extrabold mb-6">Tutor onboarding</h2>
        <ol class="space-y-6">
          @php $labels=['Basic Info','Subjects & Rates','Documents','Location & Mode','Phone','OTP']; @endphp
          @foreach($labels as $i=>$label)
            <li class="flex items-start gap-3">
              <div class="mt-0.5 w-6 h-6 rounded-full border border-gray-300 text-gray-600 flex items-center justify-center text-xs step-dot" data-step="{{ $i+1 }}">{{ $i+1 }}</div>
              <div>
                <p class="font-semibold">{{ $label }}</p>
                <p class="text-xs text-gray-500">@if($i===0) Photo, bio, gender, languages, qualification, experience @elseif($i===1) Choose subjects and rates @elseif($i===2) ID and degree upload @elseif($i===3) City, modes, radius, grades @elseif($i===4) Verify phone @else Enter OTP @endif</p>
              </div>
            </li>
          @endforeach
        </ol>
      </aside>

      <!-- Right content -->
      <main class="p-6 md:p-10 md:col-span-3 space-y-10">
        <div id="global-alert" class="hidden p-3 rounded border text-sm"></div>

        <!-- Step: Basic -->
        <section id="step-basic">
          <h3 class="text-lg font-bold mb-4">Basic information</h3>
          <form id="form-basic" class="space-y-4" enctype="multipart/form-data">
            <div id="alert-basic" class="hidden p-3 rounded border text-xs"></div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Profile photo</label>
                <input type="file" name="profile_photo" accept="image/*" class="w-full rounded-lg border-gray-300 file:mr-3 file:px-3 file:py-1.5 file:bg-primary file:text-white file:rounded-md" />
                <p class="text-xs text-gray-500 mt-1">Upload a clear, professional headshot.</p>
              </div>
              <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Gender</label>
                <select name="gender" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                  <option value="">Select</option>
                  @foreach(['male'=>'Male','female'=>'Female','other'=>'Other'] as $gVal=>$gLabel)
                    <option value="{{ $gVal }}" @selected(($profile->gender ?? '')===$gVal)>{{ $gLabel }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">About me / Bio</label>
              <textarea name="bio" rows="4" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary" placeholder="Describe your teaching philosophy, passion, etc.">{{ $profile->bio }}</textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Highest qualification</label>
                <select name="qualification" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                  <option value="">Select</option>
                  @foreach(($qualifications ?? []) as $q)
                    <option value="{{ $q }}" @selected(($profile->qualification ?? '')===$q)>{{ $q }}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Experience</label>
                <select name="experience_band" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                  @foreach(['0-1','1-3','3-5','5-10','10+'] as $b)
                    <option value="{{ $b }}">{{ $b }} years</option>
                  @endforeach
                </select>
              </div>
            </div>
<div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">Languages you speak</label>
              <div class="relative">
                <input id="language-input" type="text" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary" placeholder="Type to search languages" />
                <div id="language-suggestions" class="absolute z-10 mt-1 w-full bg-white border rounded-lg shadow hidden max-h-48 overflow-auto"></div>
              </div>
              <div id="selected-languages" class="mt-2 flex flex-wrap gap-2"></div>
              <div id="languages-hidden"></div>
            </div>
            <div class="pt-2 flex justify-end"><button class="px-5 py-2 rounded-lg bg-primary text-white font-semibold">Save and continue</button></div>
          </form>
        </section>

        <!-- Step: Subjects & rates -->
        <section id="step-subjects" class="hidden">
          <h3 class="text-lg font-bold mb-4">Subjects & rates</h3>
          <form id="form-subjects" class="space-y-3">
            <div id="alert-subjects" class="hidden p-3 rounded border text-xs"></div>
            <div id="subjects-container" class="space-y-3"></div>
            <button type="button" id="add-subject" class="text-primary text-sm font-semibold">+ Add subject</button>
            <div class="pt-2 flex justify-between"><button type="button" data-prev class="px-4 py-2 border rounded-lg">Back</button><button class="px-5 py-2 rounded-lg bg-primary text-white font-semibold">Save and continue</button></div>
          </form>
        </section>

        <!-- Step: Documents -->
        <section id="step-documents" class="hidden">
          <h3 class="text-lg font-bold mb-4">Verification documents</h3>
          <form id="form-documents" class="space-y-4" enctype="multipart/form-data">
            <div id="alert-documents" class="hidden p-3 rounded border text-xs"></div>
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">Upload ID proof</label>
              <input type="file" name="government_id" accept="image/*" class="w-full rounded-lg border-gray-300 file:mr-3 file:px-3 file:py-1.5 file:bg-primary file:text-white file:rounded-md" />
              <p class="text-xs text-gray-500 mt-1">Used only for verification. Not shown publicly.</p>
            </div>
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">Degree/Certification</label>
              <input type="file" name="degree_certificate" accept="image/*" class="w-full rounded-lg border-gray-300 file:mr-3 file:px-3 file:py-1.5 file:bg-primary file:text-white file:rounded-md" />
            </div>
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">CV (optional)</label>
              <input type="file" name="cv" accept=".pdf,.doc,.docx" class="w-full rounded-lg border-gray-300 file:mr-3 file:px-3 file:py-1.5 file:bg-secondary file:text-white file:rounded-md" />
            </div>
            <div class="pt-2 flex justify-between"><button type="button" data-prev class="px-4 py-2 border rounded-lg">Back</button><button class="px-5 py-2 rounded-lg bg-primary text-white font-semibold">Save and continue</button></div>
          </form>
        </section>

        <!-- Step: Location & mode -->
        <section id="step-location" class="hidden">
          <h3 class="text-lg font-bold mb-4">Location & tutoring mode</h3>
          <form id="form-location" class="space-y-4">
            <div id="alert-location" class="hidden p-3 rounded border text-xs"></div>
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">City</label>
              <select name="city_id" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                <option value="">Select city</option>
                @foreach(($cities ?? []) as $city)
                  <option value="{{ $city->id }}" @selected(($profile->city ?? '') == $city->name)>{{ $city->name }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">Tutoring modes</label>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <label class="flex items-center gap-2 p-3 border rounded-lg"><input type="checkbox" name="modes[]" value="online"/> <span>Online</span></label>
                <label class="flex items-center gap-2 p-3 border rounded-lg"><input type="checkbox" name="modes[]" value="offline_my"/> <span>Offline - At my location</span></label>
                <label class="flex items-center gap-2 p-3 border rounded-lg"><input type="checkbox" name="modes[]" value="offline_student" id="mode-offline-student"/> <span>Offline - At student's location</span></label>
              </div>
            </div>
            <div id="travel-wrapper" class="hidden">
              <label class="block text-xs font-semibold text-gray-700 mb-1">Max travel radius</label>
              <select name="travel_radius_km" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary">
                @foreach([3,5,10,15,20] as $km)
                  <option value="{{ $km }}">{{ $km }} km</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">General online consultation rate</label>
              <input name="hourly_rate" type="number" step="0.01" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary" placeholder="e.g., 500" value="{{ $profile->hourly_rate }}"/>
            </div>
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">Grades/levels you teach</label>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                @foreach(($gradeBands ?? []) as $value=>$label)
                  <label class="flex items-center gap-2 p-2 border rounded">
                    <input type="checkbox" name="grade_levels[]" value="{{ $value }}"> <span>{{ $label }}</span>
                  </label>
                @endforeach
              </div>
            </div>
            <p class="text-xs text-gray-600">We need your location to match you with nearby students for offline sessions.</p>
            <div class="flex items-center gap-2">
              <button type="button" id="btn-current-location" class="px-4 py-2 bg-secondary text-white rounded-md">Use Current Location</button>
              <span id="loc-status" class="text-xs text-gray-500"></span>
            </div>
            <input type="hidden" name="latitude" id="latitude" value="{{ $profile->latitude }}" />
            <input type="hidden" name="longitude" id="longitude" value="{{ $profile->longitude }}" />
            <div id="pin-wrapper" class="hidden">
              <label class="block text-xs font-semibold text-gray-700 mb-1">Pincode</label>
              <input type="text" name="pin_code" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary" placeholder="Enter pincode" />
            </div>
            <div class="pt-2 flex justify-between"><button type="button" data-prev class="px-4 py-2 border rounded-lg">Back</button><button class="px-5 py-2 rounded-lg bg-primary text-white font-semibold">Save and continue</button></div>
          </form>
        </section>

        <!-- Step: Phone -->
        <section id="step-phone" class="hidden">
          <h3 class="text-lg font-bold mb-4">Phone verification</h3>
          <form id="form-phone" class="space-y-3">
            <div id="alert-phone" class="hidden p-3 rounded border text-xs"></div>
            <input name="phone" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary" placeholder="Phone number" value="{{ $user->phone }}"/>
            <p class="text-xs text-gray-600">You'll receive an OTP (use 123456 for now).</p>
            <div class="pt-2 flex justify-between"><button type="button" data-prev class="px-4 py-2 border rounded-lg">Back</button><button class="px-5 py-2 rounded-lg bg-primary text-white font-semibold">Send OTP</button></div>
          </form>
        </section>

        <!-- Step: OTP -->
        <section id="step-otp" class="hidden">
          <h3 class="text-lg font-bold mb-4">Enter OTP</h3>
          <form id="form-otp" class="space-y-3">
            <div id="alert-otp" class="hidden p-3 rounded border text-xs"></div>
            <input name="otp" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary" placeholder="Enter 123456" />
            <div class="pt-2 flex justify-between"><button type="button" data-prev class="px-4 py-2 border rounded-lg">Back</button><button id="btn-complete" class="px-5 py-2 rounded-lg bg-green-600 text-white font-semibold">Verify & Finish</button></div>
          </form>
        </section>
      </main>
    </div>
  </div>

  <script>
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const steps = ['basic','subjects','documents','location','phone','otp'];

    function stepIndex(id){ return steps.indexOf(id)+1; }

    function setStepper(idx){
      document.querySelectorAll('.step-dot').forEach(dot=>{
        const n = Number(dot.getAttribute('data-step'));
        dot.classList.toggle('bg-primary', n===idx);
        dot.classList.toggle('text-white', n===idx);
        dot.classList.toggle('border-primary', n<=idx);
      });
    }

    function show(id){
      document.querySelectorAll('main section').forEach(s=>s.classList.add('hidden'));
      document.getElementById('step-'+id).classList.remove('hidden');
      setStepper(stepIndex(id));
    }

    // Alerts helpers
    function showAlert(el, msg, kind='error'){
      el.classList.remove('hidden');
      el.className = 'p-3 rounded border text-xs ' + (kind==='error' ? 'bg-red-50 border-red-200 text-red-700' : 'bg-green-50 border-green-200 text-green-700');
      el.innerHTML = msg;
    }
    function clearAlert(el){ el.classList.add('hidden'); el.innerHTML=''; }

    // Subjects dynamic rows
    const subjectsList = @json(\App\Models\Subject::where('is_active', true)->orderBy('name')->get(['id','name']));
    function addSubjectRow(){
      const wrap = document.getElementById('subjects-container');
      const idx = wrap.children.length;
      const options = subjectsList.map(s=>`<option value="${s.id}">${s.name}</option>`).join('');
      const row = document.createElement('div');
      row.className='p-3 bg-gray-50 rounded-lg border';
      row.innerHTML=`<div class=\"flex justify-end\"><button type=\"button\" class=\"text-xs text-red-600 hover:underline\" data-remove>Remove</button></div><div class=\"grid grid-cols-1 sm:grid-cols-2 gap-3\">
        <select name=\"subjects[${idx}][subject_id]\" class=\"rounded-lg border-gray-300 focus:border-primary focus:ring-primary\">${options}</select>
        <div class=\"flex items-center gap-4 py-2\">
          <label class=\"text-sm flex items-center\"><input type=\"checkbox\" name=\"subjects[${idx}][is_online_available]\" value=\"1\" class=\"mr-1.5 rounded text-primary focus:ring-primary\">Online</label>
          <label class=\"text-sm flex items-center\"><input type=\"checkbox\" name=\"subjects[${idx}][is_offline_available]\" value=\"1\" class=\"mr-1.5 rounded text-primary focus:ring-primary\">Offline</label>
        </div></div>
        <div class=\"grid grid-cols-1 sm:grid-cols-2 gap-3 mt-2\">
          <input type=\"number\" step=\"0.01\" name=\"subjects[${idx}][online_rate]\" placeholder=\"Online Rate (₹)\" class=\"rounded-lg border-gray-300 focus:border-primary focus:ring-primary\">
          <input type=\"number\" step=\"0.01\" name=\"subjects[${idx}][offline_rate]\" placeholder=\"Offline Rate (₹)\" class=\"rounded-lg border-gray-300 focus:border-primary focus:ring-primary\">
        </div>`;
      wrap.appendChild(row);
      row.querySelector('[data-remove]')?.addEventListener('click', ()=>{ row.remove(); });
    }
    document.getElementById('add-subject')?.addEventListener('click', addSubjectRow);
    addSubjectRow();

    // Travel radius toggle + geolocation
    const offlineStudent = document.getElementById('mode-offline-student');
    const travelWrap = document.getElementById('travel-wrapper');
    function syncTravel(){ travelWrap.classList.toggle('hidden', !offlineStudent?.checked); }
    offlineStudent?.addEventListener('change', syncTravel);
    syncTravel();

    document.getElementById('btn-current-location')?.addEventListener('click', ()=>{
      const statusEl = document.getElementById('loc-status');
      const latEl = document.getElementById('latitude');
      const lngEl = document.getElementById('longitude');
      statusEl.textContent='Detecting location...';
      if(!navigator.geolocation){ statusEl.textContent='Geolocation not supported.'; return; }
      navigator.geolocation.getCurrentPosition((pos)=>{
        latEl.value = pos.coords.latitude.toFixed(6);
        lngEl.value = pos.coords.longitude.toFixed(6);
        statusEl.textContent='Location captured.';
      }, ()=>{ statusEl.textContent='Could not detect automatically. Please enter PIN code below.'; document.getElementById('pin-wrapper').classList.remove('hidden'); }, { enableHighAccuracy:true, timeout:8000, maximumAge:0 });
    });

    // AJAX submit util
    async function ajaxPost(form){
      const isFile = form.enctype === 'multipart/form-data' || form.querySelector('input[type=file]');
      const headers = isFile ? { 'X-CSRF-TOKEN': csrf, 'Accept':'application/json' } : { 'Content-Type':'application/x-www-form-urlencoded', 'Accept':'application/json' };
      const body = isFile ? (()=>{ const fd = new FormData(form); fd.append('step', form.id.replace('form-','')); return fd; })() : new URLSearchParams(new FormData(form));
      if(!isFile) body.append('_token', csrf), body.append('step', form.id.replace('form-',''));
      const res = await fetch(`{{ route('tutor.onboarding.save-step') }}`, { method:'POST', headers, body });
      const data = await res.json().catch(()=>({}));
      if(res.ok) return data;
      const err = new Error(Object.values(data.errors||{}).flat().join('\n') || data.message || 'Validation failed');
      err.errors = data.errors; throw err;
    }

    function wireForm(id, nextId){
      const form = document.getElementById('form-'+id);
      const alert = document.getElementById('alert-'+id);
      form?.addEventListener('submit', async (e)=>{
        e.preventDefault(); clearAlert(alert);
        try{ const json = await ajaxPost(form); show(nextId); showAlert(document.getElementById('global-alert'), 'Saved', 'success'); }
        catch(ex){ const msgs = Object.values(ex.errors||{}).flat().join('<br>') || ex.message; showAlert(alert, msgs, 'error'); }
      });
    }

    // Turn all submit buttons into Ajax
    document.querySelectorAll('form button[type="submit"], form button:not([type])').forEach(btn=>{ btn.type='submit'; });

    wireForm('basic','subjects');
    wireForm('subjects','documents');
    wireForm('documents','location');
    wireForm('location','phone');
    wireForm('phone','otp');

    // OTP final step
    document.getElementById('form-otp')?.addEventListener('submit', async (e)=>{
      e.preventDefault();
      try{
        const body = new URLSearchParams(new FormData(e.target)); body.append('_token', csrf);
        const res = await fetch(`{{ route('tutor.onboarding.verify-otp') }}`, { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'}, body });
        const json = await res.json();
        if(!json.success) throw new Error(json.message || 'OTP invalid');
        window.location.href = json.redirect;
      }catch(err){ showAlert(document.getElementById('alert-otp'), err.message, 'error'); }
    });

    // Back buttons
    document.addEventListener('click', (e)=>{
      if(e.target && e.target.matches('[data-prev]')){
        e.preventDefault();
        const visible = steps.findIndex(s=>!document.getElementById('step-'+s).classList.contains('hidden'));
        const prev = Math.max(0, visible-1); show(steps[prev]);
      }
    });

    // Languages chips autocomplete (server-backed)
    const langSelected = new Map();
    const langInput = document.getElementById('language-input');
    const langSug = document.getElementById('language-suggestions');
    const langChips = document.getElementById('selected-languages');
    const langHidden = document.getElementById('languages-hidden');
    function renderLangChips(){
      if(!langChips) return;
      langChips.innerHTML=''; langHidden.innerHTML='';
      langSelected.forEach((name,id)=>{
        const chip = document.createElement('span');
        chip.className='inline-flex items-center gap-1 bg-primary/10 text-primary px-2 py-1 rounded-full text-xs';
        chip.innerHTML = `<span>${name}</span><button type=\"button\" aria-label=\"remove\" class=\"ml-1\">×</button>`;
        chip.querySelector('button').addEventListener('click',()=>{ langSelected.delete(id); renderLangChips(); });
        langChips.appendChild(chip);
        const h = document.createElement('input'); h.type='hidden'; h.name='languages[]'; h.value=id; langHidden.appendChild(h);
      });
    }
    async function showLangSuggestions(q){
      if(!langSug) return;
      q = String(q || '').trim();
      if(!q){ langSug.classList.add('hidden'); langSug.innerHTML=''; return; }
      try{
        const res = await fetch(`{{ route('languages.suggest') }}?q=${encodeURIComponent(q)}`, { headers: { 'Accept':'application/json' } });
        const arr = await res.json();
        // Include "add new" option if exact match not found
        const exists = arr.some(x=>x.name.toLowerCase()===q.toLowerCase());
        let html = arr.filter(x=>!langSelected.has(x.id)).map(x=>`<button type=\"button\" data-id=\"${x.id}\" data-name=\"${x.name}\" class=\"w-full text-left px-3 py-2 hover:bg-gray-50\">${x.name}</button>`).join('');
        if(!exists){
          html += `<button type=\"button\" data-create=\"${q}\" class=\"w-full text-left px-3 py-2 text-primary hover:bg-primary/5\">+ Add \"${q}\"</button>`;
        }
        langSug.innerHTML = html;
        langSug.classList.remove('hidden');
        langSug.querySelectorAll('button[data-id]').forEach(btn=>btn.addEventListener('click',()=>{ const id=Number(btn.dataset.id); const name=btn.dataset.name; langSelected.set(id,name); langInput.value=''; langSug.classList.add('hidden'); renderLangChips(); }));
        langSug.querySelector('button[data-create]')?.addEventListener('click', async (e)=>{
          const name = e.target.getAttribute('data-create');
          const resp = await fetch(`{{ route('languages.create') }}`, { method:'POST', headers:{ 'Content-Type':'application/x-www-form-urlencoded','Accept':'application/json','X-CSRF-TOKEN': csrf }, body: new URLSearchParams({ name }) });
          const json = await resp.json();
          langSelected.set(json.id, json.name); langInput.value=''; langSug.classList.add('hidden'); renderLangChips();
        });
      }catch(err){ /* ignore */ }
    }
    langInput?.addEventListener('input', e=>showLangSuggestions(e.target.value));
    document.addEventListener('click', e=>{ if(langSug && !langSug.contains(e.target) && e.target!==langInput){ langSug.classList.add('hidden'); }});
    renderLangChips();

    // Init
    show(steps[Math.min(Math.max(0, Number({{ (int)($profile->onboarding_step ?? 1) }}-1)), steps.length-1)]);
  </script>
</body>
</html>