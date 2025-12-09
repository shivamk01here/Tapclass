@extends('layouts.ai')

@section('content')
<div class="min-h-screen bg-black text-white pt-24 pb-12 px-4">
    <div class="max-w-2xl mx-auto">
        <!-- Back Button -->
        <a href="{{ route('ai-test.pricing') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white mb-8 transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
            Back to Plans
        </a>

        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 md:p-8">
            <h1 class="text-2xl md:text-3xl font-heading mb-2">Complete Your Payment</h1>
            <p class="text-gray-400 mb-8">Pay via UPI and upload the proof to activate your {{ ucfirst($plan) }} Plan credits.</p>

            <div class="grid md:grid-cols-2 gap-8 items-start">
                
                <!-- QR Code Section -->
                <div class="bg-white p-4 rounded-xl text-center">
                    <p class="text-black font-bold mb-2">Scan to Pay ₹{{ $amount }}</p>
                    <div class="aspect-square bg-gray-200 rounded-lg flex items-center justify-center mb-2 overflow-hidden">
                         <!-- Placeholder QR -->
                         <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=upi://pay?pa=dummy@upi&pn=HomeTutorConsultancy&am={{ $amount }}&tn=AI_Credits_{{ $plan }}" alt="Payment QR Code" class="w-full h-full object-contain">
                    </div>
                    <p class="text-xs text-gray-500">Supported Apps: GPay, PhonePe, Paytm</p>
                </div>

                <!-- Form Section -->
                <div>
                     <form action="{{ route('ai-test.payment.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <input type="hidden" name="plan" value="{{ $plan }}">

                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-1">Enter UTR / Transaction ID</label>
                            <input type="text" name="utr" required 
                                   placeholder="e.g. 123456789012"
                                   class="w-full bg-black/50 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-600 focus:border-accent-yellow focus:ring-1 focus:ring-accent-yellow outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-300 mb-1">Upload Screenshot</label>
                            <div class="relative border-2 border-dashed border-white/20 rounded-lg p-4 text-center hover:border-accent-yellow/50 transition-colors cursor-pointer" onclick="document.getElementById('screenshot').click()">
                                <input type="file" id="screenshot" name="screenshot" accept="image/*" required class="hidden" onchange="previewFile(this)">
                                <div id="upload-placeholder" class="space-y-2">
                                    <span class="material-symbols-outlined text-3xl text-gray-500">cloud_upload</span>
                                    <p class="text-sm text-gray-400">Click to upload payment proof</p>
                                </div>
                                <div id="file-preview" class="hidden">
                                     <p class="text-sm text-accent-yellow" id="file-name"></p>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-accent-yellow text-black font-heading text-lg py-4 rounded-xl hover:bg-white transition-colors relative overflow-hidden group">
                            <span class="relative z-10">Submit Payment Details</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Instructions -->
        <div class="mt-8 flex gap-4 text-sm text-gray-400">
            <span class="material-symbols-outlined text-accent-yellow">info</span>
            <p>After submission, valid payments are verified within 30 minutes. You will receive an email confirmation once credits are added.</p>
        </div>
    </div>
</div>

<script>
    function previewFile(input) {
        const file = input.files[0];
        if (file) {
            document.getElementById('upload-placeholder').classList.add('hidden');
            document.getElementById('file-preview').classList.remove('hidden');
            document.getElementById('file-name').textContent = file.name;
        }
    }
</script>
@endsection
