<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PUP PUK in - Distribusi Pupuk Bersubsidi</title>
        <meta name="description"
            content="Sistem terpadu untuk distribusi pupuk bersubsidi yang lebih mudah dan terkontrol">

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="//unpkg.com/alpinejs" defer></script>

        <!-- Anime.js -->
        <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>

        <style>
            /* Custom CSS */
            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            }

            /* Animasi hover untuk tombol CTA */
            .cta-button:hover {
                box-shadow: 0 10px 25px -5px rgba(22, 101, 52, 0.4);
            }

            /* Efek parallax untuk section statistik */
            .parallax {
                background-attachment: fixed;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }

            /* Smooth scrolling */
            html {
                scroll-behavior: smooth;
            }

            /* Loading animation */
            .loading {
                opacity: 0;
                transform: translateY(20px);
            }

            /* Leaf animation container */
            .leaf-container {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                pointer-events: none;
            }

            /* Custom gradient */
            .hero-gradient {
                background: linear-gradient(135deg, 
                    rgba(240, 253, 244, 0.3) 0%, 
                    rgba(220, 252, 231, 0.3) 50%, 
                    rgba(187, 247, 208, 0.3) 100%),
                    url('/landing.png');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }

            /* Feature card hover effect */
            .feature-card {
                transition: all 0.3s ease;
            }

            .feature-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            }

            /* Stats section background */
            .stats-bg {
                background-image:
                    linear-gradient(rgba(20, 83, 45, 0.8), rgba(20, 83, 45, 0.8)),
                    url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><rect fill="%23166534" width="1200" height="600"/><path fill="%23059669" d="M0 400c100-50 200-100 300-80s200 60 300 40 200-40 300-20 200 40 300 20v240H0z"/></svg>');
                background-size: cover;
                background-position: center;
            }

            /* Hero title word animation */
            .hero-title {
                line-height: 1.2;
            }

            .word {
                display: inline-block;
                margin-right: 0.3em;
                opacity: 0;
                transform: translateY(20px);
            }

            .word:last-child {
                margin-right: 0;
            }

            /* Responsive text */
            @media (max-width: 640px) {
                .hero-title {
                    font-size: 2rem;
                    line-height: 1.1;
                }

                .word {
                    margin-right: 0.2em;
                }
            }

            @media (max-width: 480px) {
                .hero-title {
                    font-size: 1.75rem;
                }
            }

            /* Ensure proper text wrapping */
            .hero-title-container {
                word-wrap: break-word;
                overflow-wrap: break-word;
                hyphens: auto;
            }
        </style>
    </head>

    <body class="min-h-screen border-t bg-white">
        <x-navbar-guest />
        {{-- <div class="fixed top-0 left-0 right-0 z-50">
        </div> --}}
        <!-- Hero Section -->
        <section class="hero-gradient relative flex min-h-screen items-center overflow-hidden">
            <div class="leaf-container" id="leaves-container">
                <!-- Container untuk animasi daun jatuh -->
            </div>

            <div class="container relative z-10 mx-auto px-4 py-16">
                <div class="mx-auto max-w-4xl text-center">
                    <div class="hero-title-container">
                        <h1 class="hero-title loading mb-6 text-4xl font-bold text-green-800 md:text-5xl lg:text-6xl"
                            id="hero-title">
                            <!-- Text akan diisi oleh JavaScript -->
                        </h1>
                    </div>

                    <p class="loading mb-10 text-xl text-green-700 opacity-90 md:text-2xl">
                        Sistem terpadu untuk memastikan pupuk bersubsidi sampai ke tangan petani yang tepat dengan
                        proses yang transparan dan efisien
                    </p>

                    <div class="mb-12 flex flex-col justify-center gap-4 sm:flex-row">
                        <a href="{{ route('register.customer') }}"
                            class="cta-button loading flex transform items-center justify-center rounded-lg bg-green-500 px-8 py-3 font-bold text-white shadow-lg transition-all duration-300 hover:scale-105 hover:bg-green-600 hover:shadow-xl">
                            Daftar Petani
                            <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>
                        <a href="{{ route('register.owner') }}"
                            class="cta-button loading flex transform items-center justify-center rounded-lg bg-amber-500 px-8 py-3 font-bold text-white shadow-lg transition-all duration-300 hover:scale-105 hover:bg-amber-600 hover:shadow-xl">
                            Daftar Toko
                            <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>
                    </div>

                    <div class="loading group relative mt-8 h-64 overflow-hidden rounded-xl md:h-80 lg:h-96">
                        <img class="h-full w-full transform object-cover object-top object-rig transition-transform duration-700 ease-out group-hover:scale-110 shadow-md"
                            src="/petani.png" alt="Pupuk Bersubsidi">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-green-900/90 via-green-800/50 to-transparent transition-opacity duration-300 group-hover:opacity-75">
                        </div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center p-6">
                            <h2
                                class="mb-3 transform text-center font-heading text-xl font-extrabold leading-tight tracking-tight text-white transition-all duration-300 group-hover:-translate-y-2 md:text-3xl lg:text-4xl">
                                Pupuk Bersubsidi untuk Masa Depan Pertanian Indonesia
                            </h2>
                            <p class="max-w-lg text-center text-sm font-medium text-white/90 md:text-base">
                                Mendukung ketahanan pangan nasional melalui distribusi pupuk yang tepat sasaran
                            </p>
                            <div
                                class="mt-4 h-0.5 w-24 scale-x-0 transform rounded bg-green-400 opacity-0 transition-all duration-500 group-hover:scale-x-100 group-hover:opacity-100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="bg-white py-16 md:py-24" id="features-section">
            <div class="container mx-auto px-4">
                <h2 class="mb-16 text-center text-3xl font-bold text-green-800 md:text-4xl">
                    Fitur Unggulan Kami
                </h2>

                <div class="grid gap-8 md:grid-cols-3">
                    <div class="feature-card rounded-xl border border-green-100 bg-white p-6 shadow-lg">
                        <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
                            <svg class="h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                        </div>
                        <h3 class="mb-3 text-center text-xl font-bold text-green-800">Verifikasi Terpadu</h3>
                        <p class="text-center text-gray-600">
                            Sistem verifikasi multi-level untuk memastikan pupuk bersubsidi sampai ke petani yang berhak
                            dengan tepat sasaran
                        </p>
                    </div>

                    <div class="feature-card rounded-xl border border-green-100 bg-white p-6 shadow-lg">
                        <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
                            <svg class="h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                            </svg>
                        </div>
                        <h3 class="mb-3 text-center text-xl font-bold text-green-800">Monitoring Real-time</h3>
                        <p class="text-center text-gray-600">
                            Pantau distribusi pupuk secara real-time dari pabrik hingga petani dengan dashboard
                            interaktif dan laporan terperinci
                        </p>
                    </div>

                    <div class="feature-card rounded-xl border border-green-100 bg-white p-6 shadow-lg">
                        <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
                            <svg class="h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                        <h3 class="mb-3 text-center text-xl font-bold text-green-800">Mencari Toko Disekitar</h3>
                        <p class="text-center text-gray-600">
                            Temukan toko resmi terdekat yang menyediakan pupuk bersubsidi dengan mudah melalui fitur
                            pencarian lokasi
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Statistics Section -->
        <section class="stats-bg py-16 md:py-24" id="stats-section">
            <div class="container relative z-10 mx-auto px-4">
                <h2 class="mb-16 text-center text-3xl font-bold text-white md:text-4xl">
                    Dampak Kami
                </h2>

                <div class="grid gap-8 text-center md:grid-cols-3">
                    <div class="p-6">
                        <div class="stat-number mb-2 text-5xl font-bold text-white md:text-6xl" data-value="25000">0
                        </div>
                        <p class="text-xl text-green-200">Petani Terdaftar</p>
                    </div>

                    <div class="p-6">
                        <div class="stat-number mb-2 text-5xl font-bold text-white md:text-6xl" data-value="1500">0
                        </div>
                        <p class="text-xl text-green-200">Toko Resmi</p>
                    </div>

                    <div class="p-6">
                        <div class="stat-number mb-2 text-5xl font-bold text-white md:text-6xl" data-value="50000">0
                        </div>
                        <p class="text-xl text-green-200">Ton Pupuk Tersalurkan</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-white py-16 md:py-24" id="cta-section">
            <div class="container mx-auto px-4">
                <div class="cta-section mx-auto max-w-3xl text-center">
                    <h2 class="mb-6 text-3xl font-bold text-green-800 md:text-4xl">
                        Bergabunglah dengan Ekosistem PUPUKIN
                    </h2>

                    <p class="mb-10 text-xl text-gray-600">
                        Jadilah bagian dari revolusi distribusi pupuk bersubsidi yang lebih efisien, transparan, dan
                        tepat sasaran
                    </p>

                    <button
                        class="final-cta transform rounded-lg bg-green-500 px-10 py-4 text-xl font-bold text-white shadow-lg transition-all duration-300 hover:scale-110 hover:bg-green-600 hover:shadow-xl">
                        Mulai Sekarang
                    </button>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-green-900 py-8 text-white">
            <div class="container mx-auto px-4 text-center">
                <p>&copy; <span id="current-year"></span> Pupukin App. All rights reserved.</p>
            </div>
        </footer>

        <script>
            // Set current year
            document.getElementById('current-year').textContent = new Date().getFullYear();

            // Wait for DOM to be fully loaded
            document.addEventListener('DOMContentLoaded', function() {
                // Check if anime.js is loaded
                if (typeof anime === 'undefined') {
                    console.error('Anime.js not loaded');
                    // Fallback: remove loading class to show content
                    document.querySelectorAll('.loading').forEach(el => {
                        el.classList.remove('loading');
                        el.style.opacity = '1';
                        el.style.transform = 'translateY(0)';
                    });
                    return;
                }

                // Initialize animations
                initializeAnimations();
            });

            function initializeAnimations() {
                // Setup hero title with proper word wrapping
                setupHeroTitle();

                // Remove loading class from hero elements
                setTimeout(() => {
                    document.querySelectorAll('.loading').forEach(el => {
                        el.classList.remove('loading');
                    });
                }, 500);

                // Animasi tombol CTA
                anime({
                    targets: '.cta-button',
                    scale: [0.9, 1],
                    opacity: [0, 1],
                    easing: "easeOutElastic(1, .6)",
                    duration: 800,
                    delay: function(el, i) {
                        return 1500 + (i * 150);
                    }
                });

                // Animasi daun jatuh
                createFallingLeaves();

                // Setup intersection observers
                setupIntersectionObservers();
            }

            function setupHeroTitle() {
                const titleElement = document.getElementById('hero-title');
                const titleText = "Distribusi Pupuk Bersubsidi Lebih Mudah dan Terkontrol";

                // Split text into words
                const words = titleText.split(' ');

                // Clear existing content
                titleElement.innerHTML = '';

                // Create word elements
                words.forEach((word, index) => {
                    const wordSpan = document.createElement('span');
                    wordSpan.className = 'word';
                    wordSpan.textContent = word;
                    titleElement.appendChild(wordSpan);

                    // Add space after word (except last word)
                    if (index < words.length - 1) {
                        titleElement.appendChild(document.createTextNode(' '));
                    }
                });

                // Animate words appearing one by one
                anime({
                    targets: '.word',
                    opacity: [0, 1],
                    translateY: [20, 0],
                    easing: "easeOutQuad",
                    duration: 600,
                    delay: function(el, i) {
                        return 200 * (i + 1);
                    }
                });
            }

            function setupIntersectionObservers() {
                // Observer untuk animasi fitur saat discroll
                const featuresObserver = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            anime({
                                targets: '.feature-card',
                                translateY: [50, 0],
                                opacity: [0, 1],
                                easing: "easeOutQuad",
                                duration: 800,
                                delay: function(el, i) {
                                    return i * 200;
                                }
                            });
                            featuresObserver.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.2
                });

                const featuresSection = document.getElementById('features-section');
                if (featuresSection) {
                    featuresObserver.observe(featuresSection);
                }

                // Observer untuk animasi statistik
                const statsObserver = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            // Animasi counting untuk statistik
                            anime({
                                targets: '.stat-number',
                                innerHTML: function(el) {
                                    const finalValue = el.getAttribute('data-value');
                                    return [0, finalValue];
                                },
                                round: 1,
                                easing: 'easeInOutExpo',
                                duration: 2000,
                                delay: function(el, i) {
                                    return i * 300;
                                }
                            });
                            statsObserver.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.2
                });

                const statsSection = document.getElementById('stats-section');
                if (statsSection) {
                    statsObserver.observe(statsSection);
                }

                // Observer untuk animasi CTA
                const ctaObserver = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            anime({
                                targets: '.cta-section',
                                translateY: [50, 0],
                                opacity: [0, 1],
                                easing: "easeOutQuad",
                                duration: 800
                            });
                            ctaObserver.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.2
                });

                const ctaSection = document.getElementById('cta-section');
                if (ctaSection) {
                    ctaObserver.observe(ctaSection);
                }
            }

            function createFallingLeaves() {
                const container = document.getElementById('leaves-container');
                if (!container) return;

                const containerWidth = container.offsetWidth;
                const containerHeight = container.offsetHeight;

                // Create more leaves with staggered timing
                for (let i = 0; i < 20; i++) {
                    createSingleLeaf(container, containerWidth, containerHeight, i * 300);
                }
            }

            function createSingleLeaf(container, containerWidth, containerHeight, delay = 0) {
                const leaf = document.createElement('div');
                leaf.className = 'absolute w-6 h-6'; // Slightly larger for better visibility

                // Random leaf color (green/yellow/orange)
                const colors = ['text-green-500', 'text-green-600', 'text-green-500', 'text-green-600', 'text-green-500'];
                leaf.classList.add(colors[Math.floor(Math.random() * colors.length)]);

                // Different leaf shapes
                const leafShapes = [
                    `<svg viewBox="0 0 64 64" fill="currentColor"><path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.06.82C6.16 17.4 9 14 17 14V8zm0 0V2l6 3-6 3z"/></svg>`,
                    `<svg viewBox="0 0 64 64" fill="currentColor"><path d="M24 4c-5 8-7 14-7 20 0 6 2 12 7 20 5-8 7-14 7-20 0-6-2-12-7-20z"/></svg>`,
                    `<svg viewBox="0 0 64 64" fill="currentColor"><path d="M24 4c-2 4-3 8-3 12s1 8 3 12c2-4 3-8 3-12s-1-8-3-12z"/></svg>`
                ];
                leaf.innerHTML = leafShapes[Math.floor(Math.random() * leafShapes.length)];

                // Random starting position
                const startPosX = Math.random() * containerWidth;
                leaf.style.left = startPosX + 'px';
                leaf.style.top = '-30px';

                // Random scale for variety
                const scale = 0.5 + Math.random() * 0.7;
                leaf.style.transform = `scale(${scale})`;

                container.appendChild(leaf);

                // Animation parameters
                const duration = 8000 + Math.random() * 5000; // Longer duration for smoother fall
                const xMovement = (Math.random() - 0.5) * 200; // More side-to-side movement

                // Improved animation with more natural movement
                anime({
                    targets: leaf,
                    translateY: containerHeight + 50,
                    translateX: xMovement,
                    rotate: {
                        value: function() {
                            return [0, 360 + Math.random() * 180]; // More rotation
                        },
                        easing: 'linear'
                    },
                    opacity: [{
                            value: 0,
                            duration: 0
                        },
                        {
                            value: 0.8 + Math.random() * 0.2,
                            duration: 3000
                        }, // Random peak opacity
                        {
                            value: 0,
                            duration: 1000
                        }
                    ],
                    easing: function(el, i, total) {
                        // Custom easing for more natural fall
                        const rand = 0.5 + Math.random() * 0.3;
                        return function(progress) {
                            return Math.pow(progress, rand);
                        };
                    },
                    duration: duration,
                    delay: delay + Math.random() * 3000,
                    complete: function() {
                        if (leaf.parentNode) {
                            leaf.remove();
                        }
                        // Create new leaf with higher probability for continuous effect
                        if (container && Math.random() > 0.2) {
                            setTimeout(function() {
                                createSingleLeaf(container, containerWidth, containerHeight);
                            }, Math.random() * 2000);
                        }
                    }
                });
            }

            // Smooth scroll untuk navigasi (jika ada)
            document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Tambahkan event listener untuk tombol CTA
            document.querySelectorAll('.cta-button, .final-cta').forEach(function(button) {
                button.addEventListener('click', function() {
                    // Animasi klik
                    anime({
                        targets: this,
                        scale: [1, 0.95, 1],
                        duration: 200,
                        easing: 'easeInOutQuad'
                    });

                    // Di sini Anda bisa menambahkan logika untuk redirect atau modal
                    console.log('Button clicked:', this.textContent.trim());

                    // Contoh: redirect ke halaman pendaftaran
                    // window.location.href = '/register';
                });
            });

            // Optimasi performa: pause animasi saat tab tidak aktif
            document.addEventListener('visibilitychange', function() {
                const leaves = document.querySelectorAll('#leaves-container > div');
                if (document.hidden) {
                    // Pause atau hapus animasi daun saat tab tidak aktif
                    leaves.forEach(function(leaf) {
                        if (leaf.parentNode) {
                            leaf.remove();
                        }
                    });
                } else {
                    // Resume animasi saat tab aktif kembali
                    setTimeout(createFallingLeaves, 1000);
                }
            });

            // Responsive handling
            let resizeTimeout;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function() {
                    // Restart falling leaves animation with new dimensions
                    const container = document.getElementById('leaves-container');
                    if (container) {
                        // Clear existing leaves
                        container.innerHTML = '';
                        // Restart animation
                        setTimeout(createFallingLeaves, 500);
                    }

                    // Re-setup hero title if needed
                    const titleElement = document.getElementById('hero-title');
                    if (titleElement && titleElement.children.length === 0) {
                        setupHeroTitle();
                    }
                }, 250);
            });
        </script>
    </body>

</html>
