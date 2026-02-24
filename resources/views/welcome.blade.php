<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <title>LeadFlow - Smart Lead Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Google Font - Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">


    <style>
        body {
            background: linear-gradient(135deg, #0f172a, #1e293b);
        }

        .text-gradient {
            background: linear-gradient(to right, #6366f1, #22d3ee);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
                
<body  class="font-[Poppins] text-white">

    <!-- NAVBAR -->
 <nav id="navbar"
    class="fixed top-10 left-3 right-3 z-50 h-16 rounded-xl
    bg-slate-900/30
    backdrop-blur-md
    border border-white/10
    transition-all duration-500 ease-in-out">

    <div id="navInner"
        class="max-w-7xl mx-auto px-6 h-full flex justify-between items-center">

        <!-- Logo Section -->
        <div class="flex items-center gap-3">

            <div class="bg-indigo-500 p-2 rounded-lg shadow-md">
                <i data-lucide="target" class="w-5 h-5 text-white"></i>
            </div>

            <!-- FIXED LOGO -->
            <img src="{{ asset('images/code.png') }}"
                 alt="NA Logo"
                 class="h-8 w-auto object-contain">

        </div>

        <!-- Menu -->
        <div class="hidden md:flex gap-8 text-gray-300 text-sm font-medium">
            <a href="#stages" class="hover:text-white transition">Stages</a>
            <a href="#features" class="hover:text-white transition">Features</a>
            <a href="#contact" class="hover:text-white transition">Contact</a>
        </div>

        <!-- Auth Buttons -->
        <div class="flex items-center gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="bg-indigo-500 px-5 py-2 rounded-lg text-white hover:opacity-90 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="text-gray-300 hover:text-white transition">
                        Login
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="bg-indigo-500 px-5 py-2 rounded-lg text-white hover:opacity-90 transition">
                            Register
                        </a>
                    @endif
                @endauth
            @endif
        </div>

    </div>
</nav>




    <!-- HERO -->
    <section class="min-h-screen flex items-center pt-28">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center">

            <div>
                <h1 class="text-5xl lg:text-6xl font-extrabold mb-6 leading-tight">
                    Manage Your Leads <br>
                    <span class="text-gradient">Smarter & Faster</span>
                </h1>

                <p class="text-gray-400 text-lg mb-8 leading-relaxed">
                    Track every lead through a structured sales pipeline — from first contact
                    to final deal closure. Increase efficiency, boost conversions, and grow your business.
                </p>
            </div>

            <div>
                <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71" alt="CRM Dashboard"
                    class="rounded-2xl shadow-2xl border border-white/10">
            </div>

        </div>
    </section>


    <!-- STAGES -->
    <section id="stages" class="py-24 bg-slate-950 text-center">
        <h2 class="text-4xl font-bold mb-4">Lead Stages Pipeline</h2>
        <p class="text-gray-400 mb-16">A structured workflow for managing every opportunity</p>

        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-7 gap-6">

            @php
            $stages = [
            'New Lead',
            'Contacted',
            'Requirement Received',
            'Quotation Sent',
            'Negotiation',
            'Won',
            'Lost'
            ];
            @endphp

            @foreach($stages as $stage)
            <div class="group">
                <div class="w-16 h-16 mx-auto 
                    {{ $stage == 'Won' ? 'bg-green-600' : ($stage == 'Lost' ? 'bg-red-600' : 'bg-indigo-600') }}
                    rounded-full flex items-center justify-center transition group-hover:scale-110 shadow-lg">
                    <i data-lucide="circle"></i>
                </div>
                <h4 class="mt-4 font-semibold 
                    {{ $stage == 'Won' ? 'text-green-400' : ($stage == 'Lost' ? 'text-red-400' : '') }}">
                    {{ $stage }}
                </h4>
            </div>
            @endforeach

        </div>
    </section>


    <!-- FEATURES -->
    <section id="features" class="py-24 bg-slate-900 text-center">
        <h2 class="text-4xl font-bold mb-4">Powerful Features</h2>
        <p class="text-gray-400 mb-12">Everything you need to manage your leads efficiently</p>

        <div class="max-w-7xl mx-auto px-6 grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-slate-800 p-6 rounded-2xl hover:-translate-y-2 transition">
                <i data-lucide="target" class="mb-4 text-indigo-400"></i>
                <h3 class="font-semibold mb-2">Stage Tracking</h3>
                <p class="text-sm text-gray-400">Monitor every step of your sales pipeline</p>
            </div>

            <div class="bg-slate-800 p-6 rounded-2xl hover:-translate-y-2 transition">
                <i data-lucide="bar-chart-3" class="mb-4 text-indigo-400"></i>
                <h3 class="font-semibold mb-2">Analytics</h3>
                <p class="text-sm text-gray-400">Detailed conversion insights</p>
            </div>

            <div class="bg-slate-800 p-6 rounded-2xl hover:-translate-y-2 transition">
                <i data-lucide="users" class="mb-4 text-indigo-400"></i>
                <h3 class="font-semibold mb-2">Team Management</h3>
                <p class="text-sm text-gray-400">Assign and track team performance</p>
            </div>

            <div class="bg-slate-800 p-6 rounded-2xl hover:-translate-y-2 transition">
                <i data-lucide="zap" class="mb-4 text-indigo-400"></i>
                <h3 class="font-semibold mb-2">Automation</h3>
                <p class="text-sm text-gray-400">Smart alerts and reminders</p>
            </div>
        </div>
    </section>


    <!-- CONTACT FORM -->
    <section id="contact" class="py-24 bg-slate-950">
        <div class="max-w-4xl mx-auto px-6 text-center mb-12">
            <h2 class="text-4xl font-bold mb-4 text-white">
              Send Inquiry
            </h2>
            <p class="text-gray-400">
                Submit your details and our team will contact you shortly.
            </p>
        </div>

        <div class="max-w-4xl mx-auto px-6 bg-slate-800 p-10 rounded-2xl border border-white/10 shadow-xl">

            {{-- Success Message --}}
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-600/20 border border-green-500 text-green-400 rounded-xl">
                {{ session('success') }}
            </div>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any())
            <div class="mb-6 p-4 bg-red-600/20 border border-red-500 text-red-400 rounded-xl">
                <ul class="list-disc pl-5 space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('website.inquiry') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name *" required
                        class="w-full px-4 py-3 bg-slate-900 text-white border border-white/10 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <input type="text" name="company_name" placeholder="Company Name"
                        class="w-full px-4 py-3 bg-slate-900 border border-white/10 rounded-xl">

                </div>

                <!-- Email -->
                <div>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address *" required
                        class="w-full px-4 py-3 bg-slate-900 text-white border border-white/10 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <!-- Phone -->
                <div>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone Number"
                        class="w-full px-4 py-3 bg-slate-900 text-white border border-white/10 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <!-- Message -->
                <div>
                    <textarea name="message" rows="4" placeholder="Tell us about your requirement"
                        class="w-full px-4 py-3 bg-slate-900 text-white border border-white/10 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('message') }}</textarea>
                </div>

                <!-- Button -->
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 py-3 rounded-xl font-semibold transition duration-200 shadow-lg shadow-indigo-600/30">
                    Submit Request
                </button>
            </form>
        </div>
    </section>


    <!-- FOOTER -->
    <footer class="border-t border-white/10 py-10 text-center bg-slate-900">
        <div class="flex justify-center items-center gap-2 mb-3">
            <i data-lucide="target" class="text-indigo-400"></i>
            <span class="font-bold text-lg">LeadFlow</span>
        </div>
        <p class="text-sm text-gray-500">© 2026 LeadFlow. All rights reserved.</p>
    </footer>

    <script>

    const navbar = document.getElementById('navbar');
    const navInner = document.getElementById('navInner');

    window.addEventListener('scroll', function () {

        if (window.scrollY > 60) {

            navbar.classList.remove('bg-slate-900/30');
            navbar.classList.add(
                'bg-slate-900/60',
                'backdrop-blur-xl',
                'shadow-md',
                'border-white/10'
            );

            navInner.classList.remove('py-5');
            navInner.classList.add('py-3');

        } else {

            navbar.classList.remove(
                'bg-slate-900/60',
                'backdrop-blur-xl',
                'shadow-md',
                'border-white/10'
            );

            navbar.classList.add('bg-slate-900/30');

            navInner.classList.remove('py-3');
            navInner.classList.add('py-5');
        }

    });



        lucide.createIcons();
    </script>

</body>

</html>