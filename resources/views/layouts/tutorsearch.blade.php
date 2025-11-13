<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'Find Tutors') - HTC</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
  <script>
    tailwind.config = { theme: { extend: { colors: { primary: '#006cab', secondary: '#FFA500', 'accent-yellow':'#FFBD59', 'footer-bg':'#000000', 'subscribe-bg':'#D1E3E6' }, fontFamily: { display: ['Manrope','sans-serif'] } } } }
  </script>
  @stack('styles')
</head>
<body class="bg-[#fffcf0] font-display text-[13px] text-black">
  <main>
    @yield('content')
  </main>

  @include('components.footer')
  @stack('scripts')
</body>
</html>
