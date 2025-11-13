
    <footer class="bg-footer-bg text-gray-300 pt-16">
        <div class="max-w-6xl mx-auto px-4"> 
            
            <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-8">
                
                <!-- Column 1: Logo & Socials -->
                <div class="md:col-span-2 lg:col-span-2">
                    <a href="{{ route('home') }}" class="flex items-center font-bold text-xl text-white group">
                        <i class="bi bi-mortarboard-fill text-accent-yellow text-2xl mr-2"></i>
                        htc
                    </a>
                    <p class="my-4 max-w-xs text-sm leading-relaxed">
                        Connecting students with qualified tutors for personalized learning experiences.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-xl hover:text-accent-yellow transition-colors"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-xl hover:text-accent-yellow transition-colors"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-xl hover:text-accent-yellow transition-colors"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="text-xl hover:text-accent-yellow transition-colors"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div>
                    <h5 class="font-bold text-white uppercase mb-4">Quick Links</h5>
                    <ul class="space-y-3">
                        <li><a href="{{ route('tutors.search') }}" class="text-sm hover:text-accent-yellow transition-colors">Find Tutors</a></li>
                        <li><a href="{{ route('login') }}" class="text-sm hover:text-accent-yellow transition-colors">Login</a></li>
                        <li><a href="{{ route('register') }}" class="text-sm hover:text-accent-yellow transition-colors">Register</a></li>
                    </ul>
                </div>

                <!-- Column 3: Company -->
                <div>
                    <h5 class="font-bold text-white uppercase mb-4">Company</h5>
                    <ul class="space-y-3">
                        <li><a href="{{ route('about') }}" class="text-sm hover:text-accent-yellow transition-colors">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="text-sm hover:text-accent-yellow transition-colors">Contact</a></li>
                        <li><a href="#" class="text-sm hover:text-accent-yellow transition-colors">Blog</a></li>
                    </ul>
                </div>

                <!-- Column 4: Join -->
                <div>
                    <h5 class="font-bold text-white uppercase mb-4">Join Us</h5>
                    <ul class="space-y-3">
                        <li><a href="{{ route('register.student') }}" class="text-sm hover:text-accent-yellow transition-colors">Register as Student</a></li>
                        <li><a href="{{ route('register.tutor') }}" class="text-sm hover:text-accent-yellow transition-colors">Become a Tutor</a></li>
                        <li><a href="{{ route('register.parent') }}" class="text-sm hover:text-accent-yellow transition-colors">Register as Parent</a></li>
                    </ul>
                </div>

            </div> 
            
            <!-- Sub-Footer -->
            <div class="mt-12 pt-6 border-t border-gray-200/20">
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <p class="text-sm text-gray-400">&copy; {{ date('Y') }} htc. All rights reserved.</p>
                    <ul class="flex space-x-4 mt-4 sm:mt-0">
                        <li><a href="{{ route('privacy') }}" class="text-sm text-gray-400 hover:text-accent-yellow">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}" class="text-sm text-gray-400 hover:text-accent-yellow">Terms & Conditions</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>