<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Book a Session with {{ $tutor->user->name }} - TapClass</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: { "primary": "#4F7EFF", "secondary": "#FFA500" },
            fontFamily: { "sans": ["Inter", "sans-serif"] }
          }
        }
      }
    </script>
</head>
<body class="bg-gray-50 font-sans">

<!-- Header -->
<header class="bg-white border-b border-gray-200 px-6 py-4">
    <div class="max-w-6xl mx-auto flex items-center justify-between">
        <a href="{{ route('tutors.search') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-primary">
            <span class="material-symbols-outlined">arrow_back</span>
            <span class="font-semibold">Back to Dashboard</span>
        </a>
        <div class="text-sm text-gray-600">
            Wallet Balance: <span class="font-bold text-primary">₹{{ number_format(auth()->user()->wallet->balance ?? 0, 0) }}</span>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="max-w-6xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Book a Session with {{ $tutor->user->name }}</h1>
        <p class="text-gray-600">Complete the steps below to schedule your session</p>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
        <ul class="list-disc pl-5 text-sm">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
    @endif

    <!-- Progress Bar -->
    <div class="bg-white rounded-xl border p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3 flex-1" id="step1Indicator">
                <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0">1</div>
                <span class="font-semibold text-sm">Subject & Mode</span>
            </div>
            <div class="h-px bg-gray-300 flex-1 mx-4" id="line1"></div>
            <div class="flex items-center gap-3 flex-1" id="step2Indicator">
                <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold shrink-0">2</div>
                <span class="text-gray-500 font-semibold text-sm">Date & Time</span>
            </div>
            <div class="h-px bg-gray-300 flex-1 mx-4" id="line2"></div>
            <div class="flex items-center gap-3 flex-1" id="step3Indicator">
                <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold shrink-0">3</div>
                <span class="text-gray-500 font-semibold text-sm">Confirmation</span>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('student.booking.store') }}" id="bookingForm">
        @csrf
        <input type="hidden" name="tutor_id" value="{{ $tutor->user_id }}"/>

        <div class="grid lg:grid-cols-3 gap-6">
            <!-- Left: Steps -->
            <div class="lg:col-span-2">
                
                <!-- Step 1: Subject & Mode -->
                <div id="step1" class="bg-white rounded-xl border p-6 mb-6">
                    <h2 class="text-xl font-bold mb-6">Select Subject & Mode</h2>
                    
                    <div class="mb-6">
                        <label class="block font-semibold mb-3 text-gray-700">Choose Subject</label>
                        <select name="subject_id" id="subjectSelect" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20" required>
                            <option value="">Select a subject...</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" 
                                    data-online-rate="{{ $subject->pivot->online_rate ?? 0 }}" 
                                    data-offline-rate="{{ $subject->pivot->offline_rate ?? 0 }}"
                                    data-online-available="{{ $subject->pivot->is_online_available ? 1 : 0 }}"
                                    data-offline-available="{{ $subject->pivot->is_offline_available ? 1 : 0 }}">
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block font-semibold mb-3 text-gray-700">Session Mode</label>
                        <div class="grid grid-cols-2 gap-4" id="modeOptions">
                            <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-xl cursor-pointer hover:border-primary transition-all" id="onlineOption" style="display: none;">
                                <input type="radio" name="session_mode" value="online" class="peer sr-only"/>
                                <div class="flex-1">
                                    <p class="font-semibold mb-1">Online Session</p>
                                    <p class="text-sm text-gray-600">Video call via platform</p>
                                    <p class="text-lg font-bold text-primary mt-2">₹<span id="onlineRateDisplay">0</span>/hr</p>
                                </div>
                                <div class="absolute inset-0 border-2 border-primary bg-primary/5 rounded-xl opacity-0 peer-checked:opacity-100 pointer-events-none"></div>
                            </label>
                            
                            <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-xl cursor-pointer hover:border-primary transition-all" id="offlineOption" style="display: none;">
                                <input type="radio" name="session_mode" value="offline" class="peer sr-only"/>
                                <div class="flex-1">
                                    <p class="font-semibold mb-1">Offline Session</p>
                                    <p class="text-sm text-gray-600">In-person at tutor's location</p>
                                    <p class="text-lg font-bold text-primary mt-2">₹<span id="offlineRateDisplay">0</span>/hr</p>
                                </div>
                                <div class="absolute inset-0 border-2 border-primary bg-primary/5 rounded-xl opacity-0 peer-checked:opacity-100 pointer-events-none"></div>
                            </label>
                        </div>
                        <p class="text-sm text-gray-500 mt-2" id="modeHint">Please select a subject first</p>
                    </div>

                    <button type="button" onclick="goToStep(2)" id="step1Next" class="w-full py-3 bg-primary text-white rounded-xl font-semibold hover:bg-primary/90 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        Continue to Date & Time
                    </button>
                </div>

                <!-- Step 2: Date & Time -->
                <div id="step2" class="bg-white rounded-xl border p-6 mb-6 hidden">
                    <h2 class="text-xl font-bold mb-6">Pick Date & Time</h2>
                    
                    <div class="mb-6">
                        <label class="block font-semibold mb-3 text-gray-700">Select Date</label>
                        <input type="text" id="datePicker" name="session_date" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20" placeholder="Click to select date" required readonly/>
                    </div>

                    <div class="mb-6">
                        <label class="block font-semibold mb-3 text-gray-700">Select Time Slot</label>
                        <div class="grid grid-cols-3 gap-3" id="timeSlots">
                            <!-- Time slots will be populated here -->
                        </div>
                        <input type="hidden" name="start_time" id="startTime" required/>
                        <input type="hidden" name="end_time" id="endTime" required/>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="goToStep(1)" class="flex-1 py-3 border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50">
                            Back
                        </button>
                        <button type="button" onclick="goToStep(3)" id="step2Next" class="flex-1 py-3 bg-primary text-white rounded-xl font-semibold hover:bg-primary/90 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            Continue to Confirmation
                        </button>
                    </div>
                </div>

                <!-- Step 3: Confirmation -->
                <div id="step3" class="bg-white rounded-xl border p-6 mb-6 hidden">
                    <h2 class="text-xl font-bold mb-6">Review & Confirm</h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between py-3 border-b">
                            <span class="text-gray-600">Tutor</span>
                            <span class="font-semibold">{{ $tutor->user->name }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b">
                            <span class="text-gray-600">Subject</span>
                            <span class="font-semibold" id="confirmSubject">-</span>
                        </div>
                        <div class="flex justify-between py-3 border-b">
                            <span class="text-gray-600">Mode</span>
                            <span class="font-semibold" id="confirmMode">-</span>
                        </div>
                        <div class="flex justify-between py-3 border-b">
                            <span class="text-gray-600">Date</span>
                            <span class="font-semibold" id="confirmDate">-</span>
                        </div>
                        <div class="flex justify-between py-3 border-b">
                            <span class="text-gray-600">Time</span>
                            <span class="font-semibold" id="confirmTime">-</span>
                        </div>
                        <div class="flex justify-between py-3 border-b">
                            <span class="text-gray-600">Duration</span>
                            <span class="font-semibold">1 Hour</span>
                        </div>
                        <div class="flex justify-between py-4 bg-gray-50 px-4 rounded-lg">
                            <span class="text-lg font-bold">Total Amount</span>
                            <span class="text-2xl font-bold text-primary">₹<span id="confirmTotal">0</span></span>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="goToStep(2)" class="flex-1 py-3 border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50">
                            Back
                        </button>
                        <button type="submit" class="flex-1 py-3 bg-secondary text-white rounded-xl font-semibold hover:bg-secondary/90">
                            Confirm & Pay ₹<span id="confirmTotal2">0</span>
                        </button>
                    </div>
                </div>

            </div>

            <!-- Right: Summary Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl border p-6 sticky top-4">
                    <h3 class="font-bold text-lg mb-4">Booking Summary</h3>
                    
                    <div class="space-y-3 text-sm mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subject:</span>
                            <span class="font-semibold" id="summarySubject">Not selected</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Mode:</span>
                            <span class="font-semibold" id="summaryMode">Not selected</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Date:</span>
                            <span class="font-semibold" id="summaryDate">Not selected</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Time:</span>
                            <span class="font-semibold" id="summaryTime">Not selected</span>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">Total:</span>
                            <span class="text-2xl font-bold text-primary">₹<span id="summaryTotal">0</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
let currentStep = 1;
let selectedRate = 0;

// Time slots (9 AM to 8 PM)
const timeSlots = [
    '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', 
    '15:00', '16:00', '17:00', '18:00', '19:00', '20:00'
];

// Initialize Flatpickr
const datePicker = flatpickr("#datePicker", {
    minDate: "today",
    maxDate: new Date().fp_incr(30),
    dateFormat: "Y-m-d",
    onChange: function(selectedDates, dateStr) {
        document.getElementById('summaryDate').textContent = flatpickr.formatDate(selectedDates[0], 'M d, Y');
        document.getElementById('confirmDate').textContent = flatpickr.formatDate(selectedDates[0], 'M d, Y');
        checkStep2Complete();
    }
});

// Subject selection
document.getElementById('subjectSelect').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    const subjectName = option.text;
    const onlineRate = parseInt(option.getAttribute('data-online-rate') || 0);
    const offlineRate = parseInt(option.getAttribute('data-offline-rate') || 0);
    const onlineAvailable = option.getAttribute('data-online-available') === '1';
    const offlineAvailable = option.getAttribute('data-offline-available') === '1';
    
    document.getElementById('summarySubject').textContent = subjectName;
    document.getElementById('confirmSubject').textContent = subjectName;
    
    // Show/hide mode options
    const onlineOption = document.getElementById('onlineOption');
    const offlineOption = document.getElementById('offlineOption');
    const modeHint = document.getElementById('modeHint');
    
    if (onlineAvailable) {
        onlineOption.style.display = 'flex';
        document.getElementById('onlineRateDisplay').textContent = onlineRate;
    } else {
        onlineOption.style.display = 'none';
    }
    
    if (offlineAvailable) {
        offlineOption.style.display = 'flex';
        document.getElementById('offlineRateDisplay').textContent = offlineRate;
    } else {
        offlineOption.style.display = 'none';
    }
    
    if (onlineAvailable || offlineAvailable) {
        modeHint.textContent = 'Select your preferred mode';
        
        // Auto-select if only one is available
        if (onlineAvailable && !offlineAvailable) {
            document.querySelector('input[value="online"]').checked = true;
            document.querySelector('input[value="online"]').dispatchEvent(new Event('change'));
        } else if (!onlineAvailable && offlineAvailable) {
            document.querySelector('input[value="offline"]').checked = true;
            document.querySelector('input[value="offline"]').dispatchEvent(new Event('change'));
        }
    } else {
        modeHint.textContent = 'No modes available for this subject';
    }
    
    checkStep1Complete();
});

// Mode selection
document.querySelectorAll('input[name="session_mode"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const mode = this.value;
        const option = document.getElementById('subjectSelect').options[document.getElementById('subjectSelect').selectedIndex];
        const rate = mode === 'online' ? 
            parseInt(option.getAttribute('data-online-rate') || 0) : 
            parseInt(option.getAttribute('data-offline-rate') || 0);
        
        selectedRate = rate;
        document.getElementById('summaryMode').textContent = mode === 'online' ? 'Online' : 'Offline';
        document.getElementById('summaryTotal').textContent = rate;
        document.getElementById('confirmMode').textContent = mode === 'online' ? 'Online' : 'Offline';
        document.getElementById('confirmTotal').textContent = rate;
        document.getElementById('confirmTotal2').textContent = rate;
        
        checkStep1Complete();
    });
});

// Generate time slots
function generateTimeSlots() {
    const container = document.getElementById('timeSlots');
    container.innerHTML = '';
    
    timeSlots.forEach(time => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'px-4 py-3 border-2 border-gray-300 rounded-xl hover:border-primary hover:bg-primary/5 font-medium transition-all';
        btn.textContent = formatTime(time);
        btn.onclick = function() { selectTimeSlot(time, btn); };
        container.appendChild(btn);
    });
}

function formatTime(time24) {
    const [hours, minutes] = time24.split(':');
    const hour = parseInt(hours);
    const ampm = hour >= 12 ? 'PM' : 'AM';
    const hour12 = hour === 0 ? 12 : hour > 12 ? hour - 12 : hour;
    return `${hour12}:${minutes} ${ampm}`;
}

function selectTimeSlot(time24, btn) {
    // Remove selection from all buttons
    document.querySelectorAll('#timeSlots button').forEach(b => {
        b.className = 'px-4 py-3 border-2 border-gray-300 rounded-xl hover:border-primary hover:bg-primary/5 font-medium transition-all';
    });
    
    // Add selection to clicked button
    btn.className = 'px-4 py-3 border-2 border-primary bg-primary text-white rounded-xl font-medium';
    
    // Update hidden inputs
    const [hours] = time24.split(':');
    const endHour = (parseInt(hours) + 1).toString().padStart(2, '0');
    
    document.getElementById('startTime').value = time24;
    document.getElementById('endTime').value = `${endHour}:00`;
    
    // Update summary
    const formattedTime = formatTime(time24);
    document.getElementById('summaryTime').textContent = formattedTime;
    document.getElementById('confirmTime').textContent = `${formattedTime} - ${formatTime(endHour + ':00')}`;
    
    checkStep2Complete();
}

function checkStep1Complete() {
    const subjectSelected = document.getElementById('subjectSelect').value !== '';
    const modeSelected = document.querySelector('input[name="session_mode"]:checked') !== null;
    document.getElementById('step1Next').disabled = !(subjectSelected && modeSelected);
}

function checkStep2Complete() {
    const dateSelected = document.getElementById('datePicker').value !== '';
    const timeSelected = document.getElementById('startTime').value !== '';
    document.getElementById('step2Next').disabled = !(dateSelected && timeSelected);
}

function goToStep(step) {
    // Hide all steps
    document.getElementById('step1').classList.add('hidden');
    document.getElementById('step2').classList.add('hidden');
    document.getElementById('step3').classList.add('hidden');
    
    // Show selected step
    document.getElementById('step' + step).classList.remove('hidden');
    
    // Update progress indicators
    updateProgress(step);
    
    currentStep = step;
    
    // Initialize time slots for step 2
    if (step === 2 && document.getElementById('timeSlots').children.length === 0) {
        generateTimeSlots();
    }
}

function updateProgress(step) {
    // Reset all
    for (let i = 1; i <= 3; i++) {
        const indicator = document.getElementById('step' + i + 'Indicator');
        const circle = indicator.querySelector('div');
        const text = indicator.querySelector('span');
        
        if (i < step) {
            circle.className = 'w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center font-bold shrink-0';
            circle.innerHTML = '✓';
            text.className = 'font-semibold text-sm text-green-600';
        } else if (i === step) {
            circle.className = 'w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shrink-0';
            circle.textContent = i;
            text.className = 'font-semibold text-sm text-gray-900';
        } else {
            circle.className = 'w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center font-bold shrink-0';
            circle.textContent = i;
            text.className = 'text-gray-500 font-semibold text-sm';
        }
    }
    
    // Update lines
    document.getElementById('line1').className = step > 1 ? 'h-px bg-green-500 flex-1 mx-4' : 'h-px bg-gray-300 flex-1 mx-4';
    document.getElementById('line2').className = step > 2 ? 'h-px bg-green-500 flex-1 mx-4' : 'h-px bg-gray-300 flex-1 mx-4';
}

// Initialize
checkStep1Complete();
</script>

</body>
</html>
