<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Tutor Onboarding - htc</title>
    
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
            
            <!-- Left Sidebar -->
            <aside class="bg-subscribe-bg p-6 md:col-span-2">
                <div class="mb-6 flex items-center gap-2 text-black">
                    <i class="bi bi-mortarboard-fill text-accent-yellow text-2xl"></i>
                    <span class="font-bold text-lg">htc</span>
                </div>
                <h2 class="font-heading text-h2 uppercase mb-6">Tutor Registration</h2>
                <ol class="space-y-6">
                    <li class="flex items-start gap-3">
                        <div class="mt-0.5 w-6 h-6 rounded-full bg-accent-yellow text-black border-2 border-black flex items-center justify-center text-xs font-bold step-dot" data-step="1">1</div>
                        <div>
                            <p class="font-bold text-black">Basic Info</p>
                            <p class="text-xs text-text-subtle">Photo, bio, languages</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 opacity-60">
                        <div class="mt-0.5 w-6 h-6 rounded-full border-2 border-black/30 text-text-subtle flex items-center justify-center text-xs font-bold step-dot" data-step="2">2</div>
                        <div>
                            <p class="font-bold text-black">Subjects & Rates</p>
                            <p class="text-xs text-text-subtle">Teaching subjects, pricing</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 opacity-60">
                        <div class="mt-0.5 w-6 h-6 rounded-full border-2 border-black/30 text-text-subtle flex items-center justify-center text-xs font-bold step-dot" data-step="3">3</div>
                        <div>
                            <p class="font-bold text-black">Documents</p>
                            <p class="text-xs text-text-subtle">ID, certificates</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 opacity-60">
                        <div class="mt-0.5 w-6 h-6 rounded-full border-2 border-black/30 text-text-subtle flex items-center justify-center text-xs font-bold step-dot" data-step="4">4</div>
                        <div>
                            <p class="font-bold text-black">Location & Mode</p>
                            <p class="text-xs text-text-subtle">City, teaching preferences</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 opacity-60">
                        <div class="mt-0.5 w-6 h-6 rounded-full border-2 border-black/30 text-text-subtle flex items-center justify-center text-xs font-bold step-dot" data-step="5">5</div>
                        <div>
                            <p class="font-bold text-black">Phone</p>
                            <p class="text-xs text-text-subtle">Verify phone number</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 opacity-60">
                        <div class="mt-0.5 w-6 h-6 rounded-full border-2 border-black/30 text-text-subtle flex items-center justify-center text-xs font-bold step-dot" data-step="6">6</div>
                        <div>
                            <p class="font-bold text-black">OTP</p>
                            <p class="text-xs text-text-subtle">Enter verification code</p>
                        </div>
                    </li>
                </ol>
            </aside>

            <!-- Main Content -->
            <main class="p-6 md:p-10 md:col-span-3 space-y-10 form-panel overflow-y-auto max-h-[90vh]">
                <div id="global-alert" class="hidden p-3 rounded-lg border text-sm"></div>

                <!-- Step 1: Basic Info -->
                <section id="step-basic">
                    <h3 class="font-heading text-h3 uppercase mb-4">Your basic information</h3>
                    <form id="form-basic" class="space-y-4" enctype="multipart/form-data">
                        <div id="alert-basic" class="hidden p-3 rounded-lg border text-xs"></div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-black mb-1.5">Profile photo</label>
                                <input type="file" name="profile_photo" accept="image/*" 
                                       class="w-full text-sm text-black file:mr-3 file:px-3 file:py-1.5 file:rounded-lg file:border-0 file:bg-accent-yellow file:font-bold file:text-black hover:file:bg-accent-yellow/80" />
                                <div class="mt-2 flex items-center gap-3">
                                    <img id="photo-preview" src="" class="w-16 h-16 rounded-full object-cover border-2 border-black hidden"/>
                                    <p class="text-xs text-text-subtle">Preview</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-black mb-1.5">Gender</label>
                                <select name="gender" class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none" required>
                                    <option value="">Select gender</option>
                                    @foreach(['male'=>'Male','female'=>'Female','other'=>'Other'] as $gVal=>$gLabel)
                                        <option value="{{ $gVal }}" @selected(($profile->gender ?? '')===$gVal)>{{ $gLabel }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-black mb-1.5">About me / Bio</label>
                            <textarea name="bio" rows="4" 
                                      class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none" 
                                      placeholder="Describe your teaching philosophy, experience, and passion...">{{ $profile->bio }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-black mb-1.5">Highest qualification</label>
                                <select name="qualification" class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none" required>
                                    <option value="">Select qualification</option>
                                    @foreach(($qualifications ?? []) as $q)
                                        <option value="{{ $q }}" @selected(($profile->qualification ?? '')===$q)>{{ $q }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-black mb-1.5">Teaching experience</label>
                                <select name="experience_band" class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none" required>
                                    <option value="">Select experience</option>
                                    @foreach(['0-1','1-3','3-5','5-10','10+'] as $b)
                                        <option value="{{ $b }}">{{ $b }} years</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-black mb-1.5">Languages you speak</label>
                            <div class="relative">
                                <input id="language-input" type="text" 
                                       class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none" 
                                       placeholder="Type to search languages" />
                                <div id="language-suggestions" class="absolute z-10 mt-1 w-full bg-white border-2 border-black rounded-lg shadow-md hidden max-h-48 overflow-auto"></div>
                            </div>
                            <div id="selected-languages" class="mt-2 flex flex-wrap gap-2"></div>
                            <div id="languages-hidden"></div>
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button class="bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                                Save and continue
                            </button>
                        </div>
                    </form>
                </section>

                <!-- Step 2: Subjects & Rates -->
                <section id="step-subjects" class="hidden">
                    <h3 class="font-heading text-h3 uppercase mb-4">Subjects & rates</h3>
                    <form id="form-subjects" class="space-y-4">
                        <div id="alert-subjects" class="hidden p-3 rounded-lg border text-xs"></div>
                        
                        <div id="subjects-container" class="space-y-3"></div>
                        
                        <button type="button" id="add-subject" class="text-primary text-sm font-bold hover:underline">
                            + Add another subject
                        </button>

                        <div class="pt-2 flex justify-between">
                            <button type="button" data-prev 
                                    class="bg-white border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                                Back
                            </button>
                            <button class="bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                                Save and continue
                            </button>
                        </div>
                    </form>
                </section>

                <!-- Step 3: Documents -->
                <section id="step-documents" class="hidden">
                    <h3 class="font-heading text-h3 uppercase mb-4">Verification documents</h3>
                    <form id="form-documents" class="space-y-4" enctype="multipart/form-data">
                        <div id="alert-documents" class="hidden p-3 rounded-lg border text-xs"></div>
                        
                        <div>
                            <label class="block text-sm font-bold text-black mb-1.5">Government ID proof</label>
                            <input type="file" name="government_id" accept="image/*" 
                                   class="w-full text-sm text-black file:mr-3 file:px-3 file:py-1.5 file:rounded-lg file:border-0 file:bg-accent-yellow file:font-bold file:text-black hover:file:bg-accent-yellow/80" />
                            <p class="text-xs text-text-subtle mt-1">Used only for verification. Not shown publicly.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-black mb-1.5">Degree/Certification</label>
                            <input type="file" name="degree_certificate" accept="image/*" 
                                   class="w-full text-sm text-black file:mr-3 file:px-3 file:py-1.5 file:rounded-lg file:border-0 file:bg-accent-yellow file:font-bold file:text-black hover:file:bg-accent-yellow/80" />
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-black mb-1.5">CV (optional)</label>
                            <input type="file" name="cv" accept=".pdf,.doc,.docx" 
                                   class="w-full text-sm text-black file:mr-3 file:px-3 file:py-1.5 file:rounded-lg file:border-0 file:bg-primary file:font-bold file:text-white hover:file:bg-primary/80" />
                        </div>

                        <div class="pt-2 flex justify-between">
                            <button type="button" data-prev 
                                    class="bg-white border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                                Back
                            </button>
                            <button class="bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                                Save and continue
                            </button>
                        </div>
                    </form>
                </section>

                <!-- Step 4: Location & Mode -->
                <section id="step-location" class="hidden">
                    <h3 class="font-heading text-h3 uppercase mb-4">Location & tutoring mode</h3>
                    <form id="form-location" class="space-y-4">
                        <div id="alert-location" class="hidden p-3 rounded-lg border text-xs"></div>
                        
                        <div>
                            <label class="block text-sm font-bold text-black mb-1.5">City</label>
                            <select name="city_id" class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none" required>
                                <option value="">Select city</option>
                                @foreach(($cities ?? []) as $city)
                                    <option value="{{ $city->id }}" @selected(($profile->city ?? '') == $city->name)>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-black mb-1.5">Tutoring modes</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <label class="flex items-center gap-2 p-3 border-2 border-black rounded-lg bg-white">
                                    <input type="checkbox" name="modes[]" value="online" class="w-4 h-4 text-primary rounded focus:ring-primary" />
                                    <span>Online</span>
                                </label>
                                <label class="flex items-center gap-2 p-3 border-2 border-black rounded-lg bg-white">
                                    <input type="checkbox" name="modes[]" value="offline_my" class="w-4 h-4 text-primary rounded focus:ring-primary" />
                                    <span>Offline - At my location</span>
                                </label>
                                <label class="flex items-center gap-2 p-3 border-2 border-black rounded-lg bg-white">
                                    <input type="checkbox" name="modes[]" value="offline_student" id="mode-offline-student" class="w-4 h-4 text-primary rounded focus:ring-primary" />
                                    <span>Offline - At student's location</span>
                                </label>
                            </div>
                        </div>

                        <div id="travel-wrapper" class="hidden">
                            <label class="block text-sm font-bold text-black mb-1.5">Max travel radius</label>
                            <select name="travel_radius_km" class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none">
                                @foreach([3,5,10,15,20] as $km)
                                    <option value="{{ $km }}">{{ $km }} km</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-black mb-1.5">General online consultation rate (₹/hour)</label>
                            <input name="hourly_rate" type="number" step="0.01" 
                                   class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none" 
                                   placeholder="e.g., 500" value="{{ $profile->hourly_rate }}"/>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-black mb-1.5">Grades/levels you teach</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @foreach(($gradeBands ?? []) as $value=>$label)
                                    <label class="flex items-center gap-2 p-3 border-2 border-black rounded-lg bg-white">
                                        <input type="checkbox" name="grade_levels[]" value="{{ $value }}" class="w-4 h-4 text-primary rounded focus:ring-primary">
                                        <span>{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="space-y-3">
                            <p class="text-xs text-text-subtle">We need your location to match you with nearby students for offline sessions.</p>
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
                            <button type="button" data-prev 
                                    class="bg-white border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                                Back
                            </button>
                            <button class="bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                                Save and continue
                            </button>
                        </div>
                    </form>
                </section>

                <!-- Step 5: Phone -->
                <section id="step-phone" class="hidden">
                    <h3 class="font-heading text-h3 uppercase mb-4">Phone verification</h3>
                    <form id="form-phone" class="space-y-4">
                        <div id="alert-phone" class="hidden p-3 rounded-lg border text-xs"></div>
                        
                        <div>
                            <label class="block text-sm font-bold text-black mb-1.5">Phone number</label>
                            <input name="phone" type="tel" 
                                   class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none" 
                                   placeholder="Enter phone number" value="{{ $user->phone }}"/>
                            <p class="text-xs text-text-subtle mt-1">You'll receive an OTP (use 123456 for testing).</p>
                        </div>

                        <div class="pt-2 flex justify-between">
                            <button type="button" data-prev 
                                    class="bg-white border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                                Back
                            </button>
                            <button class="bg-accent-yellow border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                                Send OTP
                            </button>
                        </div>
                    </form>
                </section>

                <!-- Step 6: OTP -->
                <section id="step-otp" class="hidden">
                    <h3 class="font-heading text-h3 uppercase mb-4">Enter OTP</h3>
                    <form id="form-otp" class="space-y-4">
                        <div id="alert-otp" class="hidden p-3 rounded-lg border text-xs"></div>
                        
                        <div>
                            <label class="block text-sm font-bold text-black mb-1.5">Verification code</label>
                            <input name="otp" type="text" 
                                   class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none" 
                                   placeholder="Enter 6-digit OTP" maxlength="6"/>
                        </div>

                        <div class="pt-2 flex justify-between">
                            <button type="button" data-prev 
                                    class="bg-white border-2 border-black rounded-lg text-black font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                                Back
                            </button>
                            <button id="btn-complete" 
                                    class="bg-primary border-2 border-black rounded-lg text-white font-bold uppercase text-sm py-3 px-6 shadow-button-chunky relative top-0 transition-all duration-100 ease-in-out hover:top-0.5 hover:shadow-button-chunky-hover active:top-1 active:shadow-button-chunky-active">
                                Verify & Finish
                            </button>
                        </div>
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
                const li = dot.closest('li');
                
                if(n === idx) {
                    // Active step
                    dot.className = 'mt-0.5 w-6 h-6 rounded-full bg-accent-yellow text-black border-2 border-black flex items-center justify-center text-xs font-bold step-dot';
                    li.classList.remove('opacity-60');
                } else if(n < idx) {
                    // Completed step
                    dot.className = 'mt-0.5 w-6 h-6 rounded-full bg-primary text-white border-2 border-black flex items-center justify-center text-xs font-bold step-dot';
                    li.classList.remove('opacity-60');
                } else {
                    // Future step
                    dot.className = 'mt-0.5 w-6 h-6 rounded-full border-2 border-black/30 text-text-subtle flex items-center justify-center text-xs font-bold step-dot';
                    li.classList.add('opacity-60');
                }
            });
        }

        function show(id){
            document.querySelectorAll('main section').forEach(s=>s.classList.add('hidden'));
            document.getElementById('step-'+id).classList.remove('hidden');
            setStepper(stepIndex(id));
        }

        // Alerts
        function showAlert(el, msg, kind='error'){
            el.classList.remove('hidden');
            el.className = 'p-3 rounded-lg border text-sm ' + (kind==='error' ? 'bg-red-50 border-red-200 text-red-700' : 'bg-green-50 border-green-200 text-green-700');
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
            row.className='p-4 bg-subscribe-bg/30 rounded-lg border-2 border-black';
            row.innerHTML=`
                <div class="flex justify-end mb-2">
                    <button type="button" class="text-xs text-red-600 font-bold hover:underline" data-remove>Remove</button>
                </div>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-black mb-1">Subject</label>
                        <select name="subjects[${idx}][subject_id]" class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none">${options}</select>
                    </div>
                    <div class="flex items-center gap-4 py-2">
                        <label class="text-sm flex items-center gap-2">
                            <input type="checkbox" name="subjects[${idx}][is_online_available]" value="1" class="w-4 h-4 rounded text-primary focus:ring-primary">
                            <span class="font-medium">Online</span>
                        </label>
                        <label class="text-sm flex items-center gap-2">
                            <input type="checkbox" name="subjects[${idx}][is_offline_available]" value="1" class="w-4 h-4 rounded text-primary focus:ring-primary">
                            <span class="font-medium">Offline</span>
                        </label>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-black mb-1">Online Rate (₹/hour)</label>
                            <input type="number" step="0.01" name="subjects[${idx}][online_rate]" placeholder="500" class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-black mb-1">Offline Rate (₹/hour)</label>
                            <input type="number" step="0.01" name="subjects[${idx}][offline_rate]" placeholder="600" class="w-full rounded-lg border-2 border-black bg-white px-4 py-2.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/50 outline-none">
                        </div>
                    </div>
                </div>`;
            wrap.appendChild(row);
            row.querySelector('[data-remove]')?.addEventListener('click', ()=>{ row.remove(); });
        }
        document.getElementById('add-subject')?.addEventListener('click', addSubjectRow);
        addSubjectRow();

        // Travel radius toggle
        const offlineStudent = document.getElementById('mode-offline-student');
        const travelWrap = document.getElementById('travel-wrapper');
        function syncTravel(){ travelWrap.classList.toggle('hidden', !offlineStudent?.checked); }
        offlineStudent?.addEventListener('change', syncTravel);
        syncTravel();

        // Geolocation
        document.getElementById('btn-current-location')?.addEventListener('click', ()=>{
            const statusEl = document.getElementById('loc-status');
            const latEl = document.getElementById('latitude');
            const lngEl = document.getElementById('longitude');
            const pinWrapper = document.getElementById('pin-wrapper');
            
            statusEl.textContent='Detecting location...';
            if(!navigator.geolocation){ 
                statusEl.textContent='Geolocation not supported.'; 
                pinWrapper.classList.remove('hidden');
                return; 
            }
            navigator.geolocation.getCurrentPosition((pos)=>{
                latEl.value = pos.coords.latitude.toFixed(6);
                lngEl.value = pos.coords.longitude.toFixed(6);
                statusEl.textContent='Location captured.';
                pinWrapper.classList.add('hidden');
            }, ()=>{ 
                statusEl.textContent='Could not detect automatically. Please enter pincode below.'; 
                pinWrapper.classList.remove('hidden'); 
            }, { enableHighAccuracy:true, timeout:8000, maximumAge:0 });
        });

        // AJAX submit util
        async function ajaxPost(form){
            const isFile = form.enctype === 'multipart/form-data' || form.querySelector('input[type=file]');
            const headers = isFile ? { 'X-CSRF-TOKEN': csrf, 'Accept':'application/json' } : { 'Content-Type':'application/x-www-form-urlencoded', 'Accept':'application/json', 'X-CSRF-TOKEN': csrf };
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
                e.preventDefault(); 
                clearAlert(alert);
                try{ 
                    const json = await ajaxPost(form); 
                    show(nextId); 
                    showAlert(document.getElementById('global-alert'), 'Saved successfully!', 'success'); 
                }
                catch(ex){ 
                    const msgs = Object.values(ex.errors||{}).flat().join('<br>') || ex.message; 
                    showAlert(alert, msgs, 'error'); 
                }
            });
        }

        // Wire all forms
        wireForm('basic','subjects');
        wireForm('subjects','documents');
        wireForm('documents','location');
        wireForm('location','phone');
        wireForm('phone','otp');

        // OTP final step
        document.getElementById('form-otp')?.addEventListener('submit', async (e)=>{
            e.preventDefault();
            clearAlert(document.getElementById('alert-otp'));
            try{
                const body = new URLSearchParams(new FormData(e.target)); 
                body.append('_token', csrf);
                const res = await fetch(`{{ route('tutor.onboarding.verify-otp') }}`, { 
                    method:'POST', 
                    headers:{'Content-Type':'application/x-www-form-urlencoded', 'Accept':'application/json'}, 
                    body 
                });
                const json = await res.json();
                if(!json.success) throw new Error(json.message || 'OTP invalid');
                window.location.href = json.redirect;
            }catch(err){ 
                showAlert(document.getElementById('alert-otp'), err.message, 'error'); 
            }
        });

        // Back buttons
        document.addEventListener('click', (e)=>{
            if(e.target && e.target.matches('[data-prev]')){
                e.preventDefault();
                const visible = steps.findIndex(s=>!document.getElementById('step-'+s).classList.contains('hidden'));
                const prev = Math.max(0, visible-1); 
                show(steps[prev]);
            }
        });

        // Languages chips autocomplete
        const langSelected = new Map();
        const langInput = document.getElementById('language-input');
        const langSug = document.getElementById('language-suggestions');
        const langChips = document.getElementById('selected-languages');
        const langHidden = document.getElementById('languages-hidden');
        
        function renderLangChips(){
            if(!langChips) return;
            langChips.innerHTML=''; 
            langHidden.innerHTML='';
            langSelected.forEach((name,id)=>{
                const chip = document.createElement('span');
                chip.className='inline-flex items-center gap-1 bg-subscribe-bg text-primary px-2 py-1 rounded-full text-xs font-medium border border-primary/20';
                chip.innerHTML = `<span>${name}</span><button type="button" aria-label="remove" class="ml-1 font-bold">×</button>`;
                chip.querySelector('button').addEventListener('click',()=>{ 
                    langSelected.delete(id); 
                    renderLangChips(); 
                });
                langChips.appendChild(chip);
                const h = document.createElement('input'); 
                h.type='hidden'; 
                h.name='languages[]'; 
                h.value=id; 
                langHidden.appendChild(h);
            });
        }
        
        async function showLangSuggestions(q){
            if(!langSug) return;
            q = String(q || '').trim();
            if(!q){ 
                langSug.classList.add('hidden'); 
                langSug.innerHTML=''; 
                return; 
            }
            try{
                const res = await fetch(`{{ route('languages.suggest') }}?q=${encodeURIComponent(q)}`, { 
                    headers: { 'Accept':'application/json' } 
                });
                const arr = await res.json();
                const exists = arr.some(x=>x.name.toLowerCase()===q.toLowerCase());
                let html = arr.filter(x=>!langSelected.has(x.id)).map(x=>
                    `<button type="button" data-id="${x.id}" data-name="${x.name}" class="w-full text-left px-3 py-2 hover:bg-subscribe-bg">${x.name}</button>`
                ).join('');
                if(!exists){
                    html += `<button type="button" data-create="${q}" class="w-full text-left px-3 py-2 text-primary hover:bg-subscribe-bg font-medium">+ Add "${q}"</button>`;
                }
                langSug.innerHTML = html;
                langSug.classList.remove('hidden');
                langSug.querySelectorAll('button[data-id]').forEach(btn=>btn.addEventListener('click',()=>{ 
                    const id=Number(btn.dataset.id); 
                    const name=btn.dataset.name; 
                    langSelected.set(id,name); 
                    langInput.value=''; 
                    langSug.classList.add('hidden'); 
                    renderLangChips(); 
                }));
                langSug.querySelector('button[data-create]')?.addEventListener('click', async (e)=>{
                    const name = e.target.getAttribute('data-create');
                    const resp = await fetch(`{{ route('languages.create') }}`, { 
                        method:'POST', 
                        headers:{ 
                            'Content-Type':'application/x-www-form-urlencoded',
                            'Accept':'application/json',
                            'X-CSRF-TOKEN': csrf 
                        }, 
                        body: new URLSearchParams({ name }) 
                    });
                    const json = await resp.json();
                    langSelected.set(json.id, json.name); 
                    langInput.value=''; 
                    langSug.classList.add('hidden'); 
                    renderLangChips();
                });
            }catch(err){ /* ignore */ }
        }
        
        langInput?.addEventListener('input', e=>showLangSuggestions(e.target.value));
        document.addEventListener('click', e=>{ 
            if(langSug && !langSug.contains(e.target) && e.target!==langInput){ 
                langSug.classList.add('hidden'); 
            }
        });
        renderLangChips();

        // Profile photo preview
        const fileInput = document.querySelector('input[name="profile_photo"]');
        const prev = document.getElementById('photo-preview');
        fileInput?.addEventListener('change', (e)=>{
            const f = e.target.files?.[0]; 
            if(!f) return; 
            const url = URL.createObjectURL(f); 
            prev.src=url; 
            prev.classList.remove('hidden');
        });

        // Initialize with the correct step
        show(steps[Math.min(Math.max(0, Number({{ (int)($profile->onboarding_step ?? 1) }}-1)), steps.length-1)]);
    </script>
</body>
</html>