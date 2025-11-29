<footer class="bg-white text-gray-600 pt-10 pb-6 border-t border-gray-100">
        <div class="max-w-6xl mx-auto px-4"> 
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-[1.5fr_1fr_1fr_1fr] gap-6">
                
                <!-- Column 1: Logo & Socials -->
                <div>
                    <a href="{{ route('home') }}" class="flex items-center font-bold text-lg text-black group mb-2">
                        <img src="{{ asset('images/logo/htc.png') }}" alt="HTC Logo" class="h-8 w-auto">
                    </a>
                    <p class="my-3 text-xs leading-relaxed">
                        Connecting students with qualified tutors for personalized learning experiences.
                    </p>
                    <div class="flex space-x-3 mb-4">
                        <a href="https://www.facebook.com/share/1DLVmPjUPr/?mibextid=wwXIfr" target="_blank" class="text-xl hover:text-primary transition-colors"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-xl hover:text-primary transition-colors"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-xl hover:text-primary transition-colors"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <!-- Column 2: Quick Links (Merged) -->
                <div>
                    <h5 class="font-bold text-black uppercase text-xs mb-3">Quick Links</h5>
                    <ul class="space-y-2">
                        <li><a href="{{ route('tutors.search') }}" class="text-xs hover:text-primary transition-colors">Find Tutors</a></li>
                        <li><a href="{{ route('login') }}" class="text-xs hover:text-primary transition-colors">Login</a></li>
                        <li><a href="{{ route('register') }}" class="text-xs hover:text-primary transition-colors">Register</a></li>
                        <li><a href="{{ route('about') }}" class="text-xs hover:text-primary transition-colors">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="text-xs hover:text-primary transition-colors">Contact</a></li>
                        <li><a href="#" class="text-xs hover:text-primary transition-colors">Blog</a></li>
                    </ul>
                </div>

                <!-- Column 3: Join Us -->
                <div>
                    <h5 class="font-bold text-black uppercase text-xs mb-3">Join Us</h5>
                    <ul class="space-y-2">
                        <li><a href="{{ route('register.student') }}" class="text-xs hover:text-primary transition-colors">Register as Student</a></li>
                        <li><a href="{{ route('register.tutor') }}" class="text-xs hover:text-primary transition-colors">Become a Tutor</a></li>
                        <li><a href="{{ route('register.parent') }}" class="text-xs hover:text-primary transition-colors">Register as Parent</a></li>
                    </ul>
                </div>

                <!-- Column 4: Contact Info -->
                <div>
                    <h5 class="font-bold text-black uppercase text-xs mb-3">Contact Us</h5>
                    <div class="text-xs text-gray-500 space-y-2">
                        <p><i class="bi bi-telephone mr-2"></i> +91 9278000191</p>
                        <p class="flex items-start">
                            <i class="bi bi-geo-alt mr-2 mt-1"></i>
                            <span>
                                A-590 LIGHT HOUSE PROJECT,<br>
                                AWADH VIHAR YOJANA,<br>
                                UTHRETIYA SHAHID PATH,<br>
                                LUCKNOW 226002,<br>
                                UTTAR PRADESH
                            </span>
                        </p>
                    </div>
                </div>

            </div> 
            
            <!-- Sub-Footer -->
            <div class="mt-8 pt-4 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <p class="text-xs text-gray-400">&copy; {{ date('Y') }} htc. All rights reserved.</p>
                    <ul class="flex space-x-4 mt-2 sm:mt-0">
                        <li><a href="{{ route('privacy') }}" class="text-xs text-gray-400 hover:text-primary">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}" class="text-xs text-gray-400 hover:text-primary">Terms & Conditions</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>