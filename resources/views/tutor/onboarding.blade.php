<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tutor Onboarding - Htc</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
      tailwind.config = {
        darkMode: 'class',
        theme: {
          extend: {
            colors: { primary: '#13a4ec', secondary: '#FFA500', 'background-light': '#f6f7f8', 'background-dark': '#101c22' },
            fontFamily: { display: ['Manrope','sans-serif'] },
            boxShadow: { brand: '0 10px 25px -5px rgba(19,164,236,0.25), 0 8px 10px -6px rgba(19,164,236,0.3)' }
          }
        }
      };
    </script>
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-background-light font-display text-gray-900">
    <header class="bg-white/80 backdrop-blur border-b sticky top-0 z-10">
        <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined">school</span>
                </div>
                <div class="text-lg font-semibold">Welcome onboard {{ $user->name }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-sm text-red-600 font-medium hover:underline">Logout</button>
            </form>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-10 sm:py-16">
        <div class="mb-6" data-aos="fade-in">
            <div class="flex items-center justify-between mb-2">
                <span id="step-label" class="text-sm font-semibold text-gray-700">Step <span id="step-num">1</span> of 6</span>
                <span id="progress-percent" class="text-sm font-semibold text-primary">0%</span>
            </div>
            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                <div id="progress-bar" class="h-full bg-primary transition-all duration-500" style="width: 0%"></div>
            </div>
        </div>

        <div id="alerts"></div>

        <section id="step-basic" class="step hidden" data-aos="fade-up" data-aos-delay="100">
            <div class="mx-auto max-w-2xl bg-white rounded-2xl border border-gray-100 shadow p-6 sm:p-8">
              <img src="{{ asset('images/onboarding/welcome.png') }}" alt="Welcome" class="mx-auto h-28 mb-6 hidden sm:block" onerror="this.style.display='none'">
              <div class="flex items-center gap-3 mb-4">
                  <span class="material-symbols-outlined text-primary">badge</span>
                  <h2 class="text-2xl font-bold text-gray-900">Basic Information</h2>
              </div>
              <form id="form-basic" class="space-y-4">
                  <div>
                      <label class="block text-sm font-medium text-gray-700 mb-2">Bio <span class="text-red-500">*</span></label>
                      <textarea name="bio" rows="4" class="w-full rounded-lg border border-gray-300 focus:border-primary focus:ring-primary" placeholder="Tell students about yourself (50-500 chars)">{{ $profile->bio }}</textarea>
                  </div>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                      <div>
                          <label class="block text-sm font-medium text-gray-700 mb-2">Experience (years) <span class="text-red-500">*</span></label>
                          <input name="experience_years" type="number" min="0" class="w-full rounded-lg border border-gray-300 focus:border-primary focus:ring-primary" placeholder="e.g., 3" value="{{ $profile->experience_years }}"/>
                      </div>
                      <div>
                          <label class="block text-sm font-medium text-gray-700 mb-2">Education <span class="text-red-500">*</span></label>
                          <input name="education" type="text" class="w-full rounded-lg border border-gray-300 focus:border-primary focus:ring-primary" placeholder="Highest qualification" value="{{ $profile->education }}"/>
                      </div>
                  </div>
                  <div class="flex justify-end">
                      <button type="button" data-next class="px-6 py-2.5 bg-primary text-white font-semibold rounded-lg hover:shadow-brand hover:-translate-y-0.5 transition-all">Save & Continue →</button>
                  </div>
              </form>
            </div>
        </section>

        <section id="step-subjects" class="step hidden" data-aos="fade-up" data-aos-delay="100">
            <div class="mx-auto max-w-2xl bg-white rounded-2xl border border-gray-100 shadow p-6 sm:p-8">
              <img src="{{ asset('images/onboarding/subjects.png') }}" alt="Subjects" class="mx-auto h-28 mb-6 hidden sm:block" onerror="this.style.display='none'">
              <div class="flex items-center gap-3 mb-2">
                  <span class="material-symbols-outlined text-primary">menu_book</span>
                  <h2 class="text-2xl font-bold text-gray-900">Subjects & Rates</h2>
              </div>
              <p class="text-sm text-gray-600 mb-3">Add at least one subject you teach with availability and rates.</p>
              <form id="form-subjects" class="space-y-3">
                  <div id="subjects-container" class="space-y-3"></div>
                  <button type="button" id="add-subject" class="text-primary text-sm font-semibold hover:underline">+ Add subject</button>
                  <div class="flex justify-between mt-2">
                      <button type="button" data-prev class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">← Back</button>
                      <button type="button" data-next class="px-6 py-2.5 bg-primary text-white font-semibold rounded-lg hover:shadow-brand hover:-translate-y-0.5 transition-all">Save & Continue →</button>
                  </div>
              </form>
            </div>
        </section>

        <section id="step-documents" class="step hidden" data-aos="fade-up" data-aos-delay="100">
            <div class="mx-auto max-w-2xl bg-white rounded-2xl border border-gray-100 shadow p-6 sm:p-8">
              <img src="{{ asset('images/onboarding/documents.png') }}" alt="Documents" class="mx-auto h-28 mb-6 hidden sm:block" onerror="this.style.display='none'">
              <div class="flex items-center gap-3 mb-4">
                  <span class="material-symbols-outlined text-primary">assignment_turned_in</span>
                  <h2 class="text-2xl font-bold text-gray-900">Verification Documents</h2>
              </div>
              <div class="grid sm:grid-cols-3 gap-4 mb-4">
                <div class="rounded-xl border border-gray-200 p-4 bg-white/70">
                  <div class="w-10 h-10 rounded-md bg-primary/10 text-primary flex items-center justify-center mb-2"><span class="material-symbols-outlined">credit_card</span></div>
                  <p class="font-semibold">Government ID</p>
                  <p class="text-xs text-gray-600">Passport/Aadhaar/PAN/Driver’s License (JPG/PNG, max 5MB)</p>
                </div>
                <div class="rounded-xl border border-gray-200 p-4 bg-white/70">
                  <div class="w-10 h-10 rounded-md bg-primary/10 text-primary flex items-center justify-center mb-2"><span class="material-symbols-outlined">school</span></div>
                  <p class="font-semibold">Degree Certificate</p>
                  <p class="text-xs text-gray-600">Highest education certificate (JPG/PNG, max 5MB)</p>
                </div>
                <div class="rounded-xl border border-gray-200 p-4 bg-white/70">
                  <div class="w-10 h-10 rounded-md bg-primary/10 text-primary flex items-center justify-center mb-2"><span class="material-symbols-outlined">description</span></div>
                  <p class="font-semibold">CV/Resume (Optional)</p>
                  <p class="text-xs text-gray-600">PDF/DOC/DOCX, max 5MB</p>
                </div>
              </div>
              <form id="form-documents" class="space-y-4" enctype="multipart/form-data">
                  <div>
                      <label class="block text-sm font-medium text-gray-700 mb-2">Upload Government ID <span class="text-red-500">*</span></label>
                      <input type="file" name="government_id" accept="image/*" class="w-full rounded-lg border border-gray-300 file:mr-4 file:rounded-md file:border-0 file:bg-primary file:text-white file:px-4 file:py-2" />
                  </div>
                  <div>
                      <label class="block text-sm font-medium text-gray-700 mb-2">Upload Degree Certificate <span class="text-red-500">*</span></label>
                      <input type="file" name="degree_certificate" accept="image/*" class="w-full rounded-lg border border-gray-300 file:mr-4 file:rounded-md file:border-0 file:bg-primary file:text-white file:px-4 file:py-2" />
                  </div>
                  <div>
                      <label class="block text-sm font-medium text-gray-700 mb-2">Upload CV (Optional)</label>
                      <input type="file" name="cv" accept=".pdf,.doc,.docx" class="w-full rounded-lg border border-gray-300 file:mr-4 file:rounded-md file:border-0 file:bg-secondary file:text-white file:px-4 file:py-2" />
                  </div>
                  <div class="flex justify-between">
                      <button type="button" data-prev class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">← Back</button>
                      <button type="button" data-next class="px-6 py-2.5 bg-primary text-white font-semibold rounded-lg hover:shadow-brand hover:-translate-y-0.5 transition-all">Save & Continue →</button>
                  </div>
              </form>
            </div>
        </section>

        <section id="step-location" class="step hidden" data-aos="fade-up" data-aos-delay="100">
            <div class="mx-auto max-w-2xl bg-white rounded-2xl border border-gray-100 shadow p-6 sm:p-8">
              <img src="{{ asset('images/onboarding/location.png') }}" alt="Location" class="mx-auto h-28 mb-6 hidden sm:block" onerror="this.style.display='none'">
              <div class="flex items-center gap-3 mb-4">
                  <span class="material-symbols-outlined text-primary">pin_drop</span>
                  <h2 class="text-2xl font-bold text-gray-900">Location & Preferences</h2>
              </div>
              <form id="form-location" class="space-y-3">
                  <input name="location" class="w-full rounded-lg border border-gray-300 focus:border-primary focus:ring-primary" placeholder="Location" value="{{ $profile->location }}" />
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                      <input name="city" class="rounded-lg border border-gray-300 focus:border-primary focus:ring-primary" placeholder="City" value="{{ $profile->city }}" />
                      <input name="state" class="rounded-lg border border-gray-300 focus:border-primary focus:ring-primary" placeholder="State" value="{{ $profile->state }}" />
                  </div>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                      <input name="latitude" type="number" step="any" class="rounded-lg border border-gray-300 focus:border-primary focus:ring-primary" placeholder="Latitude" value="{{ $profile->latitude }}" />
                      <input name="longitude" type="number" step="any" class="rounded-lg border border-gray-300 focus:border-primary focus:ring-primary" placeholder="Longitude" value="{{ $profile->longitude }}" />
                  </div>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                      <select name="teaching_mode" class="rounded-lg border border-gray-300 focus:border-primary focus:ring-primary">
                          <option value="">Teaching mode</option>
                          <option value="online" {{ $profile->teaching_mode==='online' ? 'selected' : '' }}>Online</option>
                          <option value="offline" {{ $profile->teaching_mode==='offline' ? 'selected' : '' }}>Offline</option>
                          <option value="both" {{ $profile->teaching_mode==='both' ? 'selected' : '' }}>Both</option>
                      </select>
                      <input name="hourly_rate" type="number" step="0.01" class="rounded-lg border border-gray-300 focus:border-primary focus:ring-primary" placeholder="Default hourly rate" value="{{ $profile->hourly_rate }}" />
                  </div>
                  <div class="flex justify-between"><button type="button" data-prev class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">← Back</button><button type="button" data-next class="px-6 py-2.5 bg-primary text-white font-semibold rounded-lg hover:shadow-brand hover:-translate-y-0.5 transition-all">Save & Continue →</button></div>
              </form>
            </div>
        </section>

        <section id="step-phone" class="step hidden" data-aos="fade-up" data-aos-delay="100">
            <div class="mx-auto max-w-2xl bg-white rounded-2xl border border-gray-100 shadow p-6 sm:p-8">
              <img src="{{ asset('images/onboarding/otp.png') }}" alt="Phone" class="mx-auto h-28 mb-6 hidden sm:block" onerror="this.style.display='none'">
              <div class="flex items-center gap-3 mb-4">
                  <span class="material-symbols-outlined text-primary">sms</span>
                  <h2 class="text-2xl font-bold text-gray-900">Phone Verification</h2>
              </div>
              <form id="form-phone" class="space-y-3">
                  <input name="phone" class="w-full rounded-lg border border-gray-300 focus:border-primary focus:ring-primary" placeholder="Phone number" value="{{ $user->phone }}" />
                  <p class="text-sm text-gray-600">You'll receive an OTP (use 123456 for now).</p>
                  <div class="flex justify-between"><button type="button" data-prev class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">← Back</button><button type="button" data-next class="px-6 py-2.5 bg-primary text-white font-semibold rounded-lg hover:shadow-brand hover:-translate-y-0.5 transition-all">Send OTP →</button></div>
              </form>
            </div>
        </section>

        <section id="step-otp" class="step hidden" data-aos="fade-up" data-aos-delay="100">
            <div class="mx-auto max-w-2xl bg-white rounded-2xl border border-gray-100 shadow p-6 sm:p-8">
              <img src="{{ asset('images/onboarding/otp.png') }}" alt="OTP" class="mx-auto h-28 mb-6 hidden sm:block" onerror="this.style.display='none'">
              <div class="flex items-center gap-3 mb-4">
                  <span class="material-symbols-outlined text-primary">verified</span>
                  <h2 class="text-2xl font-bold text-gray-900">Enter OTP</h2>
              </div>
              <form id="form-otp" class="space-y-3">
                  <input name="otp" class="w-full rounded-lg border border-gray-300 focus:border-primary focus:ring-primary" placeholder="Enter 123456" />
                  <div class="flex justify-between"><button type="button" data-prev class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">← Back</button><button type="button" id="btn-complete" class="px-6 py-2.5 bg-green-600 text-white font-semibold rounded-lg hover:shadow-lg hover:-translate-y-0.5 transition-all">Verify & Finish →</button></div>
              </form>
            </div>
        </section>
    </main>

    <script>
        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const subjectsList = @json(\App\Models\Subject::where('is_active', true)->orderBy('name')->get(['id','name']));
        const steps = ['basic','subjects','documents','location','phone','otp'];

        // --- BUG FIX ---
        // OLD: let current = Math.max(1, Number(@json($profile->onboarding_step ?? 0)) + 1);
        // This logic was flawed. If onboarding_step was 0 (meaning 'basic' is done), it would show 0+1=1,
        // keeping the user on the 'basic' step.
        // NEW: We assume $profile->onboarding_step is the 1-based step number the user is ON.
        // We default to 1, and clamp it to the max number of steps.
        let current = Math.min(Math.max(1, Number(@json($profile->onboarding_step ?? 1))), steps.length);

        function show(stepIndex){
            document.querySelectorAll('.step').forEach(s => s.classList.add('hidden'));
            const id = `step-${steps[stepIndex-1]}`;
            const el = document.getElementById(id);
            if (el) {
                el.classList.remove('hidden');
            }
            // --- BUG FIX ---
            // OLD: el.setAttribute('data-aos', 'fade-up');
            // This was the cause of your "blank screen". AOS was initialized before this
            // attribute was set, so the element was stuck at opacity:0.
            // The `data-aos` attribute is now in the HTML.

            const pct = Math.round((stepIndex-1) / (steps.length) * 100);
            document.getElementById('progress-bar').style.width = pct + '%';
            document.getElementById('progress-percent').innerText = pct + '%';
            document.getElementById('step-num').innerText = stepIndex;

            // NEW: Tell AOS to refresh. This will detect the newly shown element and animate it.
            if (window.AOS) AOS.refresh();
        }

        // --- UI/UX IMPROVEMENT ---
        // New, more modern alert function
        function alertMsg(kind, msg){
            const el = document.getElementById('alerts');
            const isError = kind === 'error';
            const icon = isError ? 'warning' : 'check_circle';
            const classes = isError
                ? 'bg-red-50 text-red-700 border-red-200'
                : 'bg-green-50 text-green-700 border-green-200';
            
            el.innerHTML = `<div class="mb-4 p-4 rounded-lg border ${classes} flex items-center gap-3" data-aos="fade-down">
                <span class="material-symbols-outlined">${icon}</span>
                <p>${msg}</p>
            </div>`;
            
            // Animate the new alert in
            if (window.AOS) AOS.refresh();
        }

        function clearErrors(form){
            form.querySelectorAll('.field-error').forEach(e=>e.remove());
            form.querySelectorAll('.border-red-500').forEach(e=>e.classList.remove('border-red-500'));
            document.getElementById('alerts').innerHTML='';
        }

        function dotToBracket(key){
            // subjects.0.subject_id -> subjects[0][subject_id]
            const parts = key.split('.');
            let out = parts.shift();
            parts.forEach(p=>{ out += `[${p}]`; });
            return out;
        }

        function renderErrors(errors, form){
            const messages = [];
            Object.entries(errors).forEach(([k,v])=>{
                const name = dotToBracket(k);
                const input = form.querySelector(`[name="${name}"]`);
                const msg = Array.isArray(v) ? v.join(', ') : String(v);
                if(input){
                    input.classList.add('border-red-500');
                    const p = document.createElement('p');
                    p.className = 'field-error text-xs text-red-600 mt-1';
                    p.innerHTML = msg;
                    input.insertAdjacentElement('afterend', p);
                } else {
                    messages.push(msg);
                }
            });
            if(messages.length){
                alertMsg('error', messages.join('<br>'));
            }
        }

        async function postForm(url, form){
            const isFile = form.enctype === 'multipart/form-data' || [...form.querySelectorAll('input[type=file]')].length>0;
            const body = isFile ? new FormData(form) : new URLSearchParams(new FormData(form));
            if(!isFile){ body.append('_token', csrf); body.append('step', form.id.replace('form-','')); }
            const headers = isFile
                ? { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
                : { 'Content-Type':'application/x-www-form-urlencoded', 'Accept': 'application/json' };
            const res = await fetch(url, {
                method:'POST',
                headers,
                body: isFile ? (()=>{ const fd=new FormData(form); fd.append('step', form.id.replace('form-','')); return fd; })() : body
            });
            return res.json();
        }

        function addSubjectRow(){
            const wrap = document.getElementById('subjects-container');
            const idx = wrap.children.length;
            const select = subjectsList.map(s=>`<option value="${s.id}">${s.name}</option>`).join('');
            const row = document.createElement('div');
            row.className = 'p-3 bg-gray-50 rounded-lg border';
            row.innerHTML = `
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <select name="subjects[${idx}][subject_id]" class="rounded-lg border-gray-300 focus:border-primary focus:ring-primary">${select}</select>
                    <div class="flex items-center gap-4 py-2">
                        <label class="text-sm flex items-center"><input type="checkbox" name="subjects[${idx}][is_online_available]" value="1" class="mr-1.5 rounded text-primary focus:ring-primary">Online</label>
                        <label class="text-sm flex items-center"><input type="checkbox" name="subjects[${idx}][is_offline_available]" value="1" class="mr-1.5 rounded text-primary focus:ring-primary">Offline</label>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-2">
                    <input type="number" step="0.01" name="subjects[${idx}][online_rate]" placeholder="Online Rate (₹)" class="rounded-lg border-gray-300 focus:border-primary focus:ring-primary" />
                    <input type="number" step="0.01" name="subjects[${idx}][offline_rate]" placeholder="Offline Rate (₹)" class="rounded-lg border-gray-300 focus:border-primary focus:ring-primary" />
                </div>`;
            wrap.appendChild(row);
        }

        document.getElementById('add-subject').addEventListener('click', ()=>addSubjectRow());
        addSubjectRow();

        // Next buttons
        document.querySelectorAll('[data-next]').forEach(btn=>{
            btn.addEventListener('click', async (e)=>{
                const form = e.target.closest('form');
                btn.disabled = true; // Prevent double-clicks
                btn.innerHTML = 'Saving...';
                try {
                    clearErrors(form);
                    const json = await postForm(`{{ route('tutor.onboarding.save-step') }}`, form);
                    if(!json.success){
                        if (json.errors) {
                            renderErrors(json.errors, form);
                            return;
                        }
                        throw new Error(json.message || 'Failed to save. Please check your input.');
                    }
                    current = Math.min(steps.length, current+1);
                    show(current);
                    alertMsg('ok','Progress saved successfully!');
                } catch(err){
                    alertMsg('error', err.message);
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = 'Save & Continue →';
                }
            });
        });

        document.getElementById('btn-complete').addEventListener('click', async (e)=>{
            const form = document.getElementById('form-otp');
            const btn = e.target;
            btn.disabled = true;
            btn.innerHTML = 'Verifying...';
            try {
                const body = new URLSearchParams(new FormData(form));
                body.append('_token', csrf);
                const res = await fetch(`{{ route('tutor.onboarding.verify-otp') }}`, { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'}, body });
                const json = await res.json();
                if(!json.success){ throw new Error(json.message || 'OTP invalid'); }
                alertMsg('ok', 'Verification successful! Redirecting...');
                window.location = json.redirect;
            } catch(err){
                alertMsg('error', err.message);
                btn.disabled = false;
                btn.innerHTML = 'Verify & Finish →';
            }
        });

        // Back buttons handler
        document.addEventListener('click', (e)=>{
            if (e.target && e.target.matches('[data-prev]')) {
                e.preventDefault();
                if (current > 1) { current -= 1; show(current); }
            }
        });

        // Auto-verify from ?otp=
        const qp = new URLSearchParams(window.location.search);
        const qpOtp = qp.get('otp');
        if (qpOtp) {
            current = steps.length;
            show(current);
            const otpInput = document.querySelector('#form-otp [name="otp"]');
            if (otpInput) otpInput.value = qpOtp;
            document.getElementById('btn-complete').click();
        }

        // Initialize
        if (window.AOS) AOS.init({ duration: 400, easing: 'ease-out', once: true });
        show(current);
    </script>
</body>
</html>