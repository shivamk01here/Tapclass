<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Student Onboarding - htc</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
    tailwind.config = {
        darkMode: 'class',
        theme: { 
            extend: { 
                colors: { 
                    'black': '#10181B',
                    'primary': '#006cab',
                    'accent-yellow': '#FFBD59',
                    'text-subtle': '#667085',
                    'page-bg': '#fffcf0',
                    'footer-bg': '#334457',
                    'subscribe-bg': '#D1E3E6',
                    'steps-bg': '#b6e1e3',
                }, 
                fontFamily: { 
                    'sans': ['Poppins','sans-serif'],
                    'heading': ['Anton', 'sans-serif']
                },
                boxShadow: {
                    'header-chunky': '0 8px 0 0 #10181B',
                    'button-chunky': '0 4px 0 0 #10181B',
                    'button-chunky-hover': '0 2px 0 0 #10181B',
                    'button-chunky-active': '0 0 0 0 #10181B',
                },
                spacing: { '0.5': '2px', '1': '4px', },
                fontSize: {
                    'xxs': '0.825rem',
                    'hero-lg': '4.2rem',
                    'hero-md': '2.5rem',
                    'h2': '2rem',
                    'h3': '1.5rem',
                }
            } 
        }
    };
    </script>
    
    <style>
        .form-panel::-webkit-scrollbar { width: 6px; }
        .form-panel::-webkit-scrollbar-thumb { background-color: #FFBD59; border-radius: 3px; }
        .form-panel::-webkit-scrollbar-track { background-color: #f1f1f1; }
    </style>
</head>
<body class="bg-page-bg font-sans text-sm text-black">
    <div class="min-h-screen p-4 md:p-8 flex items-center justify-center">
        <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-header-chunky border-2 border-black grid grid-cols-1 md:grid-cols-5 overflow-hidden">
            
            <aside class="bg-subscribe-bg p-6 md:col-span-2">
                <div class="mb-6 flex items-center gap-2 text-black">
                    <i class="bi bi-mortarboard-fill text-accent-yellow text-2xl"></i>
                    <span class="font-bold text-lg">htc</span>
                </div>
                <h2 class="font-heading text-h2 uppercase mb-6">Create account</h2>
                <ol class="space-y-6">
                    <li class="flex items-start gap-3">
                        <div class="mt-0.5 w-6 h-6 rounded-full bg-accent-yellow text-black border-2 border-black flex items-center justify-center text-xs font-bold">1</div>
                        <div>
                            <p class="font-bold text-black">Personal Details</p>
                            <p class="text-xs text-text-subtle">DOB, photo, subjects</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 opacity-60" id="step2-ind">
                        <div class="mt-0.5 w-6 h-6 rounded-full border-2 border-black/30 text-text-subtle flex items-center justify-center text-xs font-bold">2</div>
                        <div>
                            <p class="font-bold text-black">Preferences</p>
                            <p class="text-xs text-text-subtle">City, mode, location</p>
                        </div>
                    </li>
                </ol>
            </aside>

            <main class="p-6 md:p-10 md:col-span-3 space-y-10 form-panel overflow-y-auto max-h-[90vh]">
                <div id="global-alert" class="hidden p-3 rounded-lg border text-sm"></div>
                @if(session('warning'))
                    <div class="p-3 rounded-lg border border-yellow-300 bg-yellow-50 text-yellow-800">{{ session('warning') }}</div>
                @endif

                <section id="step1">
                    <h3 class="font-heading text-h3 uppercase mb-4">Your personal details</h3>
                    <form id="form-step1" class="space-y-4" method="POST" action="{{ route('student.onboarding.step1') }}" enctype="multipart/form-data">
                        <div id="alert-step1" class="hidden p-3 rounded-lg border text-xs"></div>
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-black mb-1.5">Date of birth</label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($profile->date_of_birth ?? null)->format('Y-m-d')) }}" 
                                       class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none" required />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-black mb-1.5">Display photo</label>
                                <input type="file" name="profile_picture" accept="image/*" 
                                       class="w-full text-sm text-black file:mr-3 file:px-3 file:py-1.5 file:rounded-lg file:border-0 file:bg-accent-yellow file:font-bold file:text-black hover:file:bg-accent-yellow/80" />
                                <div class="mt-2 flex items-center gap-3">
@php
                                    $pp = $user->profile_picture ?? '';
                                    $ppUrl = $pp ? (\Illuminate\Support\Str::startsWith($pp, ['/storage','http'])) ? asset(ltrim($pp,'/')) : asset('storage/'.$pp) : '';
                                @endphp
                                    <img id="dp-preview" src="{{ $ppUrl }}" class="w-16 h-16 rounded-full object-cover border-2 border-black {{ $pp ? '' : 'hidden' }}"/>
                                    <p class="text-xs text-text-subtle">Preview</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-black mb-1.5">Subjects of interest</label>
                            <div class="relative">
                                <input id="subject-input" type="text" 
                                       class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none" 
                                       placeholder="Type to search subjects" />
                                <div id="subject-suggestions" class="absolute z-10 mt-1 w-full bg-white border-2 border-black rounded-lg shadow-md hidden max-h-48 overflow-auto"></div>
                            </div>
                            <div id="selected-subjects" class="mt-2 flex flex-wrap gap-2"></div>
                            <div id="subjects-hidden"></div>
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button class="bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                                Save and continue
                            </button>
                        </div>
                    </form>
                </section>

                <section id="step2" class="hidden">
                    <h3 class="font-heading text-h3 uppercase mb-4">Learning preferences</h3>
                    <form id="form-step2" class="space-y-4" method="POST" action="{{ route('student.onboarding.step2') }}">
                        <div id="alert-step2" class="hidden p-3 rounded-lg border text-xs"></div>
                        @csrf
                        <div>
                            <label class="block text-sm font-bold text-black mb-1.5">City</label>
                            <select name="city_id" class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none" required>
                                <option value="">Select city</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" @selected(($profile->city_id ?? null) == $city->id)>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-black mb-1.5">Preferred tutoring mode</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @php $modesOld = old('preferred_modes', $profile->preferred_tutoring_modes ?? []); @endphp
                                <label class="flex items-center gap-2 p-3 border-2 border-black rounded-lg bg-white">
                                    <input type="checkbox" name="preferred_modes[]" value="online" {{ in_array('online',$modesOld ?? []) ? 'checked' : '' }} class="w-4 h-4 text-primary rounded focus:ring-primary" />
                                    <span>Online</span>
                                </label>
                                <label class="flex items-center gap-2 p-3 border-2 border-black rounded-lg bg-white">
                                    <input type="checkbox" name="preferred_modes[]" value="offline_center" {{ in_array('offline_center',$modesOld ?? []) ? 'checked' : '' }} class="w-4 h-4 text-primary rounded focus:ring-primary" />
                                    <span>Offline - At our location</span>
                                </label>
                                <label class="flex items-center gap-2 p-3 border-2 border-black rounded-lg bg-white">
                                    <input type="checkbox" name="preferred_modes[]" value="offline_tutor" {{ in_array('offline_tutor',$modesOld ?? []) ? 'checked' : '' }} class="w-4 h-4 text-primary rounded focus:ring-primary" />
                                    <span>Offline - At the tutor's</span>
                                </label>
                            </div>
                        </div>

                        <div id="location-section" class="hidden space-y-3">
                            <p class="text-xs text-text-subtle">Please provide your location for offline tutoring.</p>
                            <div class="flex items-center gap-2">
                                <button type="button" id="btn-current-location" 
                                        class="bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-xs py-2 px-4 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                                    Use Current Location
                                </button>
                                <span id="loc-status" class="text-xs text-text-subtle"></span>
                            </div>
                            <input type="hidden" name="latitude" id="latitude" value="{{ $profile->latitude }}" />
                            <input type="hidden" name="longitude" id="longitude" value="{{ $profile->longitude }}" />
                            <div id="pin-wrapper" class="hidden">
                                <label class="block text-sm font-bold text-black mb-1.5">Pincode</label>
                                <input type="text" name="pin_code" class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none" placeholder="Enter pincode" />
                            </div>
                        </div>

                        <div class="pt-2 flex justify-between">
                            <button type="button" id="back-to-1" 
                                    class="bg-white border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                                Back
                            </button>
                            <button class="bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                                Finish
                            </button>
                        </div>
                    </form>
                </section>
            </main>
        </div>
    </div>

    <script>
        // --- Kept all your Javascript, just updated chip style ---
        
        const selected = new Map();
        const input = document.getElementById('subject-input');
        const list = document.getElementById('subject-suggestions');
        const chips = document.getElementById('selected-subjects');
        const hidden = document.getElementById('subjects-hidden');

        function renderChips(){
            chips.innerHTML = '';
            hidden.innerHTML = '';
            selected.forEach((name,id)=>{
                const chip = document.createElement('span');
                // Updated chip style
                chip.className = 'inline-flex items-center gap-1 bg-subscribe-bg text-primary px-2 py-1 rounded-full text-xs font-medium';
                chip.innerHTML = `<span>${name}</span><button type="button" aria-label="remove" class="ml-1 font-bold">×</button>`;
                chip.querySelector('button').addEventListener('click',()=>{ selected.delete(id); renderChips(); });
                chips.appendChild(chip);
                const h = document.createElement('input'); h.type='hidden'; h.name='subjects[]'; h.value=id; hidden.appendChild(h);
            });
        }

        async function showSuggestions(filter){
            const q = String(filter || '').trim();
            if(!q){ list.classList.add('hidden'); list.innerHTML=''; return; }
            try{
                const res = await fetch(`{{ route('subjects.suggest') }}?q=${encodeURIComponent(q)}`, { headers: { 'Accept':'application/json' } });
                const matches = await res.json();
                const filtered = matches.filter(m => !selected.has(m.id));
                if(filtered.length===0){ list.classList.add('hidden'); list.innerHTML=''; return; }
                list.innerHTML = filtered.map(m=>`<button type=\"button\" data-id=\"${m.id}\" class=\"w-full text-left px-3 py-2 hover:bg-gray-100\">${m.name}</button>`).join('');
                list.classList.remove('hidden');
                list.querySelectorAll('button').forEach(btn=>btn.addEventListener('click',()=>{selected.set(Number(btn.dataset.id), btn.textContent); input.value=''; list.classList.add('hidden'); renderChips();}));
            } catch(e){ /* ignore */ }
        }

        input?.addEventListener('input', (e)=> showSuggestions(e.target.value));
        document.addEventListener('click', (e)=>{ if(!list.contains(e.target) && e.target!==input){ list.classList.add('hidden'); }});
        renderChips();

        function showAlert(el, msg, kind='error'){
            el.classList.remove('hidden');
            el.className = 'p-3 rounded-lg border text-sm ' + (kind==='error' ? 'bg-red-50 border-red-200 text-red-700' : 'bg-green-50 border-green-200 text-green-700');
            el.innerHTML = msg;
        }
        function clearAlert(el){ el.classList.add('hidden'); el.innerHTML=''; }

        const step2Ind = document.getElementById('step2-ind');
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const backBtn = document.getElementById('back-to-1');

        @if(session('step1_saved'))
            step1.classList.add('hidden'); step2.classList.remove('hidden'); 
            step2Ind.classList.remove('opacity-60');
            // Update step indicator styles
            step2Ind.querySelector('div').className = 'mt-0.5 w-6 h-6 rounded-full bg-accent-yellow text-black border-2 border-black flex items-center justify-center text-xs font-bold';
        @endif

        backBtn?.addEventListener('click', ()=>{ 
            step2.classList.add('hidden'); 
            step1.classList.remove('hidden'); 
            step2Ind.classList.add('opacity-60');
            step2Ind.querySelector('div').className = 'mt-0.5 w-6 h-6 rounded-full border-2 border-black/30 text-text-subtle flex items-center justify-center text-xs font-bold';
        });

        const modeInputs = document.querySelectorAll('input[name="preferred_modes[]"]');
        const locSection = document.getElementById('location-section');
        const pinWrapper = document.getElementById('pin-wrapper');
        function updateLocationUI(){
            let anyOffline = false;
            modeInputs.forEach(i=>{ if(i.checked && (i.value==='offline_center'||i.value==='offline_tutor')) anyOffline=true; });
            locSection.classList.toggle('hidden', !anyOffline);
        }
        modeInputs.forEach(i=> i.addEventListener('change', updateLocationUI));
        updateLocationUI();

        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const f1 = document.getElementById('form-step1');
        const f2 = document.getElementById('form-step2');
        
        f1?.addEventListener('submit', async (e)=>{
            e.preventDefault();
            clearAlert(document.getElementById('alert-step1'));
            const body = new FormData(f1);
            try{
                const res = await fetch(f1.action, { method:'POST', headers: { 'Accept':'application/json', 'X-CSRF-TOKEN': csrf }, body });
                if(res.ok){
                    step1.classList.add('hidden'); step2.classList.remove('hidden'); 
                    step2Ind.classList.remove('opacity-60');
                    step2Ind.querySelector('div').className = 'mt-0.5 w-6 h-6 rounded-full bg-accent-yellow text-black border-2 border-black flex items-center justify-center text-xs font-bold';
                    showAlert(document.getElementById('global-alert'), 'Saved. Continue to preferences.', 'success');
                    return;
                }
                if(res.status===422){
                    const data = await res.json();
                    const msgs = Object.values(data.errors||{}).flat().join('<br>');
                    showAlert(document.getElementById('alert-step1'), msgs, 'error');
                } else {
                    showAlert(document.getElementById('alert-step1'), 'Failed to save. Try again.', 'error');
                }
            }catch(err){ showAlert(document.getElementById('alert-step1'), 'Network error. Try again.', 'error'); }
        });

        f2?.addEventListener('submit', async (e)=>{
            e.preventDefault();
            clearAlert(document.getElementById('alert-step2'));
            const body = new FormData(f2);
            try{
                const res = await fetch(f2.action, { method:'POST', headers: { 'Accept':'application/json', 'X-CSRF-TOKEN': csrf }, body });
                if(res.ok){
                    const data = await res.json().catch(()=>({}));
                    window.location.href = (data && data.redirect) ? data.redirect : '{{ route('student.dashboard') }}';
                    return;
                }
                if(res.status===422){
                    const data = await res.json();
                    const msgs = Object.values(data.errors||{}).flat().join('<br>');
                    showAlert(document.getElementById('alert-step2'), msgs, 'error');
                } else {
                    showAlert(document.getElementById('alert-step2'), 'Failed to save. Try again.', 'error');
                }
            }catch(err){ showAlert(document.getElementById('alert-step2'), 'Network error. Try again.', 'error'); }
        });

        const btnLoc = document.getElementById('btn-current-location');
        const latEl = document.getElementById('latitude');
        const lngEl = document.getElementById('longitude');
        const statusEl = document.getElementById('loc-status');
        btnLoc?.addEventListener('click', ()=>{
            statusEl.textContent = 'Detecting location...';
            if(!navigator.geolocation){ statusEl.textContent='Geolocation not supported.'; pinWrapper.classList.remove('hidden'); return; }
            navigator.geolocation.getCurrentPosition((pos)=>{
                latEl.value = pos.coords.latitude.toFixed(6);
                lngEl.value = pos.coords.longitude.toFixed(6);
                statusEl.textContent = 'Location captured.';
                pinWrapper.classList.add('hidden');
            }, (err)=>{
                statusEl.textContent = 'Could not detect automatically. Please enter pincode.';
                pinWrapper.classList.remove('hidden');
            }, { enableHighAccuracy:true, timeout:8000, maximumAge:0 });
        });

        const fileInput = document.querySelector('input[name="profile_picture"]');
        const prev = document.getElementById('dp-preview');
        fileInput?.addEventListener('change', (e)=>{
            const f = e.target.files?.[0]; if(!f) return; const url = URL.createObjectURL(f); prev.src=url; prev.classList.remove('hidden');
        });
    </script>
</body>
</html>