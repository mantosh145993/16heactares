<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bodmas Group</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine (for dropdown) -->
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-50 text-gray-800">

<!-- HEADER -->
<header class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">

        <!-- LOGO -->
        <h1 class="text-xl font-bold text-blue-600">
            Bodmas Group
        </h1>

        <!-- NAV -->
        <nav class="hidden md:flex space-x-6 text-gray-600">
            <a href="#" class="hover:text-blue-600">Home</a>
            <a href="#about" class="hover:text-blue-600">About</a>
            <a href="#ventures" class="hover:text-blue-600">Ventures</a>
            <a href="#contact" class="hover:text-blue-600">Contact</a>
        </nav>

        <!-- LOGIN DROPDOWN -->
        <div x-data="{ open: false }" class="relative">

            <button @click="open = !open"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg flex items-center gap-2 hover:bg-blue-700 transition">
                Login ▼
            </button>

            <div x-show="open"
                @click.outside="open = false"
                class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg overflow-hidden">

                <a href="/admin/login" class="block px-4 py-2 hover:bg-gray-100">
                    Admin Login
                </a>

                <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                    Agent Login
                </a>

                <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                    Owner Login
                </a>

            </div>

        </div>

    </div>
</header>

<!-- HERO -->
<section class="text-center py-20 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
    <h1 class="text-5xl font-bold mb-4">Mera Ghar</h1>
    <p class="text-lg max-w-2xl mx-auto">
        Building future-ready platforms across Education, Digital, Wealth, Media & Travel.
    </p>
</section>

<!-- ABOUT -->
<section id="about" class="py-16 max-w-6xl mx-auto text-center px-4">
    <h2 class="text-3xl font-semibold mb-4">About Us</h2>
    <p class="text-gray-600">
        Bodmas Group is a multi-vertical organization focused on innovation,
        growth, and empowering individuals through technology, education,
        and business solutions.
    </p>
</section>

<!-- VENTURES -->
<section id="ventures" class="py-16 bg-white">
    <h2 class="text-3xl text-center font-semibold mb-10">Our Ventures</h2>

    <div class="grid md:grid-cols-3 gap-6 max-w-6xl mx-auto px-4">

        <div class="p-6 rounded-2xl shadow-md hover:shadow-xl transition bg-gray-50">
            <h3 class="text-xl font-bold mb-2">Bodmas Education</h3>
            <p class="text-gray-600">Empowering students with career success.</p>
        </div>

        <div class="p-6 rounded-2xl shadow-md hover:shadow-xl transition bg-gray-50">
            <h3 class="text-xl font-bold mb-2">Bodmas Digital</h3>
            <p class="text-gray-600">Digital marketing & branding solutions.</p>
        </div>

        <div class="p-6 rounded-2xl shadow-md hover:shadow-xl transition bg-gray-50">
            <h3 class="text-xl font-bold mb-2">Bodmas Wealth</h3>
            <p class="text-gray-600">Smart investment & financial growth.</p>
        </div>

        <div class="p-6 rounded-2xl shadow-md hover:shadow-xl transition bg-gray-50">
            <h3 class="text-xl font-bold mb-2">Sach Kya Hai</h3>
            <p class="text-gray-600">India’s honest news platform.</p>
        </div>

        <div class="p-6 rounded-2xl shadow-md hover:shadow-xl transition bg-gray-50">
            <h3 class="text-xl font-bold mb-2">Travel Agency</h3>
            <p class="text-gray-600">Coming soon – explore the world with us.</p>
        </div>

    </div>
</section>

<!-- WHY US -->
<section class="py-16 max-w-6xl mx-auto text-center px-4">
    <h2 class="text-3xl font-semibold mb-6">Why Choose Bodmas?</h2>

    <div class="grid md:grid-cols-3 gap-6">

        <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition">
            <h3 class="font-bold text-lg">Innovation</h3>
            <p class="text-gray-600">We build future-ready solutions.</p>
        </div>

        <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition">
            <h3 class="font-bold text-lg">Trust</h3>
            <p class="text-gray-600">Trusted across multiple industries.</p>
        </div>

        <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition">
            <h3 class="font-bold text-lg">Growth</h3>
            <p class="text-gray-600">Focused on long-term success.</p>
        </div>

    </div>
</section>

<!-- CTA -->
<section id="contact" class="py-16 text-center bg-blue-600 text-white">
    <h2 class="text-3xl font-bold mb-4">Let’s Build the Future Together</h2>
    <p class="mb-6">Join Bodmas Group and grow with us.</p>

    <a href="#"
       class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">
        Contact Us
    </a>
</section>

<!-- FOOTER -->
<footer class="py-6 text-center text-gray-500">
    © {{ date('Y') }} Bodmas Group. All rights reserved.
</footer>

</body>
</html>